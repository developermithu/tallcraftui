<?php

namespace Developermithu\Tallcraftui\View\Components\Table;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Developermithu\Tallcraftui\Helpers\ShadowHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\View\Component;

class Index extends Component
{
    public function __construct(
        public bool|array $perPage = false,
        public ?bool $searchable = false,
        public ?bool $noLoading = false,
        public LengthAwarePaginator|Paginator|null $paginate = null,
    ) {}

    public function perPageValues()
    {
        if ($this->perPage) {
            if (is_bool($this->perPage)) {
                return [10, 20, 30, 50, 100];
            } elseif (is_array($this->perPage)) {
                return $this->perPage;
            }
        }
    }

    public function shadowClass(): string
    {
        return ShadowHelper::getShadowClass('table', $this->attributes);
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('table', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div @class([
                "dark:border-gray-700", 
                $shadowClass(), 
                $roundedClass(),
                'border divide-y divide-gray-200 dark:divide-gray-700' => !$attributes->get('borderless'),
            ])>
                @if(isset($bulkActions) || $searchable || isset($filters))
                    <div class="items-center justify-between block px-4 py-3 space-y-2 sm:flex sm:space-y-0">
                        <div class="flex items-center gap-3">
                            @isset($bulkActions)
                                {{ $bulkActions }}
                            @endisset
                        </div>

                        <div class="flex items-center gap-3">
                            @if($searchable)
                                <form action="#" method="GET">
                                    <label for="categories-search" class="sr-only">Search</label>
                                    <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                                        <x-tc-input type="search" wire:model.live.debounce.250ms="tcSearch" placeholder="{{ __('Search') }}.." icon="magnifying-glass" class:icon="text-gray-500 size-[18px]" />
                                    </div>
                                </form>
                            @endif

                            @isset($filters)
                                {{ $filters }}
                            @endisset
                        </div>
                    </div>
                @endif
                
                <div @class(["flex flex-col", 'divide-y divide-gray-200 dark:divide-gray-700' => !$attributes->get('borderless')])>
                    <div class="relative overflow-x-auto tc-table">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table wire:loading.class="opacity-40" @class([
                                        'min-w-full table-fixed',
                                        'table-striped' => $attributes->get('striped'),
                                        'divide-y divide-gray-200 dark:divide-gray-700' => !$attributes->get('borderless'),
                                    ])>
                                        @isset($heading)
                                            <thead class="bg-gray-100 dark:bg-gray-700">
                                                <tr>
                                                    {{ $heading }}
                                                </tr>
                                            </thead>
                                        @endisset

                                        <tbody @class([
                                                'bg-white dark:bg-gray-800',
                                                'divide-y divide-gray-200 dark:divide-gray-700' => !$attributes->get('borderless'),
                                            ])>
                                                {{ $slot }}
                                        </tbody>
                                </table>
                            </div>
                        </div>

                         @if(!$noLoading)
                            <div wire:loading class="absolute -translate-y-1/2 top-1/2 left-1/2">
                                <svg class="w-9 h-9 text-primary/80 animate-spin" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity="0.25"/><path fill="currentColor" d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z" transform="rotate(360 12 12)"/></svg>
                            </div>
                         @endif
                    </div>
                   
                  @if($paginate)
                        <div class="flex flex-wrap items-center p-4 gap-y-2.5 gap-x-5">
                            <div class="flex items-center flex-1 gap-2 text-sm dark:text-gray-400">
                                @if($perPage)
                                    <span>Per page:</span> 

                                    <x-tc-select wire:model.change="tcPerPage" class="py-1.5 min-w-[4.5rem]">
                                        @foreach($perPageValues() as $value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endforeach
                                    </x-tc-select>
                                @endif
                            </div>
                        
                            <div class="tc-pagination">
                                {{ $paginate->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        HTML;
    }
}
