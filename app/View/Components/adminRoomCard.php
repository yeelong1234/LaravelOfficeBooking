<?php

namespace App\View\Components;

use App\Models\Room;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class adminRoomCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $isApproved = true | false;
    public $roomDetails;
    public function __construct($isApproved = true, Room $roomDetails)
    {
       
            $this->isApproved = $isApproved;
            $this->roomDetails = $roomDetails;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-room-card');
    }
}
