<?php

namespace App\Http\Livewire;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selected_user_id,$users_in_site,$hod;

    public $name,$email,$job_title,$department,$site,$manager_id,$HOD_id,$status;

    public $search;
    

    public function edit($id)
    {
        $user = User::find($id);
        $this->users_in_site = User::where('role_manager',true)->get();

        $this->hod = User::where('role_HOD',true)->get();
        
        $this->selected_user_id = $user->id;

        $this->email = $user->email;
        $this->name = $user->name;
        $this->department = $user->department;
        $this->site = $user->site;
        $this->job_title = $user->job_title;
        $this->manager_id = $user->manager_id;
        $this->HOD_id = $user->HOD_id;
        $this->status = $user->status;
    }

    public function save(){
        $validated_date = $this->validate([
            'email'=>'required',
            'name'=>'required',
            'job_title'=>'required',
            'department'=>'required',
            'site'=>'required',
            'HOD_id'=>'required',
            'manager_id'=>'required',
            'status'=>'required',
        ],[
            'HOD_id.required' => 'HOD is required',
            'manager_id.required' => 'Manager is required',
        ]);

        User::findOrFail($this->selected_user_id)->update($validated_date);
        $this->emit('userUpdated');
        session()->flash('message', 'User successfully updated.');
    }

    public function render()
    {
        return view('livewire.users',[
            'users' => User::with('manager','HOD')
                    ->when($this->search != '', function($q){
                        $q->where('name','LIKE', '%' . $this->search . '%')
                          ->orWhere('job_title','LIKE', '%' . $this->search . '%')
                          ->orWhere('department','LIKE', '%' . $this->search . '%')
                          ->orWhere('site','LIKE', '%' . $this->search . '%')
                          ->orWhere('email','LIKE', '%' . $this->search . '%');
                    })
                    ->orderBy('name', 'asc')
                    ->paginate(15),
        ]);
    }
}
