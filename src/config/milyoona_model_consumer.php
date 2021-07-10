<?php

return [
    'all_migrations' => [
        'users', 'terminals', 'transactions', 'products'
    ],
    /*
     * If a migration is base table of microservice, use a ':' after migration name, e.g. 'users:'
     */
    'publish_migration' => [
        //
    ],
    'queue_name' => null // e.g. 'ml_user'
];
