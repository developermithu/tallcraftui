<?php

return [
    /**
     * Default prefix for all components
     *
     * Note: After changing the prefix, clear the view cache
     * using `php artisan view:clear`
     *
     * Examples:
     * prefix => ''         // <x-input />
     * prefix => 'tall-'    // <x-tall-input />
     */
    'prefix' => '',

    /**
     * Icons configuration
     */
    'icons' => [
        /**
         * ---------------------------
         * Allowed icons: heroicons,
         * ---------------------------
         */
        'type' => 'heroicons',

        /**
         * --------------------
         * Default icon style
         * --------------------
         *
         * Allowed values: outline, solid
         */
        'style' => 'outline',
    ],
];
