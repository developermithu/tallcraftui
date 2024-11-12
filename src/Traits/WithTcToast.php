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
        string $typeOrMessage,
        ?string $title = null,
        ?string $description = null,
        ?string $position = null,
        ?string $icon = null,
        ?bool $showCloseIcon = null,
        ?bool $showProgress = null,
        ?int $timeout = null,
        ?string $redirectTo = null
    ) {
        $validTypes = ['success', 'info', 'warning', 'error'];

        // Determine if the first argument is a valid type or a message
        $type = in_array($typeOrMessage, $validTypes) ? $typeOrMessage : 'success';
        $title = $title ?? ($type === $typeOrMessage ? 'Default message' : $typeOrMessage);

        $iconColor = $this->iconColorByType($type);

        $iconName = $icon ?? match ($type) {
            'success' => 'check-circle',
            'warning' => 'exclamation-triangle',
            'error' => 'x-circle',
            'info' => 'information-circle',
            default => 'check-circle',
        };

        // Prepare the toast array
        $toast = [
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'position' => $position ?? config('tallcraftui.toast.position', 'bottom-right'),
            'icon' => Blade::render("<x-tc-icon class='w-6 h-6 {$iconColor}' name='".$iconName."' />"),
            'showCloseIcon' => $showCloseIcon ?? config('tallcraftui.toast.showCloseIcon', false),
            'showProgress' => $showProgress ?? config('tallcraftui.toast.showProgress', false),
            'timeout' => $timeout ?? ($redirectTo ? 6000 : config('tallcraftui.toast.timeout', 3000)),
        ];

        // Trigger the JavaScript function to show the toast
        $this->js('toast('.json_encode(['toast' => $toast]).')');

        if ($redirectTo) {
            return $this->redirect($redirectTo, navigate: true);
        }
    }

    public function success(
        string $title,
        ?string $description = null,
        ?string $position = null,
        string $icon = 'check-circle',
        ?bool $showCloseIcon = null,
        ?bool $showProgress = null,
        ?int $timeout = null,
        ?string $redirectTo = null
    ) {
        return $this->toast('success', $title, $description, $position, $icon, $showCloseIcon, $showProgress, $timeout, $redirectTo);
    }

    public function warning(
        string $title,
        ?string $description = null,
        ?string $position = null,
        string $icon = 'exclamation-triangle',
        ?bool $showCloseIcon = null,
        ?bool $showProgress = null,
        ?int $timeout = null,
        ?string $redirectTo = null
    ) {
        return $this->toast('warning', $title, $description, $position, $icon, $showCloseIcon, $showProgress, $timeout, $redirectTo);
    }

    public function error(
        string $title,
        ?string $description = null,
        ?string $position = null,
        string $icon = 'x-circle',
        ?bool $showCloseIcon = null,
        ?bool $showProgress = null,
        ?int $timeout = null,
        ?string $redirectTo = null
    ) {
        return $this->toast('error', $title, $description, $position, $icon, $showCloseIcon, $showProgress, $timeout, $redirectTo);
    }

    public function info(
        string $title,
        ?string $description = null,
        ?string $position = null,
        string $icon = 'information-circle',
        ?bool $showCloseIcon = null,
        ?bool $showProgress = null,
        ?int $timeout = null,
        ?string $redirectTo = null
    ) {
        return $this->toast('info', $title, $description, $position, $icon, $showCloseIcon, $showProgress, $timeout, $redirectTo);
    }
}
