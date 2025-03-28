<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Developermithu\Tallcraftui\Traits\Sizes\HasSelectSizes;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    use HasSelectSizes;

    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public Collection|array|null $options = null,
        public ?string $placeholder = null,
        public ?string $hint = null,
        public bool $multiple = false,
        public bool $searchable = false,
        public bool $clearable = false,
        public ?int $limit = null,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('select', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div>
                @php
                    $name = $attributes->wire('model')->value();
                    $error = $errors->has($name) ? $errors->first($name) : null;
                    $uuid = $uuid . $name;
                    $required = $attributes->get('required') ? true : false;

                    $errorClass = $error ? 'border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 focus:ring-red-500': '';
                    $disabledClass = $attributes->get('disabled') ? "bg-gray-200 opacity-80 cursor-not-allowed" : '';
                    $readonlyClass = $attributes->get('readonly') ? "bg-gray-200 opacity-80 border-gray-400 border-dashed pointer-events-none" : '';
                @endphp
            
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required" {{ $attributes->twMergeFor('label') }} />
                @endif

                <div 
                    x-data="{
                        multiple: @js($multiple),
                        searchable: @js($searchable),
                        clearable: @js($clearable),
                        placeholder: @js($placeholder ?? 'Choose option'),
                        limit: @js($limit),
                        options: [],
                        open: false,
                        search: '',
                        selected: [],
                        focusedOptionIndex: 0,
                        name: @js($name),
                        
                        init() {
                            this.initializeComponent();
                            
                            this.$watch('selected', value => {
                                if (this.multiple) {
                                    this.$wire.set(this.name, value.map(item => item.id));
                                } else {
                                    this.$wire.set(this.name, value[0]?.id ?? null);
                                }
                            });
                        },
                        
                        initializeComponent() {
                            const rawOptions = @js($options ?? []);
                            this.options = this.formatOptions(rawOptions);
                            
                            try {
                                const wireValue = this.$wire.get(this.name);
                                if (wireValue) {
                                    const values = Array.isArray(wireValue) ? wireValue : [wireValue];
                                    this.selected = this.options.filter(option => 
                                        values.includes(option.id)
                                    );
                                } else {
                                    this.selected = [];
                                }
                            } catch (e) {
                                console.warn('Error initializing Select component:', e);
                                this.selected = [];
                            }
                        },
                        
                        formatOptions(options) {
                            // Handle null or empty options
                            if (!options) return [];

                            // Handle array of objects with id/name
                            if (Array.isArray(options) && options.length && typeof options[0] === 'object') {
                                return options.map(option => ({
                                    id: option.id ?? option.value ?? option.key,
                                    name: option.name ?? option.title ?? option.label ?? option.text,
                                    avatar: option.avatar ?? option.image ?? null,
                                    description: option.description ?? null
                                }));
                            }
                            
                            // Handle pluck() result (object with key-value pairs)
                            if (!Array.isArray(options) && typeof options === 'object') {
                                return Object.entries(options).map(([key, value]) => ({
                                    id: key,
                                    name: value.toString(),
                                    avatar: null,
                                    description: null
                                }));
                            }

                            // Handle simple arrays
                            return (Array.isArray(options) ? options : []).map(value => ({
                                id: value,
                                name: value.toString(),
                                avatar: null,
                                description: null
                            }));
                        },
                        
                        get filteredOptions() {
                            return this.options.filter(option => 
                                option.name.toLowerCase().includes(this.search.toLowerCase())
                            );
                        },
                        
                        get hasReachedLimit() {
                            return this.limit && this.selected.length >= this.limit;
                        },
                        
                        toggleSelect() {
                            this.open = !this.open;
                            if (this.open) {
                                if (this.searchable) {
                                    this.$nextTick(() => {
                                        this.$refs.searchInput.focus();
                                    });
                                }
                                this.focusedOptionIndex = 0;
                            } else {
                                this.search = '';
                                this.focusedOptionIndex = 0;
                            }
                        },
                        
                        closeSelect() {
                            this.open = false;
                            this.search = '';
                            this.focusedOptionIndex = 0;
                        },
                        
                        toggleOption(option) {
                            if (!this.multiple) {
                                this.selected = [option];
                                this.closeSelect();
                                return;
                            }

                            if (this.hasReachedLimit && !this.isSelected(option)) {
                                return;
                            }

                            const index = this.selected.findIndex(item => item.id === option.id);
                            if (index === -1) {
                                this.selected = [...this.selected, option];
                            } else {
                                this.selected = this.selected.filter(item => item.id !== option.id);
                            }
                        },
                        
                        removeOption(option, event) {
                            if (event) {
                                event.stopPropagation();
                            }
                            this.selected = this.selected.filter(item => item.id !== option.id);
                        },
                        
                        clearSelection(event) {
                            if (event) {
                                event.stopPropagation();
                            }
                            this.selected = [];
                        },
                        
                        isSelected(option) {
                            return this.selected.some(item => item.id === option.id);
                        },
                        
                        focusNextOption() {
                            if (!this.open) {
                                this.open = true;
                                return;
                            }
                            this.focusedOptionIndex = (this.focusedOptionIndex + 1) % this.filteredOptions.length;
                            this.scrollToOption();
                        },
                        
                        focusPreviousOption() {
                            if (!this.open) {
                                this.open = true;
                                return;
                            }
                            this.focusedOptionIndex = this.focusedOptionIndex > 0 
                                ? this.focusedOptionIndex - 1 
                                : this.filteredOptions.length - 1;
                            this.scrollToOption();
                        },
                        
                        scrollToOption() {
                            this.$nextTick(() => {
                                const el = this.$refs.optionsList;
                                const activeOption = el.children[this.focusedOptionIndex];
                                if (activeOption) {
                                    activeOption.scrollIntoView({
                                        block: 'nearest',
                                        behavior: 'smooth'
                                    });
                                }
                            });
                        },
                        
                        selectFocusedOption() {
                            const option = this.filteredOptions[this.focusedOptionIndex];
                            if (option) {
                                this.toggleOption(option);
                            }
                        },
                        
                        handleTabKey(event) {
                            if (this.open && this.focusedOptionIndex >= 0) {
                                event.preventDefault();
                                this.selectFocusedOption();
                            }
                        }
                    }"
                    class="relative"
                    @click.outside="closeSelect()"
                >
                    <!-- Dropdown trigger button -->
                    <button
                        type="button"
                        @click="toggleSelect()"
                        @keydown.enter.prevent="selectFocusedOption()"
                        @keydown.space.prevent="toggleSelect()"
                        @keydown.arrow-up.prevent="focusPreviousOption()"
                        @keydown.arrow-down.prevent="focusNextOption()"
                        @keydown.tab="handleTabKey($event)"
                        @keydown.esc="closeSelect()"
                        aria-haspopup="listbox"
                        :aria-expanded="open"
                        :aria-labelledby="$id('select-label')"
                        x-ref="selectField"
                        {{ 
                            $attributes
                                ->withoutTwMergeClasses()
                                ->twMerge([
                                    "relative w-full cursor-pointer bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 pl-3 pr-10 text-left shadow-xs outline-none focus:ring-1 focus:ring-primary focus:border-primary",
                                    $errorClass,
                                    $disabledClass,
                                    $readonlyClass,
                                    $roundedClass(),
                                    $getSizeClasses(),
                                ])
                        }}
                    >
                        <!-- Selected items display -->
                        <span class="flex flex-wrap gap-2">
                            <template x-if="!selected.length">
                                <span class="text-gray-400" x-text="placeholder"></span>
                            </template>
                            
                            <!-- Selected items -->
                            <template x-for="(option, index) in selected" :key="index">
                                <span class="inline-flex items-center gap-1 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">
                                    <template x-if="option.avatar">
                                        <img :src="option.avatar" class="w-5 h-5 rounded-full" :alt="option.name">
                                    </template>
                                    <span x-text="option.name"></span>
                                    <template x-if="multiple || clearable">
                                        <button
                                            @click.stop="removeOption(option, $event)"
                                            type="button"
                                            class="text-sm hover:text-red-500"
                                            aria-label="Remove option"
                                        >
                                            <x-tc-icon name="x-mark" class="size-4" />
                                        </button>
                                    </template>
                                </span>
                            </template>
                        </span>
                        
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2">
                            <template x-if="clearable && selected.length">
                                <button
                                    @click.stop="clearSelection($event)"
                                    type="button"
                                    class="mr-1 text-gray-400 hover:text-red-500"
                                    aria-label="Clear selection"
                                >
                                    <x-tc-icon name="x-mark" class="size-5" />
                                </button>
                            </template>
                            <x-tc-icon name="chevron-up-down" class="text-gray-400 size-5" />
                        </span>
                    </button>

                    <!-- Dropdown content -->
                    <div
                        x-cloak
                        x-show="open"
                        x-anchor.bottom.offset.3="$refs.selectField" 
                        x-transition:enter="transition duration-100 ease-out" 
                        x-transition:enter-start="opacity-0 -translate-y-2" 
                        x-transition:enter-end="opacity-100 translate-y-0" 
                        x-transition:leave="transition ease-in duration-75" 
                        x-transition:leave-start="opacity-100 translate-y-0" 
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:border-gray-700"
                    >
                        <!-- Search input -->
                        <template x-if="searchable">
                            <div class="p-2">
                                <input
                                    x-model="search"
                                    x-ref="searchInput"
                                    type="search"
                                    @click.stop
                                    @keydown.enter.prevent="selectFocusedOption()"
                                    @keydown.arrow-up.prevent="focusPreviousOption()"
                                    @keydown.arrow-down.prevent="focusNextOption()"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded dark:border-gray-700 focus:outline-none focus:ring-primary focus:border-primary dark:bg-gray-800"
                                    placeholder="Search..."
                                />
                            </div>
                        </template>

                        <!-- Options list -->
                        <ul
                            x-ref="optionsList"
                            role="listbox"
                            :aria-labelledby="$id('select-label')"
                            :aria-multiselectable="multiple"
                            class="py-1 overflow-auto max-h-60"
                        >
                            <template x-if="multiple && limit && selected.length >= limit">
                                <li class="px-3 py-2 text-sm text-red-500 dark:text-red-500">
                                    Maximum limit of <span x-text="limit"></span> items reached
                                </li>
                            </template>
                            <template x-for="(option, index) in filteredOptions" :key="option.id">
                                <li
                                    @click="toggleOption(option)"
                                    @mouseenter="focusedOptionIndex = index"
                                    role="option"
                                    :aria-selected="isSelected(option)"
                                    :class="{ 
                                        'bg-gray-100 dark:bg-gray-700': focusedOptionIndex === index,
                                        'cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700': !isSelected(option)
                                    }"
                                    class="relative px-8 py-2 text-sm"
                                >
                                    <div class="flex items-center gap-2">
                                        <template x-if="isSelected(option)">
                                            <span class="absolute inset-y-0 flex items-center left-2">
                                                <x-tc-icon name="check" class="size-5" />
                                            </span>
                                        </template>
                                        <template x-if="option.avatar">
                                            <img :src="option.avatar" class="w-5 h-5 rounded-full" :alt="option.name">
                                        </template>
                                        <div>
                                            <span x-text="option.name"></span>
                                            <template x-if="option.description">
                                                <p class="text-gray-500 dark:text-gray-400" x-text="option.description"></p>
                                            </template>
                                        </div>
                                    </div>
                                </li>
                            </template>
                        </ul>
                    </div>

                    @if($hint && !$error)
                        <x-tc-hint :hint="$hint" />
                    @endif
                    
                    @if($error)
                        <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                    @endif
                </div>
            </div>
        HTML;
    }
}
