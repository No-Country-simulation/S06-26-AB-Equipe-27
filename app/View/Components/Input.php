<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public ?string $label;
    public ?string $name;
    public ?string $type = 'text';
    public ?string $placeholder = '';
    public ?string $icon = 'bi-input';
    public ?bool $required = false;
    public ?string $value = '';
    public ?int $rows = 4;
    public ?array $options;
    public ?string $id = null;

    public function __construct(
        ?string $label,
        ?string $name,
        ?string $type = 'text',
        ?string $placeholder = '',
        ?string $icon = 'bi-input',
        ?bool $required = false,
        ?string $value = '',
        ?int $rows = 4,
        ?array $options = [],
        ?string $id = null,
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->icon = $icon;
        $this->required = $required;
        $this->value = $value;
        $this->rows = $rows;
        $this->options = $options;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
