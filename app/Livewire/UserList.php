<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    public $users, $name,$lastname,$password, $email, $phone, $user_id;
    public $isOpen = 0;
    public $showActive = true; 
    public $editPassword = false;
  

    public function render()
    {
        if ($this->showActive) {
            $this->users = User::whereNull('deleted_at')->get();
        } else {
            $this->users = User::onlyTrashed()->get();
        }

        return view('livewire.user-list')->layout('layouts.app');
    }

    public function create()
    {
        $this->editPassword = false;;
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }
    

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->name = '';
        $this->lastname = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->user_id = '';
    }

    public function store()
{
    $rules = [
        'name' => 'required',
        'lastname' => 'required',
        'email' => 'required',
        'phone' => 'required',
    ];

    // Aplicar la regla de validación 'required' a 'password' solo si $editPassword es false
    if (!$this->editPassword) {
        $rules['password'] = 'required|min:8';
    } else {
        // Si $editPassword es false, excluye la regla 'required' para el campo de contraseña
        $rules['password'] = '';
    }

    $this->validate($rules);

    $userData = [
        'name' => $this->name,
        'lastname' => $this->lastname,
        'email' => $this->email,
        'phone' => $this->phone,
    ];

    // Incluir la contraseña en los datos del usuario si $editPassword es false
    if (!$this->editPassword) {
        $userData['password'] = bcrypt($this->password);
    }

    User::updateOrCreate(['id' => $this->user_id], $userData);

    session()->flash('message', 
        $this->user_id ? 'User Updated Successfully.' : 'User Created Successfully.');

    $this->closeModal();
    $this->resetInputFields();
}


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->lastname = $user->lastname;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->password = '';
        $this->editPassword = true;
        $this->openModal();
    }

    public function delete($id)
    {
        if ($this->showActive) {
            User::find($id)->delete();
            session()->flash('message', 'User Deleted Successfully.');
        } else {
            User::withTrashed()->find($id)->restore();
            session()->flash('message', 'User Restored Successfully.');
        }
    }
    public function activate($id)
{
    User::withTrashed()->find($id)->restore();
    session()->flash('message', 'User Activated Successfully.');
}
      public function showActive()
      {
          $this->showActive = true;
      }
      
      public function showInactive()
      {
          $this->showActive = false;
      }
     
      
      
}
