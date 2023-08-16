# Celcoin Laravel API Wrapper

This package is an **UNOFFICIAL** API Wrapper for [Celcoin API](https://developers.celcoin.com.br/).

## Requirements

- PHP >= 8.1
- Laravel >= 8.x

## Installation

You can install the package via composer:

```bash
composer require wedevbr/celcoin-laravel
```

After install, just publish your config files:

```bash
php artisan vendor:publish --provider="WeDevBr\Celcoin\CelcoinServiceProvider"
```

## Usage

First you need to set up your credentials. Define
yours `CELCOIN_CLIENT_SECRET`, `CELCOIN_CLIENT_ID`, `CELCOIN_LOGIN_URL` and `CELCOIN_API_URL` at .env file.

### Security

If you discover any security related issues, please email adeildo.amorim@wedev.software instead of using the issue
tracker.

## Credits

- [We Dev Tecnologia LTDA](https://github.com/wedevbr)
- [Aron Peyroteo Cardoso](https://github.com/aronpc)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.