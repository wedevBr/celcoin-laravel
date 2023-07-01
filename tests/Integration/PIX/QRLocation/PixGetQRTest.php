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

class PixGetQRTest extends TestCase
{

    /**
     * @return void
     * @throws RequestException
     */
    final public function testSuccess(): void
    {
        $locationId = 12731081;
        $url = sprintf(CelcoinPIXQR::GET_QR_LOCATION_ENDPOINT, $locationId);
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url
                ) => self::stubSuccess()
            ]
        );

        $pix = new CelcoinPIXQR();
        $response = $pix->getQR($locationId);

        $this->assertEquals(200, $response['status']);
        $this->assertArrayHasKey('base64image', $response);
    }

    /**
     * @return PromiseInterface
     */
    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => 200,
                "base64image" => "iVBORw0KGgoAAAANSUhEUgAAAJMAAACTAQMAAACwK7lWAAAABlBMVEX///8AAABVwtN+AAACA0lEQVRIieWWMY7jMAxFaahQJ19AgK6hTleSL+DYF7CvpE7XEKALOJ0LwZzvJLuzW41YjxAg8QtAiOTnp4l+2xmZF1IXOT4pBr4kzJDaQhm5MtfL41HCQl0CH6EZKrPnTcj2Uy1ecXaLnK25DEykyUjZK4/o2xws/Zfbzwz123z9fL5r2sVwhkzk3Zrc8t26LnZXPTnmNuTK2UYJG1KLGt/uCnYmSxJmgkLtDyoRqvFlFjHdpoxgNOX6zIUkjDzv7BaNPNDzYiTMeGt8vUIbklqzuiRsON3l1eYB7COVKGKpPRJzUpeua3prrZcRfp40ngU12KgeEjZwm061Z7d5PMkY+VvjMzWj8U/dJMxQG1G5ZAe2ht416Gb3TGC2bPQQDi8ShlmcMBm6UChGvzXezbTbdImh0A2KiOHuU7bT6fZkKbzr1828uzRDa1Mqs3Yihm4P530jKA4OOotYZqiMM0xX8dmMhCEYbkGBF/T8r+77GHz30BbBNn3fhSRsTM1glLFqEqOEUcIMkjgxl7f/PXMTMvs4Yfbw3bpyXWQMtoeeI1J78Ce3TvZKhZ+MvtFMH1/rZNgze0blUIP6x3d7GfbbCpXBBTUAHyKGnZwgtzvYg4sRMjhQvHVaRryGCNnO9QgQqftHa32M1M4wodfbhH6v1l527/Nw77cpq41alLDfdb4A8PuP9RyscmkAAAAASUVORK5CYII=",
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @param Closure $response
     * @param string $status
     * @return void
     * @dataProvider errorDataProvider
     * @throws RequestException
     */
    final public function testErrors(Closure $response, mixed $status): void
    {
        $locationId = 12731081;
        $url = sprintf(CelcoinPIXQR::GET_QR_LOCATION_ENDPOINT, $locationId);

        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url
                ) => $response
            ]
        );
        $pix = new CelcoinPIXQR();
        $response = $pix->getQR($locationId);

        $this->assertEquals($status, $response['code']);
    }

    /**
     * @return array[]
     */
    private function errorDataProvider(): array
    {
        return [
            'status code 400' => [fn() => self::stubGenericError(Response::HTTP_BAD_REQUEST), Response::HTTP_BAD_REQUEST],
            'status code 404' => [fn() => self::stubGenericError(Response::HTTP_NOT_FOUND), Response::HTTP_NOT_FOUND],
            'status code 500' => [fn() => self::stubGenericError(Response::HTTP_INTERNAL_SERVER_ERROR), Response::HTTP_INTERNAL_SERVER_ERROR],
        ];
    }

    /**
     * @param int $status
     * @return PromiseInterface
     */
    static private function stubGenericError(int $status): PromiseInterface
    {
        return Http::response(
            [
                'code' => $status,
                'description' => 'Message',
            ]
        );
    }
}
