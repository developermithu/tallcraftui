<?php

namespace Developermithu\Tallcraftui\Traits;

use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;

trait ModalTrait
{
    public function getSizeClasses(): string
    {
        $sizes = [
            'sm' => 'w-full sm:max-w-sm',
            'md' => 'w-full sm:max-w-md',
            'lg' => 'w-full sm:max-w-lg',
            'xl' => 'w-full sm:max-w-xl',
            '2xl' => 'w-full sm:max-w-2xl',
            '3xl' => 'w-full sm:mx-6 md:mx-8 lg:mx-0 sm:max-w-3xl',
            '4xl' => 'w-full sm:mx-6 md:mx-8 lg:mx-0 sm:max-w-4xl',
            '5xl' => 'w-full sm:mx-6 md:mx-8 lg:mx-0 sm:max-w-5xl',
            '6xl' => 'w-full sm:mx-6 md:mx-8 xl:mx-0 sm:max-w-6xl',
            '7xl' => 'w-full sm:mx-6 md:mx-8 2xl:mx-0 sm:max-w-7xl',
            'full' => 'fixed inset-0 w-screen h-screen',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.modal.size', 'lg');

        return $sizes[$defaultSize] ?? $sizes['lg'];
    }

    public function getBgBlurClasses(): string
    {
        $isDefaultBlur = config('tallcraftui.modal.blur', false);

        return match (true) {
            $this->attributes->get('blur-sm') => 'backdrop-blur-sm',
            $this->attributes->get('blur-xs') => 'backdrop-blur-xs',
            $this->attributes->get('blur-md') => 'backdrop-blur-md',
            $this->attributes->get('blur-lg') => 'backdrop-blur-lg',
            $this->attributes->get('blur-xl') => 'backdrop-blur-xl',
            $this->attributes->get('blur-2xl') => 'backdrop-blur-2xl',
            $this->attributes->get('blur-3xl') => 'backdrop-blur-3xl',
            $this->attributes->get('blur-none') => 'backdrop-blur-none',

            default => match ($isDefaultBlur) {
                    true => 'backdrop-blur-xs',
                    default => '',
                },
        };
    }

    public function getModalPosition(): string
    {
        $positions = [
            'top' => 'flex items-start justify-center h-screen',
            'bottom' => 'flex items-end justify-center h-screen',
            'left' => 'flex items-center justify-start w-screen h-screen pl-10!',
            'right' => 'flex items-center justify-end w-screen h-screen pr-10!',
            'center' => 'flex items-center justify-center w-screen h-screen',
        ];

        foreach ($positions as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultPosition = config('tallcraftui.modal.position', 'top');

        return $positions[$defaultPosition] ?? $positions['top'];
    }

    public function getRoundedClasses(): string
    {
        return BorderRadiusHelper::getRoundedClass('modal', $this->attributes);
    }
}