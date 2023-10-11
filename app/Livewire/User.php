<?php

namespace App\Livewire;

use App\Models\Divisi;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

class User extends Component
{
    public $users = [];
    public $departments = [];
    public $name, $email, $password, $role, $id_divisi, $no_hp, $user = null, $isView = false, $isEdit = false;

    public function render()
    {
        $this->users = ModelsUser::leftJoin('departments', 'departments.id_divisi', '=', 'users.id_divisi')
            ->select('users.*', 'departments.nama as nama_divisi')
            ->get();
        $this->departments = Divisi::all();
        return view('livewire.user.index');
    }

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'role' => 'required',
        'id_divisi' => 'required',
        'no_hp' => 'required',
    ];

    public function updated($inputs)
    {
        $this->validateOnly($inputs);
    }

    public function saveUser()
    {
        if (!$this->isEdit) {
            $this->storeUser();
        } else {
            $this->updateUser();
        }
    }

    public function storeUser()
    {
        $validatedData = $this->validate();

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = ModelsUser::create($validatedData);

        if ($user) {
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "User berhasil ditambahkan!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "User gagal ditambahkan!"
            ]);
        }

        $this->resetInputs();

        $this->dispatch('close-modal');
    }

    private function resetInputs()
    {
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->role = null;
        $this->id_divisi = null;
        $this->no_hp = null;
    }

    public function showUser(ModelsUser $user)
    {
        if ($user) {
            $this->user = $user;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = $user->password;
            $this->role = $user->role;
            $this->id_divisi = $user->id_divisi;
            $this->no_hp = $user->no_hp;
            $this->isView = true;
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "User tidak ditemukan!"
            ]);
        }
    }

    public function editUser(ModelsUser $user)
    {
        if ($user) {
            $this->user = $user;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = $user->password;
            $this->role = $user->role;
            $this->id_divisi = $user->id_divisi;
            $this->no_hp = $user->no_hp;
            $this->isEdit = true;
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "User tidak ditemukan!"
            ]);
        }
    }

    public function updateUser()
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
            if ($validatedData['password']) {
                $this->user->password = $validatedData['password'];
            }
            $this->user->role = $validatedData['role'];
            $this->user->id_divisi = $validatedData['id_divisi'];
            $this->user->no_hp = $validatedData['no_hp'];
            $this->user->save();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "User berhasil diupdate!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "User gagal diupdate!"
            ]);
        }

        $this->isEdit = false;

        $this->dispatch('close-modal');
    }

    public function deleteUser(ModelsUser $user)
    {
        $this->user = $user;
    }

    public function destroyBook()
    {
        if ($this->user) {
            $this->user->delete();
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => "User berhasil dihapus!"
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => "User gagal dihapus!"
            ]);
        }

        $this->dispatch('close-modal');
    }

    public function closeModal()
    {
        $this->resetInputs();
    }
}
