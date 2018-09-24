<?php
return [
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
    'onesignal' => [
        'app_id' => env('ONESIGNAL_APP_ID'),
        'rest_api_key' => env('ONESIGNAL_REST_API_KEY')
    ],
];