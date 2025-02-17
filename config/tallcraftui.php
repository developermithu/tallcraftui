<?php

use Developermithu\Tallcraftui\Enums\BorderRadius;
use Developermithu\Tallcraftui\Enums\DropdownAnimation;
use Developermithu\Tallcraftui\Enums\DropdownPosition;
use Developermithu\Tallcraftui\Enums\Position;
use Developermithu\Tallcraftui\Enums\Shadow;
use Developermithu\Tallcraftui\Enums\Size;
use Developermithu\Tallcraftui\Enums\ToastPosition;
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
     */
    'prefix' => env('TALLCRAFTUI_PREFIX', ''),

    /**
     * --------------------------------------------------------------------------
     * Route Prefix
     * --------------------------------------------------------------------------
     */
    'route_prefix' => env('TALLCRAFTUI_ROUTE_PREFIX', 'tallcraftui'),

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
    'avatar' => [
        'border-radius' => BorderRadius::RoundedFull->value,
    ],

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

    'card' => [
        'shadow' => Shadow::ShadowSm->value,
        'border-radius' => BorderRadius::RoundedLg->value,
    ],

    'dropdown' => [
        'width' => Width::W48->value,
        'shadow' => Shadow::Shadow->value,
        'position' => DropdownPosition::BOTTOM_END->value,
        'animation' => DropdownAnimation::FADE->value,
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'drawer' => [
        'width' => 'lg', // Allowed: sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, full
        'blur' => false,
        'trap-focus' => true,
    ],

    'modal' => [
        'size' => Size::LG->value,
        'blur' => false, // Allowed: true, false
        'trap-focus' => true, // Allowed: true, false
        'position' => Position::TOP->value,
        'border-radius' => BorderRadius::RoundedLg->value,
    ],

    'progress' => [
        'size' => Size::MD->value,
    ],

    'stat' => [
        'border-radius' => BorderRadius::RoundedLg->value,
    ],

    'table' => [
        'shadow' => Shadow::ShadowNone->value,
        'border-radius' => BorderRadius::RoundedLg->value,
    ],

    'tooltip' => [
        'position' => Position::TOP->value,
        'gradient' => false,
        'noArrow' => false,
        'noTransition' => false,
    ],

    'toast' => [
        'position' => ToastPosition::BOTTOM_RIGHT->value,
        'showCloseIcon' => false,
        'showProgress' => false,
        'timeout' => 3000,
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
        'size' => Size::MD->value,
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'select' => [
        'size' => Size::MD->value,
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'radio' => [
        'size' => Size::MD->value,
    ],

    'rating' => [
        'size' => Size::MD->value,
    ],

    'textarea' => [
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'toggle' => [
        'border-radius' => BorderRadius::Rounded->value,
    ],

    'markdown' => [
        'config' => [
            'spellChecker' => false,
            'autofocus' => false,
            'uploadImage' => false, // add drag & drop image upload feature
            'imageAccept' => 'image/png, image/jpeg, image/gif, image/avif',
            'minHeight' => '150px',
            'maxHeight' => '400px',
            'toolbar' => [
                'bold',
                'italic',
                'heading',
                '|',
                'quote',
                'unordered-list',
                'ordered-list',
                '|',
                'link',
                // 'image', // display image markdown syntax
                'upload-image', // open browser file window to upload image
                'table',
                '|',
                'preview',
                'side-by-side',
                'fullscreen',
                '|',
                'guide',
            ],
        ],
    ],
];
