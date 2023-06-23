<?php

namespace Tests\Integration\PIX\StaticPayment;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinPixStaticPayment;

class PixGetStaticPaymentQRTest extends TestCase
{

    /**
     * @return void
     * @throws RequestException
     */
    final public function testSuccess(): void
    {
        $transactionId = 12731081;
        $url = sprintf(CelcoinPixStaticPayment::GET_STATIC_PAYMENT_QR_ENDPOINT, $transactionId);
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

        $pix = new CelcoinPixStaticPayment();
        $response = $pix->getStaticPaymentQR($transactionId);

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
        $transactionId = 12731081;
        $url = sprintf(CelcoinPixStaticPayment::GET_STATIC_PAYMENT_QR_ENDPOINT, $transactionId);

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
        $pix = new CelcoinPixStaticPayment();
        $response = $pix->getStaticPaymentQR($transactionId);

        $this->assertEquals($status, $response['code']);
    }

    /**
     * @return array[]
     */
    private function errorDataProvider(): array
    {
        return [
            [fn() => self::stubGenericError(400), 400],
            [fn() => self::stubGenericError(404), 404],
            [fn() => self::stubGenericError(500), 500],
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
