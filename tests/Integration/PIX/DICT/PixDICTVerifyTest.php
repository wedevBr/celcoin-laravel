<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\DICT;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXDICT;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX\DICT;

use function PHPUnit\Framework\assertEquals;

class PixDICTVerifyTest extends TestCase
{

    /**
     * @throws RequestException
     */
    public function testVerifyDICT()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::POST_VERIFY_DICT => self::stubSuccess(),
            ],
        );

        $pixDict = new CelcoinPIXDICT();
        $result = $pixDict->verifyDICT($this->fakeDictBody());

        assertEquals('SUCCESS', $result['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "SUCCESS",
                "keys" => [
                    [
                        "key" => "+551199995555",
                        "hasEntry" => false,
                    ],
                    [
                        "key" => "key@email.com",
                        "hasEntry" => false,
                    ],
                    [
                        "key" => "11000893000109",
                        "hasEntry" => true,
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }

    private function fakeDictBody(): DICT
    {
        return new DICT([
            "keys" => [
                [
                    "key" => "+551199995555",
                ],
                [
                    "key" => "key@email.com",
                ],
                [
                    "key" => "11000893000109",
                ],
            ],
        ]);
    }

    public function testVerifyDictNotFound()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::POST_VERIFY_DICT => self::stubNotFound(),
            ],
        );

        $this->expectException(RequestException::class);

        $pixDict = new CelcoinPIXDICT();
        $pixDict->verifyDICT($this->fakeDictBody());
    }

    private static function StubNotFound(): PromiseInterface
    {
        return Http::response([
            "statusCode" => 404,
            "message" => "Resource not found",
        ], Response::HTTP_NOT_FOUND);
    }

    public function testSearchDictInternalServerError()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::POST_VERIFY_DICT => Http::response([], Response::HTTP_INTERNAL_SERVER_ERROR),
            ],
        );

        $this->expectException(RequestException::class);

        $pixDict = new CelcoinPIXDICT();
        $pixDict->verifyDICT($this->fakeDictBody());
    }

    /**
     * @throws RequestException
     */
    public function testVerifyDictValidationError()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::POST_VERIFY_DICT => self::stubSuccess(),
            ],
        );

        $this->expectException(ValidationException::class);

        $pixDict = new CelcoinPIXDICT();
        $pixDict->verifyDICT(new DICT([]));
    }
}