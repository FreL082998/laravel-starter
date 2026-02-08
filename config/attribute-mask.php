<?php

// config for Irabbi360/LaravelAttributeMask
return [
    /*
    |--------------------------------------------------------------------------
    | Masking Character
    |--------------------------------------------------------------------------
    |
    | The character or string used to mask sensitive data.
    | Examples: '*', '#', '•', '***'
    |
    */
    'mask_char' => '*',

    /*
    |--------------------------------------------------------------------------
    | Text Masking Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how many characters to show at the start and end when masking
    | regular text values.
    |
    */
    'text_masking' => [
        'show_start' => 3,  // Show first 3 characters
        'show_end' => 3,    // Show last 3 characters
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Masking Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how email addresses are masked.
    | 'show_domain' => true to show full domain, false to mask it
    | 'show_start' => number of characters to show from email name
    | 'show_end' => number of characters to show at end of email name
    |
    */
    'email_masking' => [
        'show_domain' => true,  // Show the domain part
        'show_start' => 1,      // Show first 1 character
        'show_end' => 1,        // Show last 1 character
    ],

    /*
    |--------------------------------------------------------------------------
    | Phone Masking Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how phone numbers are masked.
    | 'show_start' => number of digits to show at start
    | 'show_end' => number of digits to show at end
    | 'patterns' => column name patterns to auto-detect phone fields
    |
    */
    'phone_masking' => [
        'show_start' => 3,  // Show first 3 digits
        'show_end' => 2,    // Show last 2 digits
        'patterns' => [
            'phone',
            'phone_number',
            'mobile',
            'mobile_number',
            'telephone',
            'cell',
            'cell_phone',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | URL Masking Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how URLs are masked.
    |
    */
    'url_masking' => [
        'show_protocol' => true,  // Show http:// or https://
        'show_domain' => true,    // Show domain name
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable Masking
    |--------------------------------------------------------------------------
    |
    | Set to false to completely disable attribute masking globally.
    | Can be overridden per model if needed.
    |
    */
    'enabled' => env('ENABLE_MASKING', true),

];
