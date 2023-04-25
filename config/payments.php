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

    'lava_shop_id' => env('LAVA_SHOP_ID', ''),
    'lava_secret' => env('LAVA_SECRET', ''),
    'lava_secret_2' => env('LAVA_SECRET_2', ''),
    'lava_jwt' => env('LAVA_JWT', ''),
    'lava_wallet_id' => env('LAVA_WALLET_ID', ''),
    'lava_commission' => env('LAVA_COMMISSION', ''),
    'lava_hook' => env('LAVA_HOOK', ''),
    'lava_success' => env('LAVA_SUCCESS', ''),
    'lava_fail' => env('LAVA_FAIL', ''),

];
