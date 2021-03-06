<?php
return [
    /*
    |--------------------------------------------------------------------------
    | elastic config
    |--------------------------------------------------------------------------
    |
    | The elastic config. hosts..
    |
    */
    'elastic' =>[
        'hosts' => [
            '127.0.0.1:9200'
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    |
    | The index name. Change it to the name of your application or something
    | else meaningful.
    |
    */
    'index' => 'default',
    /*
    |--------------------------------------------------------------------------
    | Auto Index
    |--------------------------------------------------------------------------
    |
    | When enabled, indexes will be set automatically on create, save or delete.
    | Disable it to have manual control over indexes.
    |
    */
    'auto_index' => true
];