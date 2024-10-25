<?php

namespace Developermithu\Tallcraftui\Traits;

use Illuminate\Support\Facades\Blade;

trait WithTcToast
{
    private function iconColorByType(string $type): string
    {
        return match ($type) {
            'success' => 'text-green-500',
            'warning' => 'text-yellow-500',
            'error' => 'text-red-500',
            'info' => 'text-blue-500',
            default => 'text-gray-500',
        };
    }

    public function toast(
        string $type,
        string $title,
        string $description = null,
        string $position = null,
        string $icon = null,
        bool $showCloseIcon = null,
        bool $showProgress = null,
        int $timeout = null,
        string $redirectTo = null
    ) {
        $iconColor = $this->iconColorByType($type);

        $iconName = $icon ?? match ($type) {
            'success' => 'check-circle',
            'warning' => 'exclamation-triangle',
            'error' => 'x-circle',
            'info' => 'information-circle',
            default => 'check-circle',
        };

        $toast = [
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'position' => $position ?? config('tallcraftui.toast.position', 'bottom-right'),
            'icon' => Blade::render("<x-tc-icon class='w-6 h-6 {$iconColor}' name='" . $iconName . "' />"),
            'showCloseIcon' => $showCloseIcon ?? config('tallcraftui.toast.showCloseIcon', false),
            'showProgress' => $showProgress ?? config('tallcraftui.toast.showProgress', false),
            'timeout' => $timeout ?? ($redirectTo ? 6000 : config('tallcraftui.toast.timeout', 3000)),
        ];

        $this->js('toast(' . json_encode(['toast' => $toast]) . ')');

        if ($redirectTo) {
            return $this->redirect($redirectTo, navigate: true);
        }
    }

    public function success(
        string $title,
        string $description = null,
        string $position = null,
        string $icon = 'check-circle',
        bool $showCloseIcon = null, 
        bool $showProgress = null, 
        int $timeout = null,
        string $redirectTo = null
    ) {
        return $this->toast('success', $title, $description, $position, $icon, $showCloseIcon, $showProgress, $timeout, $redirectTo);
    }

    public function warning(
        string $title,
        string $description = null,
        string $position = null,
        string $icon = 'exclamation-triangle',
        bool $showCloseIcon = null,
        bool $showProgress = null,
        int $timeout = null,
        string $redirectTo = null
    ) {
        return $this->toast('warning', $title, $description, $position, $icon, $showCloseIcon, $showProgress, $timeout, $redirectTo);
    }

    public function error(
        string $title,
        string $description = null,
        string $position = null,
        string $icon = 'x-circle',
        bool $showCloseIcon = null,
        bool $showProgress = null,
        int $timeout = null,
        string $redirectTo = null
    ) {
        return $this->toast('error', $title, $description, $position, $icon, $showCloseIcon, $showProgress, $timeout, $redirectTo);
    }

    public function info(
        string $title,
        string $description = null,
        string $position = null,
        string $icon = 'information-circle',
        bool $showCloseIcon = null,
        bool $showProgress = null,
        int $timeout = null,
        string $redirectTo = null
    ) {
        return $this->toast('info', $title, $description, $position, $icon, $showCloseIcon, $showProgress, $timeout, $redirectTo);
    }
}
