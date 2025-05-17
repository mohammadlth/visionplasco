<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'templates' => [
        'register' => 741917,
        'change_mobile' => 270827,
        'forget_password' => 229818,
        'chat_notification' => 265687,
        'status_product' => 335342,
        'store_product' => 946124,
        'warning_ban' => 463694,
        'warning_moral' => 711097,
        'warning_thief' => 686178,
        'identity_status' => 399154,
        'admin_identity_status' => 734038,
        'vip_expire' => 685756,
        'welcome_message' => 810273,
        'call_saller' => 676871,
        'login_log' => 321424,
        'reject_product' => 778596,
        'buy_plan' => 326606
    ],

    /* Important Settings */

    // ======================================================================
    // never remove 'web', just put your middleware like auth or admin (if you have) here. eg: ['web','auth']
    'middlewares' => ['web'],
    // you can change default route from sms-admin to anything you want
    'route' => 'sms-admin',
    // SMS.ir Api Key
    'api-key' => env('SMSIR_API_KEY', 'Your api key'),
    // Your sms.ir line number
    'line-number' => env('SMSIR_LINE_NUMBER', 'Your Sms.ir Line Number'),
    // ======================================================================
    // set true if you want log to the database
    'db-log' => env('SMSIR_DB_LOG', false),
    // if you don't want to include admin panel routes set this to false
    'panel-routes' => env('SMSIR_PANEL_ROUTES', false),
    /* Admin Panel Title */
    'title' => 'مدیریت پیامک ها',
    // How many log you want to show in sms-admin panel ?
    'in-page' => env('SMSIR_PANEL_IN_PAGE', false)
];
