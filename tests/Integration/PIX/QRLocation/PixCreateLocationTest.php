<?php

namespace Tests\Integration\PIX\QRLocation;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinPIXQR;
use WeDevBr\Celcoin\Types\PIX\Merchant;
use WeDevBr\Celcoin\Types\PIX\QRLocation;

class PixCreateLocationTest extends TestCase
{

    /**
     * @return void
     * @throws RequestException
     */
    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPIXQR::CREATE_LOCATION_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $location = $this->fakeLocationBody();
        $pix = new CelcoinPIXQR();
        $response = $pix->createLocation($location);

        $this->assertEquals('CREATED', $response['status']);
    }

    /**
     * @return PromiseInterface
     */
    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 'CREATED',
                'clientRequestId' => '9b26edb7cf254db09f5449c94bf13abc',
                'merchant' => [
                    'postalCode' => '01201005',
                    'city' => 'Barueri',
                    'merchantCategoryCode' => '0000',
                    'name' => 'Celcoin'
                ],
                'url' => 'api-h.developer.btgpactual.com/v1/p/v2/f5d3c300f49442149d996c3dccc8860e',
                'emv' => '00020101021226930014br.gov.bcb.pix2571api-h.developer.btgpactual.com/v1/p/v2/f5d3c300f49442149d996c3dccc8860e5204000053039865802BR5907Celcoin6007Barueri61080120100562070503***630411BD',
                'type' => 'COBV',
                'locationId' => 12731081
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @return QRLocation
     */
    private function fakeLocationBody(): QRLocation
    {
        $merchant = new Merchant();
        $merchant->postalCode = '01201005';
        $merchant->city = 'Barueri';
        $merchant->merchantCategoryCode = '0000';
        $merchant->name = 'Celcoin Pagamentos';

        $location = new QRLocation();
        $location->merchant = $merchant;
        $location->type = 'COBV';
        $location->clientRequestId = '9b26edb7cf254db09f5449c94bf13abc';
        return $location;
    }

    /**
     * @param Closure $response
     * @param string $errorCode
     * @return void
     * @throws RequestException
     * @dataProvider errorDataProvider
     */
    final public function testConvertingValueError(Closure $response, string $errorCode): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPIXQR::CREATE_LOCATION_ENDPOINT
                ) => $response
            ]
        );

        $this->expectException(RequestException::class);

        try {
            $location = $this->fakeLocationBody();
            $pix = new CelcoinPIXQR();
            $pix->createLocation($location);
        } catch (RequestException $exception) {
            $response = $exception->response->json();
            $this->assertEquals($errorCode, $response['errorCode']);
            throw $exception;
        }
    }

    /**
     * @uses https://developers.celcoin.com.br/reference/criar-um-qrcode-location
     * @return array[]
     */
    private function errorDataProvider(): array
    {
        return [
            'status code 400' => [fn() => self::stubConvertingError(), '400'],
            'status code CR001' => [fn() => self::stubValueCannotBeNull(), 'CR001']
        ];
    }

    /**
     * @return PromiseInterface
     */
    static private function stubConvertingError(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'Error converting value \'xxx\' to \'type\' \'Pactual.BaaS.Entities.Pix.LocationType\'. Path \'type\', line 3, position 17.',
                'errorCode' => '400',
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @return PromiseInterface
     */
    static private function stubValueCannotBeNull(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'Value cannot be null. (Parameter \'s\')',
                'errorCode' => 'CR001',
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
