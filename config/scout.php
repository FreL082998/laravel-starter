<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    |
    | This option controls the default search "driver" that will be used when
    | performing any searching operations, including the indexing of models
    | and the actual search executions. You're free to swap out the default
    | driver with any other search engines that Scout supports.
    |
    */

    'driver' => env('SCOUT_DRIVER', 'meilisearch'),

    /*
    |--------------------------------------------------------------------------
    | Index Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify a prefix that will be applied to all search indexes
    | created and managed by Scout. This prefix may be useful if you have
    | multiple applications using Scout within installations of the same
    | Elasticsearch clusters, Meilisearch servers, etc.
    |
    */

    'prefix' => env('SCOUT_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Queue Data Syncing
    |--------------------------------------------------------------------------
    |
    | This option allows you to control if the operations that sync your data
    | with your search indexes are queued. By default we disable this feature
    | so that it happens synchronously. However, you can enable it for better
    | performance.
    |
    */

    'queue' => false,

    /*
    |--------------------------------------------------------------------------
    | Meilisearch Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify any additional configuration options required for
    | Meilisearch to function properly. Meilisearch is a fast search engine
    | built for relevancy and typo tolerance.
    |
    */

    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://127.0.0.1:7700'),
        'secret' => env('MEILISEARCH_KEY', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Soft Deletes
    |--------------------------------------------------------------------------
    |
    | This option allows Scout to index soft deleted models so that they may
    | be restored later. By default, Scout will exclude soft deleted models
    | from your search indexes. You may change that here.
    |
    */

    'soft_delete' => false,

];
