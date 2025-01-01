<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class loanStatus extends Component
{
    public $variant;
    public $class;
    /**
     * Create a new component instance.
     */
    public function __construct($variant = "primary", $class = "")
    {
        $this->variant = $variant;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.loan-status', [
            'variant' => $this->variant,
            'class' => $this->class,
        ]);
    }
}
