<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Numeric extends Component
{
    /**
     * @var float
     */
    public float $value;

    /**
     * Create a new component instance.
     *
     * @param  float        $value
     * @param  int          $decimals
     * @param  string|null  $decimal_separator
     * @param  string|null  $thousands_separator
     */
    public function __construct(
        float   $value,
        int     $decimals = 0,
        ?string $decimal_separator = ".",
        ?string $thousands_separator = ","
    ) {
        $this->value = number_format($value, $decimals, $decimal_separator, $thousands_separator);
    }

    /**
     * Get the view/contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return <<<'blade'
    {{ $value }}
blade;
    }
}
