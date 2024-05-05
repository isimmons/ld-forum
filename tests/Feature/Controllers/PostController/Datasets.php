<?php

/**
 * A valid title property for a post is required
 * and must be a string of min 3 and max 120 characters.
 *
 * A valid body property for a post is required
 * and must be a string of min 100 and max 10,000 characters.
 */
dataset(name: 'invalid_post_data', dataset: [
    [[ 'title' =>  null ], 'title'],
    [[ 'title' =>  1 ], 'title'],
    [[ 'title' =>  2.5 ], 'title'],
    [[ 'title' =>  true ], 'title'],
    [[ 'title' =>  false ], 'title'],
    [[ 'title' =>  str_repeat('a', 9) ], 'title'],
    [[ 'title' =>  str_repeat('a', 121) ], 'title'],

    [[ 'topic_id' =>  null ], 'topic_id'],
    [[ 'topic_id' =>  -1 ], 'topic_id'], // can't exist in the db
    [[ 'topic_id' =>  'a' ], 'topic_id'],
    [[ 'topic_id' =>  2.5 ], 'topic_id'],

    [[ 'body' =>  null ], 'body'],
    [[ 'body' =>  1 ], 'body'],
    [[ 'body' =>  2.5 ], 'body'],
    [[ 'body' =>  true ], 'body'],
    [[ 'body' =>  false ], 'body'],
    [[ 'body' =>  str_repeat('a', 99) ], 'body'],
    [[ 'body' =>  str_repeat('a', 10_001) ], 'body'],
]);
