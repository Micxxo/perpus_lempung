<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class modal extends Component
{
    public $buttonSlot;
    public $contentSlot;
    public $class;
    public $buttonContainerClass;
    public $title;


    /**
     * Create a new component instance.
     */
    public function __construct($buttonSlot = null, $contentSlot = null, $class = "", $title = "", $buttonContainerClass = "")
    {
        $this->buttonSlot = $buttonSlot;
        $this->contentSlot = $contentSlot;
        $this->class = $class;
        $this->buttonContainerClass = $buttonContainerClass;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal', [
            'buttonSlot' => $this->buttonSlot,
            'contentSlot' => $this->contentSlot,
            'class' => $this->class,
            'buttonContainerClass' => $this->buttonContainerClass,
            'title' => $this->title,
        ]);
    }
}
