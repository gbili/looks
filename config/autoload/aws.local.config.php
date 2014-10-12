<?php

/*
 * This contains configuration for the ZF2 AWS SDK for PHP wrapper.
 * Place this file in `$PROJECT_ROOT/config/autoload` (don't forget to remove
 * the .dist extension). Change it however you need for your project.
 */

return array(
    'aws' => array(
        'key' => getenv('AWS_ACCESS_KEY_ID'),
        'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
        'region' => 'eu-west-1',
        'bucket' => getenv('S3_BUCKET'),
    ),
    'aws_zf2' => array(
        'session' => array(
            'save_handler' => array(
                'dynamodb' => array(
                    // Locking strategy used for doing session locking.
                    // 'locking_strategy' => null,

                    // DynamoDb client object used for performing DynamoDB
                    // operations.
                    //
                    // Note: you most likely want to leave this alone and allow
                    // the factory to fetch your configured instance of
                    // DynamoDB. However, if you override it with an object, we
                    // will respect that choice.
                    // 'dynamodb_client' => null,

                    // Name of the DynamoDB table in which to store the
                    // sessions.
                    // 'table_name' => 'sessions',

                    // Name of the hash key in the DynamoDB sessions table.
                    // 'hash_key' => 'id',

                    // Lifetime of an inactive session before it should be
                    // garbage collected. Similar to PHP's
                    // session.gc_maxlifetime
                    // 'session_lifetime' => 1440,

                    // Whether or not to use DynamoDB consistent reads for
                    // GetItem.
                    // 'consistent_read' => true,

                    // Whether or not to use PHP's session auto garbage
                    // collection triggers.
                    //
                    // Note that you may want this to be false in production,
                    // and use a separate process to garbage collect old
                    // sessions.
                    // 'automatic_gc' => true,

                    // Batch size used for removing expired sessions during
                    // garbage collection.
                    // 'gc_batch_size' => 25,

                    // Delay between service operations during garbage
                    // collection.
                    // 'gc_operation_delay' => 0,

                    // Maximum time (in seconds) to wait to acquire a lock before giving up
                    // 'max_lock_wait_time' => 10,

                    // Minimum time (in microseconds) to wait between attempts to acquire a lock
                    // 'min_lock_retry_microtime' => 10000,

                    // Maximum time (in microseconds) to wait between attempts to acquire a lock
                    // 'max_lock_retry_microtime' => 50000,
                )
            )
        )
    )
);
