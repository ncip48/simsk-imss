<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{
    #[Title('Login')]
    #[Layout('components.layouts.auth')]

    #[Rule('required', message: 'Email tidak boleh kosong.')]
    #[Rule('email', message: 'Email tidak valid.')]
    public $email;

    #[Rule('required', message: 'Password tidak boleh kosong.')]
    #[Rule('min:8', message: 'Password minimal 8 karakter.')]
    public $password;

    public $loading = false;

    public function render()
    {
        return view('livewire.login');
    }

    public function login()
    {
        $this->validate();
        $this->loading = true;

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return $this->redirect('/dashboard', navigate: true);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Email atau password salah!"
            ]);
        }
        $this->loading = false;
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
}
