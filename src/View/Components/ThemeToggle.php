<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ThemeToggle extends Component
{
    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div x-data="{
                isDarkMode: false,
                init() {
                    this.isDarkMode = TallCraftUI.isDarkMode();
                    this.applyTheme();
                },
                toggleDarkMode() {
                    this.isDarkMode = !this.isDarkMode;
                    localStorage.setItem('dark-mode', this.isDarkMode);
                    this.applyTheme();
                    this.$dispatch('tallcraftui-theme-changed', { dark: this.isDarkMode });
                },
                applyTheme() {
                    document.documentElement.classList.toggle('dark', this.isDarkMode);
                }
            }"
                @tallcraftui-theme-changed.window="isDarkMode = $event.detail.dark"
                x-on:livewire:navigated.window="applyTheme()"
            >
                <script>
                    // Apply the saved theme as early as possible to avoid a flash of the wrong theme
                    window.TallCraftUI = window.TallCraftUI || {};
                    window.TallCraftUI.isDarkMode = () => localStorage.getItem('dark-mode') === 'true' ||
                        (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
                    document.documentElement.classList.toggle('dark', window.TallCraftUI.isDarkMode());
                </script>

                <label class="sr-only">Theme</label>
                <button
                    @click="toggleDarkMode()"
                    aria-label="Theme"
                    {{ $attributes
                        ->withoutTwMergeClasses()
                        ->twMerge([
                            'flex items-center justify-center w-6 h-6 p-1 xxs:w-10 xxs:h-10 xxs:p-1.5 bg-transparent rounded-full hover:bg-gray-100 dark:hover:bg-slate-700 dark:ring-inset dark:ring-white/5',
                        ])
                    }}
                >
                    <x-tc-icon
                        x-cloak
                        name="sun"
                        x-show="!isDarkMode"
                        {{ $attributes->twMergeFor('icon-light', 'text-teal-500 dark:text-teal-500') }}
                    />
                    <x-tc-icon
                        x-cloak
                        name="moon"
                        x-show="isDarkMode"
                        {{ $attributes->twMergeFor('icon-dark', 'text-teal-500 dark:text-teal-500') }}
                    />
                </button>
            </div>
        HTML;
    }
}
