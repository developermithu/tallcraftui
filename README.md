## Tallcraft Ui Package V0.8

Use like this anywhere

```blade
<x-tall-button label="Button" />
```

## Icon

We are using [Blade Hero Icons](https://blade-ui-kit.com/blade-icons?set=1#search)

Blade Heroicons also offers the ability to use features from Blade Icons like default classes, default attributes, etc. If you'd like to configure these, publish the blade-heroicons.php config file:

```
php artisan vendor:publish --tag=blade-heroicons-config
```

```php
<?php 

return [
    /*
    |-----------------------------------------------------------------
    | Default Set Classes
    |-----------------------------------------------------------------
    */

    'class' => 'w-6 h-6',
```

And clear the cache after changing `blade-heroicons.php` file.

```
php artisan view:clear
```

### Using Spinner

with forms

```php
<form wire:submit="create" class="space-y-5">
    <x-input label="Name *" wire:model="name" />
    <x-input label="Email *" wire:model="email" />
    
    <x-button label="Submit" spinner="create" />
</form>
```

with button

```php
<x-button label="Save" wire:click="save" spinner />
```

## Installation

```bash
composer require developermithu/tallcraftui

php artisan install:tallcraftui
```

## Publish the configuration file

 To rename tallcraftui components with a custom prefix, first publish the configuration file:
 
```bash
php artisan vendor:publish --tag=tallcraftui-config
```


/config/tallcraftui.php

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