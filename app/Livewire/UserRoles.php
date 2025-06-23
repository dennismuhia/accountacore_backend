<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoles extends Component
{
    public $userId;
    public $role;
    public $roles=[];
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->roles = Role::all();
    }


    public function render()
    {
        return view('livewire.user-roles',
        //  [
        //     'roles' => Role::all()
        // ]
    );
    }



    public function assignRoleToUser()
    {


        $user = User::findOrFail($this->userId);

        $user->assignRole($this->role);

        return back()->with('success', 'Role assigned to user successfully.');
    }
}
