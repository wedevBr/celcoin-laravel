<?php

return [
    'login_url' => env('CELCOIN_LOGIN_URL', 'https://sandbox.openfinance.celcoin.dev/v5/token'), // Default value set to Production
    'api_url' => env('CELCOIN_API_URL', 'https://sandbox.openfinance.celcoin.dev'), // Defaults value set to Production
    'mtls_cert_path' => env('CELCOIN_MTLS_CERT_PATH', null), // Path to mTLS cert
    'mtls_key_path' => env('CELCOIN_MTLS_KEY_PATH', null), // Path to mTLS key
    'mtls_passphrase' => env('CELCOIN_MTLS_PASSPHRASE', null), // mTLS passphrase
    'client_id' => env('CELCOIN_CLIENT_ID', null), // Your client ID provided by celcoin staff
    'client_secret' => env('CELCOIN_CLIENT_SECRET', null), // Your client secret provided by celcoin staff
];
