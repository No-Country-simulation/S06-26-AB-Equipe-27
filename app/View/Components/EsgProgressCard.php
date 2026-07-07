<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EsgProgressCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public ?string $description = null,
        public string $trackingType = 'percentage',
        public ?int $currentValue = 0,
        public ?int $targetValue = 100,
        public ?string $status = null,
        public ?string $notes = null,
        public int $goalId,
        public string $colorStart = '#7C3AED',
        public string $colorEnd = '#0D9488',
    ) {
        //
    }

    /**
     * Calculate progress percentage.
     */
    public function getProgressPercentage(): int
    {
        if ($this->trackingType === 'count' && $this->targetValue > 0) {
            return min((int) (($this->currentValue / $this->targetValue) * 100), 100);
        } elseif ($this->trackingType === 'percentage') {
            return min((int) $this->currentValue, 100);
        }
        return 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.esg-progress-card');
    }
}
