<?php

/**
 * Project image discovery for migrating static /assets/... files into storage.
 *
 * "directory" is relative to public/assets/images/
 */
return [

    'discover_galleries' => [
        // Reference HTML portfolio — full carousel set under assets/images/projects/projects/1
        'haringey-broadwater-farm-community-centre' => [
            'directory' => 'projects/projects/1',
            'sort' => 'natural',
        ],
        // Broadwater Farm estate fire safety — matches ProjectSeeder gallery set
        'designer-apartment' => [
            'directory' => 'projects/projects/2',
            'sort' => 'natural',
        ],
    ],

];
