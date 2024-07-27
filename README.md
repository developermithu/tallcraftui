# TallCraftUi  

TallCraftUI is a versatile and customizable UI package for the TALL stack **(Tailwind CSS, Alpine.js, Laravel, and Livewire)**. It provides a set of components to simplify livewire application development and seamlessly integrate with **TALL stack** projects.


<p align="center">
 <a href="https://packagist.org/packages/developermithu/tallcraftui"><img src="https://img.shields.io/packagist/v/developermithu/tallcraftui?style=flat-square" alt="Latest Version on Packagist"></a>
 <a href="https://packagist.org/packages/developermithu/tallcraftui"><img src="https://img.shields.io/packagist/dt/developermithu/tallcraftui?style=flat-square" alt="Total Downloads"></a>
 <a href="https://github.com/developermithu/tallcraftui?tab=MIT-1-ov-file"><img src="https://img.shields.io/github/license/developermithu/tallcraftui?style=flat-square" alt="GitHub license"></a>
</p>


## Basic Usage


```php
@php
 $countries = App\Models\Country::pluck('name', 'id');
@endphp

<form wire:submit="create">
    <x-input label="Name *" wire:model="name" />
    <x-input label="Email *" wire:model="email" />
    <x-select label="Country" wire:model="country_id" :options="$countries" />
    
    <x-button label="Submit" spinner="create" />
</form>
```

Error will be automatically displayed after submitting the form if it exists. You can also display all errors in this way:

```php
if($errors->any())
    <x-alert :errors="$errors->all()" danger />
@endif
```

## Installation

```bash
composer require developermithu/tallcraftui

php artisan install:tallcraftui
```

## Modify `tailwind.config.js`

```js
    theme: {
        extend: {
            colors: {
                primary: "#6d28d9",
                secondary: "#a21caf",
                tertiary: "#00BBC9",
                danger: "#b91c1c",
                warning: "#a16207",
                success: "#15803d",
                info: "#1d4ed8",
            },
        },
    },
```


## Publish the configuration file

 To rename tallcraftui components with a custom **prefix**, first publish the configuration file:
 
```bash
php artisan vendor:publish --tag=tallcraftui-config
```

```php
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
     *
     */
    'prefix' => '',
];
```

After renaming, ensure you clear the view cache:

```bash
php artisan view:clear
```
