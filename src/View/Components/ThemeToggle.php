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
                    this.isDarkMode = localStorage.getItem('dark-mode') === 'true' ||
                        (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
                    this.applyTheme();
                },
                toggleDarkMode() {
                    this.isDarkMode = !this.isDarkMode;
                    localStorage.setItem('dark-mode', this.isDarkMode);
                    this.applyTheme();
                },
                applyTheme() {
                    if (this.isDarkMode) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }">
                <label class="sr-only">Theme</label>
                <button
                    @click="toggleDarkMode()"
                    class="flex items-center justify-center w-6 h-6 p-1 xxs:w-10 xxs:h-10 xxs:p-1.5 bg-transparent rounded-full hover:bg-gray-100 dark:hover:bg-slate-700 dark:ring-inset dark:ring-white/5"
                    aria-label="Theme"
                >
                    <x-icon
                        name="sun"
                        class="text-teal-500 dark:!text-teal-500"
                        x-show="!isDarkMode"
                        x-cloak
                    />
                    <x-icon
                        name="moon"
                        class="text-teal-500 dark:!text-teal-500"
                        x-show="isDarkMode"
                        x-cloak
                    />
                </button>
            </div>
        HTML;
    }
}