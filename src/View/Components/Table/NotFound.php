<?php

namespace Developermithu\Tallcraftui\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NotFound extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <tr>
                <td colspan="100%">
                    <div class="flex items-center justify-center py-10">
                        <div class="text-center">
                            <x-tc-icon :name="$icon ?? 'x-mark'" {{ $attributes->twMergeFor('icon', 'p-3 mx-auto mb-1 text-gray-500 bg-gray-100 rounded-full dark:text-gray-400 dark:bg-gray-700 w-11 h-11') }} />
                             
                            <div {{ $attributes->withoutTwMergeClasses()->twMerge(["text-xl font-bold text-gray-500 lg:text-2xl dark:text-gray-400"]) }}>
                                {{ $label ? __($label) : __('No records found') }}
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        HTML;
    }
}
