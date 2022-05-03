<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Message\Entities\ChatRoom;

class AdminSidebar extends Component
{
    public $hasUnseenMessages = false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->hasUnseenMessages = ChatRoom::myParticipation()->where('has_unseen_messages', true)->count() ? true : false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-sidebar');
    }
}
