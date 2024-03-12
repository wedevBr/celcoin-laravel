<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\QRLocation;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXQR;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class PixGetLocationTest extends TestCase
{

    /**
     * @return void
     * @throws RequestException
     */
    final public function testSuccess(): void
    {
        $locationId = 12731081;
        $url = sprintf(CelcoinPIXQR::GET_LOCATION_ENDPOINT, $locationId);
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url,
                ) => self::stubSuccess(),
            ],
        );

        $pix = new CelcoinPIXQR();
        $response = $pix->getLocation($locationId);

        $this->assertEquals('CREATED', $response['status']);
        $this->assertEquals($locationId, $response['locationId']);
    }

    /**
     * @return PromiseInterface
     */
    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 'CREATED',
                'clientRequestId' => 'SANDBOXkk6g232xel65a0daee4dd13kk13040300',
                'merchant' => [
                    'postalCode' => '01201005',
                    'city' => 'Barueri',
                    'merchantCategoryCode' => '0000',
                    'name' => 'Celcoin',
                ],
                'url' => 'api-h.developer.btgpactual.com/v1/p/v2/f5d3c300f49442149d996c3dccc8860e',
                'emv' => '00020101021226930014br.gov.bcb.pix2571api-h.developer.btgpactual.com/v1/p/v2/f5d3c300f49442149d996c3dccc8860e5204000053039865802BR5907Celcoin6007Barueri61080120100562070503***630411BD',
                'type' => 'COBV',
                'locationId' => 12731081,
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * @param Closure $response
     * @param string $status
     *
     * @return void
     * @dataProvider errorDataProvider
     * @throws RequestException
     */
    final public function testErrors(Closure $response, mixed $status): void
    {
        $locationId = 12731081;
        $url = sprintf(CelcoinPIXQR::GET_LOCATION_ENDPOINT, $locationId);

        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url,
                ) => $response,
            ],
        );

        $pix = new CelcoinPIXQR();
        $response = $pix->getLocation($locationId);

        $this->assertEquals($status, $response['errorCode']);
    }

    /**
     * @return array[]
     */
    public static function errorDataProvider(): array
    {
        return [
            'status code 400' => [
                fn() => self::stubGenericError(Response::HTTP_BAD_REQUEST),
                Response::HTTP_BAD_REQUEST,
            ],
            'status code 404' => [fn() => self::stubGenericError(Response::HTTP_NOT_FOUND), Response::HTTP_NOT_FOUND],
            'status code 500' => [
                fn() => self::stubGenericError(Response::HTTP_INTERNAL_SERVER_ERROR),
                Response::HTTP_INTERNAL_SERVER_ERROR,
            ],
        ];
    }

    /**
     * @param int $status
     *
     * @return PromiseInterface
     */
    static private function stubGenericError(int $status): PromiseInterface
    {
        return Http::response(
            [
                'errorCode' => $status,
                'description' => 'Message',
            ],
        );
    }

}