<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditProfile extends Component
{
    public $name, $email, $password, $role, $id_divisi, $no_hp, $user = null;

    public function render()
    {
        $user = User::find(auth()->user()->id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->id_divisi = $user->id_divisi;
        $this->no_hp = $user->no_hp;
        $this->user = $user;
        return view('livewire.edit-profile');
    }

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'role' => 'required',
        'id_divisi' => 'required',
        'no_hp' => 'required',
        'password' => 'nullable|min:8',
    ];

    protected $messages = [
        'name.required' => 'Nama tidak boleh kosong.',
        'email.required' => 'Email tidak boleh kosong.',
        'email.email' => 'Email tidak valid.',
        'role.required' => 'Role tidak boleh kosong.',
        'id_divisi.required' => 'Divisi tidak boleh kosong.',
        'no_hp.required' => 'No HP tidak boleh kosong.',
        'password.min' => 'Password minimal 8 karakter.',
    ];

    public function updated($inputs)
    {
        $this->validateOnly($inputs);
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($validatedData['password']) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        if ($this->user) {
            $this->user->name = $validatedData['name'];
            $this->user->email = $validatedData['email'];
            $this->user->password = $validatedData['password'] ?? $this->user->password;
            $this->user->role = $this->user->role;
            $this->user->id_divisi = $this->user->id_divisi;
            $this->user->no_hp = $validatedData['no_hp'];
            $this->user->save();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "Berhasil mengupdate profile!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "Gagal mengupdate profile!"
            ]);
        }
    }
}
