<?php

namespace App\View\Components;

use App\Models\Booking;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class adminBookingCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $booking;
    public function __construct(string $booking)
    {
        $this->$booking = $booking;//
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-booking-card');
    }
}
