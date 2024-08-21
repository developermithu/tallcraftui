<?php

use Developermithu\Tallcraftui\Enums\BorderRadius;
use Developermithu\Tallcraftui\Enums\Position;
use Developermithu\Tallcraftui\Enums\Shadow;
use Developermithu\Tallcraftui\Enums\Size;
use Developermithu\Tallcraftui\Enums\Width;

return [

    /**
     * --------------------------------------------------------------------------
     * Default Component Prefix
     * --------------------------------------------------------------------------
     *
     * The prefix applied to all components. After changing this value, be sure
     * to clear the view cache using `php artisan view:clear`.
     *
     * Examples:
     *
     * 'prefix' => ''       // <x-input />
     * 'prefix' => 'tc-'    // <x-tc-input />
     * 
     */
    'prefix' => '',

    /**
     * --------------------------------------------------------------------------
     * Icon Configuration
     * --------------------------------------------------------------------------
     *
     * The default icon settings for the components. You can specify the type
     * and style of icons that should be used.
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
     * --------------------------------------------------------------------------
     * UI Components
     * --------------------------------------------------------------------------
     *
     * Configure the appearance and behavior of ui components.
     */
    'alert' => [
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'badge' => [
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'breadcrumb' => [
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'button' => [
        'size' => Size::MD->value,
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'dropdown' => [
        'width' => Width::W48->value,
        'shadow' => Shadow::Shadow->value,
        'position' => Position::TOP->value,
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'modal' => [
        'size' => Size::LG->value,
        'blur' => false, // Allowed: true, false
        'position' => Position::TOP->value,
        'border-radius' => BorderRadius::RoundedLg->value,
    ],

    'stat' => [
        'border-radius' => BorderRadius::RoundedLg->value,
    ],

    'menu' => [
        'width' => Width::W56->value,
        'shadow' => Shadow::Shadow->value,
        'border-radius' => BorderRadius::RoundedMd->value,
    ],

    /**
     * --------------------------------------------------------------------------
     * Form Components
     * --------------------------------------------------------------------------
     *
     * Configure the appearance and behavior of form components.
     */
    'checkbox' => [
        'size' => Size::MD->value,
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'input' => [
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'radio' => [
        'size' => Size::MD->value,
    ],

    'select' => [
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'textarea' => [
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'toggle' => [
        'border-radius' => BorderRadius::Rounded->value,
    ],
];
