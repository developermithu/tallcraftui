<?php

return [
    /**
     * 
     * ==================================
     * Default prefix for all components
     * ==================================
     *
     * Note: After changing the prefix, clear the view cache
     * using `php artisan view:clear`
     *
     * Examples:
     *
     * prefix => ''       // <x-input />
     * prefix => 'tc-'   // <x-tc-input />
     *
     */
    'prefix' => '',

    /**
     * 
     * type => Allowed: heroicons
     * style => Allowed: outline, solid
     *
     */
    'icons' => [
        'type' => 'heroicons',
        'style' => 'outline',
    ],

    /**
     * 
     * border-radius => Allowed: rounded, rounded-sm, rounded-md, rounded-lg, rounded-xl, rounded-2xl, rounded-3xl, rounded-full, rounded-none
     *
     */
    'alert' => [
        'border-radius' => 'rounded',
    ],

    'badge' => [
        'border-radius' => 'rounded',
    ],

    'breadcrumb' => [
        'border-radius' => 'rounded',
    ],

    /**
     * 
     * size => Allowed: sm, md, lg, xl, 2xl
     *
     */
    'button' => [
        'border-radius' => 'rounded',
        'size' => 'md',
    ],

    /**
     * 
     * size => Allowed: sm, md, lg, xl, 2xl
     *
     */
    'checkbox' => [
        'border-radius' => 'rounded',
        'size' => 'md',
    ],

    /**
     * 
     * position => Allowed: top, bottom, left, right
     * size => Allowed: w-20, w-24, w-28, w-32, w-36, w-40, w-44, w-48, w-52, w-56, w-60, w-64, w-72, w-80, w-96, w-full
     *
     */
    'dropdown' => [
        'border-radius' => 'rounded',
        'position' => 'top',
        'size' => 'w-48',
    ],

    'input' => [
        'border-radius' => 'rounded',
    ],

    /**
     * 
     * size => Allowed: sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, full
     * blur => Allowed: true, false
     * position => Allowed: top, bottom, left, right, center
     *
     */
    'modal' => [
        'border-radius' => 'rounded-lg',
        'size' => 'lg',
        'blur' => false,
        'position' => 'top',
    ],

    /**
     * 
     * size => Allowed: sm, md, lg, xl, 2xl
     *
     */
    'radio' => [
        'size' => 'md',
    ],

    'select' => [
        'border-radius' => 'rounded',
    ],

    'textarea' => [
        'border-radius' => 'rounded',
    ],

    'toggle' => [
        'border-radius' => 'rounded',
    ],
];
