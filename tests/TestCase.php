<?php

namespace WeDevBr\Celcoin\Tests;

use Dotenv\Dotenv;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Orchestra\Testbench\Concerns\CreatesApplication;
use WeDevBr\Celcoin\CelcoinServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            CelcoinServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $root = __DIR__ . '/../';
        $dotenv = Dotenv::createImmutable($root);
        $dotenv->safeLoad();
        $app['config']->set('cache.default', env('CACHE_DRIVER', 'file'));
        $app['config']->set('celcoin.client_id', env('CELCOIN_CLIENT_ID', null));
        $app['config']->set('celcoin.client_secret', env('CELCOIN_CLIENT_SECRET', null));
        $app['config']->set('celcoin.mtls_cert_path', env('CELCOIN_MTLS_CERT_PATH', null));
        $app['config']->set('celcoin.mtls_key_path', env('CELCOIN_MTLS_KEY_PATH', null));
        $app['config']->set('celcoin.mtls_passphrase', env('CELCOIN_MTLS_PASSPHRASE', null));
    }
}
