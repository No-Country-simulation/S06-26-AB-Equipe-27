<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageHeader extends Component
{
    public string $page;
    public string $eyebrow;
    public string $description;
    public ?string $actionBtn;
    public ?string $actionBtnUrl;
    public ?string $actionBtnIcon;

    public function __construct(
        string $page,
        string $eyebrow = 'Recrutamento & seleção',
        string $description = 'Gerencie as posições abertas e acompanhe o índice de equidade de cada processo',
        ?string $actionBtn = null,
        ?string $actionBtnUrl = null,
        ?string $actionBtnIcon = null
    ) {
        $this->page = $page;
        $this->eyebrow = $eyebrow;
        $this->description = $description;
        $this->actionBtn = $actionBtn;
        $this->actionBtnUrl = $actionBtnUrl;
        $this->actionBtnIcon = $actionBtnIcon;
    }

    public function render()
    {
        return view('components.pageheader');
    }
}
