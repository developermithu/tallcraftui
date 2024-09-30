<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Clipboard extends Component
{
    public function __construct(
        public string $content,
        public string $icon = 'clipboard',
        public string $copiedIcon = 'clipboard-document-check',
        public string $copiedText = 'Copied!',
        public int $timeout = 2000, // default 2s
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div
                x-data="{
                    copied: false,
                    content: '{{ $content }}',
                    copyToClipboard() {
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText(this.content).then(() => {
                                this.copied = true;
                                this.$dispatch('copy', { text: this.content });
                                setTimeout(() => this.copied = false, {{ $timeout }});
                            }).catch(err => {
                                this.$dispatch('copy-error', { error: err });
                                console.log('Failed to copy content to clipboard.');
                            });
                        } else {
                            this.$dispatch('copy-error', { error: 'Clipboard API not supported' });
                            console.log('Clipboard API not supported.');
                        }
                    }
                }"
            >
                <button class="relative" {{ $attributes }} >
                    <p x-show="copied" class="absolute text-sm text-teal-500 -translate-x-1/2 whitespace-nowrap bottom-6 left-1/2" x-cloak> 
                        {{ $copiedText }} 
                    </p>
                    <x-icon x-show="copied" :name="$copiedIcon" class="text-teal-500 size-6" x-cloak/>
                    <x-icon @click="copyToClipboard()" x-show="!copied" :name="$icon" class="text-gray-500 cursor-pointer size-6" x-cloak />
                </button>
            </div>
        HTML;
    }
}
