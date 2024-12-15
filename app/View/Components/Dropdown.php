<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public $buttonSlot;
    public $contentSlot;
    public $position;
    public $class;
    public $panelClass;
    public $containerClass;

    /**
     * Create a new component instance.
     *
     * @param string|null $buttonSlot
     * @param string $position
     */
    public function __construct($buttonSlot = null, $contentSlot = null, $position = "right", $class = "", $panelClass = "", $containerClass = "")
    {
        $this->buttonSlot = $buttonSlot;
        $this->contentSlot = $contentSlot;
        $this->position = $position;
        $this->class = $class;
        $this->panelClass = $panelClass;
        $this->containerClass = $containerClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown', [
            'buttonSlot' => $this->buttonSlot,
            'contentSlot' => $this->contentSlot,
            'class' => $this->class,
            'panelClass' => $this->panelClass,
            'containerClass' => $this->containerClass,
            'position' => $this->position,
        ]);
    }
}
