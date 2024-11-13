<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Markdown extends Component
{
    public string $uuid;

    public string $uploadUrl;

    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?bool $inline = false,
        public ?string $disk = 'public',
        public ?string $folder = 'markdown',
        public ?array $config = null,
    ) {
        $this->uuid = md5(serialize($this));
        $this->uploadUrl = route('tallcraftui.upload', absolute: false);
    }

    public function getDefaultConfig(): array
    {
        return config('tallcraftui.markdown.config', []);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $name = $attributes->wire('model')->value();
                $error = $errors->has($name) ? $errors->first($name) : null;
                $uuid = $uuid . $name;
                $required = $attributes->get('required') ? true : false;
            @endphp

            <div @class(['inline-flex items-center gap-3' => $inline])>
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required" :inline="$inline" 
                        {{ $attributes->twMergeFor('label') }} 
                    />
                @endif

                <div class="relative flex-1" 
                    x-data="{ 
                        editor: null,
                        value: @entangle($attributes->wire('model')),
                        config: @js($config ?? $getDefaultConfig()),
                        uploadUrl: '{{ $uploadUrl }}?disk={{ $disk }}&folder={{ $folder }}&_token={{ csrf_token() }}',
                        uploading: false,
                        init() {
                            this.initEditor()
                            
                            this.$watch('value', (newValue) => {
                                if (newValue !== this.editor.value()) {
                                    this.value = newValue || ''
                                    this.destroyEditor()
                                    this.initEditor()
                                }
                            })
                        },
                        destroyEditor() {
                            if (this.editor) {
                                this.editor.toTextArea();
                                this.editor = null
                            }
                        },
                        initEditor() {
                            if (this.editor) return
                            
                            this.config.element = this.$refs.textarea
                            this.config.initialValue = this.value ?? ''
                            this.config.imageUploadFunction = (file, onSuccess, onError) => {
                                if (file.type.split('/')[0] !== 'image') {
                                    return onError('File must be an image.');
                                }

                                var data = new FormData()
                                data.append('file', file)

                                this.uploading = true

                                fetch(this.uploadUrl, { 
                                    method: 'POST', 
                                    body: data 
                                })
                                .then(response => response.json())
                                .then(data => onSuccess(data.location))
                                .catch((err) => onError('Error uploading image!'))
                                .finally(() => this.uploading = false)
                            }
                            
                            this.editor = new EasyMDE(this.config)
                            this.editor.codemirror.on('change', () => {
                                this.value = this.editor.value()
                            })
                        }
                    }"
                    wire:ignore
                    x-on:livewire:navigating.window="destroyEditor()"
                >
                    <div class="relative" :class="uploading && 'pointer-events-none opacity-50'">
                        <textarea
                            id="{{ $uuid }}"
                            x-ref="textarea"
                            {{ $attributes->except(['wire:model', 'placeholder']) }}
                        ></textarea>

                        <div class="absolute top-1/2 start-1/2 -translate-x-1/2 -translate-y-1/2 !opacity-100 text-center hidden" 
                            :class="uploading && '!block'"
                        >
                            <div>Uploading...</div>
                        </div>
                    </div>

                    @if($hint && !$error)
                        <x-tc-hint :hint="$hint" />
                    @endif

                    @if($error)
                        <p class="mt-1 text-sm text-red-500">{{ $error }}</p>
                    @endif
                </div>
            </div>
        HTML;
    }
}
