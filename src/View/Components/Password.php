<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Password extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $hint = null,
        public ?bool $inline = false,
        public ?bool $generate = false,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('input', $this->attributes);
    }

    public function iconLeftClass(): string
    {
        return $this->icon || $this->iconLeft ? 'pl-9' : '';
    }

    public function disableClass(): string
    {
        return $this->attributes->get('disabled') ? 'bg-gray-200 opacity-80 cursor-not-allowed' : '';
    }

    public function readonlyClass(): string
    {
        return $this->attributes->get('readonly') ? 'bg-gray-200 opacity-80 border-gray-400 border-dashed pointer-events-none' : '';
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div 
                x-data="{ 
                    show: false, 
                    password: @entangle($attributes->wire('model')->value()) ?? '',
                    generatePassword() {
                        const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+{}[]|:;<>,.?/~`';
                        let newPassword = '';
                        for (let i = 0; i < 10; i++) {
                            newPassword += charset.charAt(Math.floor(Math.random() * charset.length));
                        }
                        this.password = newPassword;
                    }
                }"  
                          
                @class(['flex items-center gap-3' => $inline])
            >
                @php
                    $name = $attributes->wire('model')->value();
                    $error = $errors->has($name) ? $errors->first($name) : null;
                    $uuid = $uuid . $name;
                    $required = $attributes->get('required') ? true : false;

                    $errorClass = $error ? 'border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 focus:ring-red-500': '';
                @endphp
            
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required" :inline="$inline" {{ $attributes->twMergeFor('label') }} />
                 @endif

                <div class="relative flex items-center flex-1">
                    @if($iconLeft || $icon)
                        <span class="absolute inset-y-0 grid w-10 start-0 place-content-center">
                            <x-tc-icon :name="$iconLeft ?? $icon" {{ $attributes->twMergeFor('icon', 'dark:text-gray-400 size-4') }} />
                        </span>
                    @endif

                    <div class="w-full">
                        <input
                            id="{{ $uuid }}"
                            :type="show ? 'text' : 'password'"
                            x-model="password"
                            placeholder="{{ $attributes->whereStartsWith('placeholder')->first() }}"
                            autocomplete="off"
                            {{ 
                                $attributes
                                    ->withoutTwMergeClasses()
                                    ->whereDoesntStartWith('wire:model')
                                    ->twMerge([
                                        "block w-full border-gray-200 py-2.5 shadow-sm text-sm outline-none focus:ring-primary focus:border-primary dark:focus:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:placeholder-gray-400",
                                        $iconLeftClass(),
                                        $disableClass(),
                                        $readonlyClass(),
                                        $roundedClass(),
                                        $errorClass,
                                    ])
                                }} 
                            />
                    </div>

                    <span class="absolute inset-y-0 flex items-center end-3 gap-x-2">
                        @if($generate)
                            <x-heroicon-o-arrow-path-rounded-square @click="generatePassword" {{ $attributes->twMergeFor('icon', 'dark:text-gray-400 size-[18px] cursor-pointer') }} />
                        @endif
                            
                        <x-heroicon-o-eye x-cloak x-show="!show" @click="show = ! show" {{ $attributes->twMergeFor('icon', 'dark:text-gray-400 size-[18px] cursor-pointer') }} />
                        <x-heroicon-o-eye-slash x-cloak x-show="show" @click="show = ! show" {{ $attributes->twMergeFor('icon', 'dark:text-gray-400 size-[18px] cursor-pointer') }} />
                    </span>
                </div>

                @if($hint && !$error)
                    <x-tc-hint :hint="$hint" />
                @endif

                @if($error)
                    <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                @endif
            </div>
        HTML;
    }
}
