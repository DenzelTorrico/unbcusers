<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    public $users, $name,$lastname,$password, $email, $phone, $user_id;
    public $isOpen = 0;
    public $showActive = true; 
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
        $this->validate([
            'name' => 'required',
            'lastname'=>'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required:min:8',
        ]);

        User::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->name,
            'lastname'=>$this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => bcrypt($this->password)
        ]);

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
        $this->password = bcrypt($user->password);
        $this->openModal();
    }

    public function delete($id)
    {
        if ($this->showActive) {
            User::find($id)->delete();
            session()->flash('message', 'User Deleted Successfully.');
        } else {
            // Aquí puedes agregar la lógica para restaurar el usuario si está en modo inactivo
            User::withTrashed()->find($id)->restore();
            session()->flash('message', 'User Restored Successfully.');
        }
    }
    public function activate($id)
{
    User::withTrashed()->find($id)->restore();
    session()->flash('message', 'User Activated Successfully.');
}
      // Método para mostrar usuarios activos
      public function showActive()
      {
          $this->showActive = true;
      }
      
      public function showInactive()
      {
          $this->showActive = false;
      }
      
      
}
