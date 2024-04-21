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
        'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
        'phone' => 'required',
    ];

    // Si no se proporciona una contraseña, se excluye la validación de la misma
    if (!$this->editPassword) {
        $rules['password'] = 'required|min:8';
    }

    $validatedData = $this->validate($rules);

    // buscar un usuario con el mismo correo electrónico
    $existingUser = User::where('email', $validatedData['email'])->first();

    if ($existingUser && !$this->user_id) {
        return back()->withErrors([
            'unique' => 'El correo electrónico ya está en uso.',
        ]);
    }

    $userData = [
        'name' => $validatedData['name'],
        'lastname' => $validatedData['lastname'],
        'email' => $validatedData['email'],
        'phone' => $validatedData['phone'],
    ];

    // Si estamos creando un usuario o estamos editando pero no se está editando la contraseña, encriptamos y almacenamos la nueva contraseña
    if (!$this->user_id || !$this->editPassword) {
        $userData['password'] = bcrypt($validatedData['password']);
    }

    // Utilizamos updateOrCreate() para crear o actualizar el usuario según sea necesario
    User::updateOrCreate(['id' => $this->user_id], $userData);

    session()->flash('message', $this->user_id ? 'Usuario Actualizado Correctamente.' : 'Usuario Creado Correctamente.');

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
            session()->flash('message', 'Usuario inactivado correctamente.');
        } else {
            User::withTrashed()->find($id)->restore();
            session()->flash('message', 'Usuario restaurado correctamente.');
        }
    }
    public function activate($id)
{
    User::withTrashed()->find($id)->restore();
    session()->flash('message', 'Usuario activado correctamente.');
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
