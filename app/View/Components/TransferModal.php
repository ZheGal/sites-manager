<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User;

class TransferModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $users = User::all();
        return view('components.transfer-modal', compact('users'));
    }
}
