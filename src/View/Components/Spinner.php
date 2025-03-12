<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Traits\SpinnerTrait;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Spinner extends Component
{
    use SpinnerTrait;

    public function __construct(
        public ?bool $bars = false,
        public ?bool $dots = false,
        public ?bool $pulse = false,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @if($bars)
                <svg {{ $attributes->except($colorAttributes)->twMerge([$getColorClasses(), $getSizeClasses()]) }} xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><rect width="6" height="14" x="1" y="4" fill="currentColor"><animate id="svgSpinnersBarsFade0" fill="freeze" attributeName="opacity" begin="0;svgSpinnersBarsFade1.end-0.25s" dur="0.75s" values="1;0.2"/></rect><rect width="6" height="14" x="9" y="4" fill="currentColor" opacity="0.4"><animate fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.15s" dur="0.75s" values="1;0.2"/></rect><rect width="6" height="14" x="17" y="4" fill="currentColor" opacity="0.3"><animate id="svgSpinnersBarsFade1" fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.3s" dur="0.75s" values="1;0.2"/></rect></svg>
            @elseif($pulse)
                <svg {{ $attributes->except($colorAttributes)->twMerge([$getColorClasses(), $getSizeClasses()]) }} xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse30" fill="freeze" attributeName="r" begin="0;svgSpinnersPulse32.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="0;svgSpinnersPulse32.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse31" fill="freeze" attributeName="r" begin="svgSpinnersPulse30.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse30.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse32" fill="freeze" attributeName="r" begin="svgSpinnersPulse30.begin+0.8s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse30.begin+0.8s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle></svg>
            @elseif($dots)
                <svg {{ $attributes->except($colorAttributes)->twMerge(['animate-spin', str_replace('text-', 'fill-', $getColorClasses()), $getSizeClasses()]) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"/></svg>
            @else
                <svg {{ $attributes->except($colorAttributes)->twMerge(['animate-spin', $getColorClasses(), $getSizeClasses()]) }} xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity="0.25"/><path fill="currentColor" d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z" transform="rotate(360 12 12)"/></svg>
            @endif
        HTML;
    }
}
