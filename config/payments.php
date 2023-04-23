<?php
return [
    'qiwi_public_key' => env('QIWI_PUBLIC_KEY', ''),
    'qiwi_secret_key' => env('QIWI_SECRET_KEY', ''),
    'qiwi_success_url' => env('QIWI_SUCCESS_URL', ''),
    'qiwi_commission' => env('QIWI_COMISSION', ''),

    'centapp_shop_id' => env('CENTAPP_SHOP_ID', ''),
    'centapp_token' => env('CENTAPP_TOKEN', ''),

    'fk_project_id' => env('FK_PROJECT_ID', ''),
    'fk_secret_word' => env('FK_SECRET_WORD', ''),
    'fk_currency' => env('FK_CURRENCY', 'RUB'),

    'enot_merchant_id' => env('ENOT_PROJECT_ID', ''),
    'enot_secret_word' => env('ENOT_SECRET_WORD', ''),
    'enot_secret_word2' => env('ENOT_SECRET_WORD2', ''),
];
