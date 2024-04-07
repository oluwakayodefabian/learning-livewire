<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Clicker extends Component
{
    //! The trit below alows us to use pagination in a livewire component
    use WithPagination;

    #[Validate('required|min:2')]
    public string $name = '';

    #[Validate('required|email|unique:users')]
    public string $email = '';

    #[Validate('required|min:5')]
    public string $password = '';

    public function createUser()
    {
        $this->validate();

        User::create(
            [
                'name'      => $this->name,
                'email'     => $this->email,
                'password'  => Hash::make(($this->password)),
            ]
        );

        session()->flash('success', 'User created');

        $this->reset('name', 'email', 'password');
    }
    public function render()
    {
        return view('livewire.clicker', [
            'users' => User::paginate(5),
        ]);
    }
}
