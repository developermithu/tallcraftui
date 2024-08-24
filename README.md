# [TallCraftUi](https://tallcraftui.developermithu.com)  

<!-- <p align="center"> -->
 <a href="https://packagist.org/packages/developermithu/tallcraftui"><img src="https://img.shields.io/packagist/v/developermithu/tallcraftui?style=flat-square" alt="Latest Version on Packagist"></a>
 <a href="https://packagist.org/packages/developermithu/tallcraftui"><img src="https://img.shields.io/packagist/dt/developermithu/tallcraftui?style=flat-square" alt="Total Downloads"></a>
 <a href="https://github.com/developermithu/tallcraftui?tab=MIT-1-ov-file"><img src="https://img.shields.io/github/license/developermithu/tallcraftui?style=flat-square" alt="GitHub license"></a>
<!-- </p> -->


## 🚀 Introduction 

**TallCraftUI** is a Laravel blade UI components library built on the **TALL stack**, providing **pre-built**, **customizable components** that seamlessly integrate with **Livewire** to create modern, responsive applications with **minimal effort**.


## 📚 Documentation

For complete documentation, please visit the official [TallCraftUI](https://tallcraftui.developermithu.com) website.


## 💻 Basic Usage

```blade
@php
    $countries = App\Models\Country::pluck('name', 'id');
@endphp

@if($errors->any())
    <x-alert :errors="$errors->all()" red />
@endif

<form wire:submit="create">
    <x-input label="Name *" wire:model="name" />
    <x-input label="Email *" wire:model="email" />
    <x-select label="Country" wire:model="country_id" :options="$countries" />
    
    <x-button label="Submit" spinner="create" />
</form>
```


## 📝 License

TallCraftUI is open-sourced software licensed under the [MIT license](https://github.com/developermithu/tallcraftui?tab=MIT-1-ov-file)
