# TallCraftUi  

TallCraftUI is a versatile and customizable UI package designed for the TALL stack **(Tailwind CSS, Alpine.js, Laravel, and Livewire)**. It provides a set of components to simplify livewire application development and seamlessly integrate with **TALL stack** projects.

## Available Components

1. - [x] Alert
2. - [x] Button
3. - [x] Icon
4. - [x] Input
5. - [x] Textarea
6. - [x] Radio
7. - [x] Select
8. - [x] Checkbox
9. - [ ] Toogle
10. - [ ] Badge
11. - [ ] Avatar
12. - [ ] Dropdown
13. - [ ] Breadcrumb
14. - [ ] Modal
15. - [ ] Form
16. - [ ] Table
 
Full documentation comming soon. Stay tuned!


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