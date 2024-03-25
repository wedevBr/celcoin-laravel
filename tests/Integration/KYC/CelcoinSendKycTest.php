<?php

namespace Integration\KYC;

use GuzzleHttp\Promise\PromiseInterface;
use Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use WeDevBr\Celcoin\Clients\CelcoinKyc;
use WeDevBr\Celcoin\Enums\KycDocumentEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\KYC\CreateKyc;
use WeDevBr\Celcoin\Types\KYC\KycDocument;

class CelcoinSendKycTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Storage::fake();
        $this->front = UploadedFile::fake()->image('front.jpg');
        $this->verse = UploadedFile::fake()->image('verse.jpg');
    }

    public function testSendKycSuccessful()
    {
        Http::fake([
            config('celcoin.login_url') => GlobalStubs::loginResponse(),
            sprintf(
                '%s%s',
                config('celcoin.api_url'),
                CelcoinKyc::CREATE_KYC_ENDPOINT
            ) => static::successResponse(),
        ]);
        $kyc = new CelcoinKyc();
        $body = static::getKycBody();
        $response = $kyc->createKyc(new CreateKyc($body));
        $this->assertEquals(200, $response['status']);
    }

    public function testSendKycValidationRules()
    {
        Http::fake([
            config('celcoin.login_url') => GlobalStubs::loginResponse(),
            sprintf(
                '%s%s',
                config('celcoin.api_url'),
                CelcoinKyc::CREATE_KYC_ENDPOINT
            ) => static::successResponse(),
        ]);

        $kyc = new CelcoinKyc();
        $body = static::getKycBody();
        unset($body['documentnumber']);
        $this->expectException(ValidationException::class);
        $kyc->createKyc(new CreateKyc($body));
    }

    public function testSendKycFailedRequest()
    {
        Http::fake([
            config('celcoin.login_url') => GlobalStubs::loginResponse(),
            sprintf(
                '%s%s',
                config('celcoin.api_url'),
                CelcoinKyc::CREATE_KYC_ENDPOINT
            ) => static::internalErrorResponse(),
        ]);
        $body = static::getKycBody();
        $this->expectException(RequestException::class);
        $this->expectExceptionCode(500);
        try {
            $kyc = new CelcoinKyc();
            $kyc->createKyc(new CreateKyc($body));
        } catch (RequestException $e) {
            $response = $e->response->json();
            $this->assertEquals(0, $response['errorCode']);
            throw $e;
        }
    }

    public function getKycBody(
        string $nifNumber = null,
        KycDocumentEnum $fileType = null,
        string $fileFront = null,
        string $cnpj = null,
        bool $addVerse = true
    ): array
    {
        $file = $this->front;

        $body = [
            'documentnumber' => $nifNumber ?? "11122233344",
            'filetype' => $fileType ?? KycDocumentEnum::CONTRATO_SOCIAL,
            'front' => $fileFront ?? $this->getFile($file->path()),
        ];

        if (strlen($body['documentnumber']) === 14 && empty($cnpj)) {
            $body['cnpj'] = $body['documentnumber'];
        }

        if ($addVerse) {
            $verse = $this->verse;
            $body['verse'] = $this->getFile($verse->path());
        }

        return $body;
    }

    public static function successResponse(): PromiseInterface
    {
        return Http::response([
            'status' => 200,
            'message' => "Arquivo enviado com sucesso",
        ]);
    }

    public static function notFoundResponse(): PromiseInterface
    {
        return Http::response([
            'errorCode' => 404,
            'errorMessage' => 'BackgroundCheck nao encontrado!',
        ], 404);
    }

    public static function internalErrorResponse(): PromiseInterface
    {
        return Http::response([
            'errorCode' => 0,
            'errorMessage' => 'string',
        ], 500);
    }

    public function getFile(string $path = null): KycDocument
    {
        return new KycDocument(new File($path), 'verse');
    }
}
