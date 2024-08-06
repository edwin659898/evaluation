<div class="content">
    <div class="container">

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="text-green-800 card-title">
                            Employees
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body px-4 table-responsive">
                        @if (session()->has('message'))
                        <div class="bg-blue-400 text-white mt-2 px-4 py-2 rounded-md">
                            {{ session('message') }}
                        </div>
                        @endif
                        <!-- component -->
                        <div class="flex justify-end">
                            <div class="relative mr-6 my-2">
                                <input type="text" wire:model="search" class="bg-purple-white shadow rounded border-0" placeholder="Search...">
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Job Title</th>
                                    <th scope="col">Dept</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Site</th>
                                    <th scope="col">User Manager</th>
                                    <th scope="col">User HOD</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                @if ($selected_user_id == $user->id)

                                @endif
                                <tr>
                                    <th scope="row">{{$user->id}}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->job_title }}</td>
                                    <td>{{ $user->department }}</td>
                                    <td>
                                        @if ($user->status)
                                        Active
                                        @else
                                        Inactive
                                        @endif
                                    </td>
                                    <td>{{ $user->status }}</td>
                                    <td>{{ $user->manager->job_title }}</td>
                                    <td>{{ $user->HOD->job_title }}</td>
                                    <td><i wire:click="edit({{$user->id}})" data-toggle="modal" data-target="#exampleModal" class="fa fa-edit text-green-500 hover:text-green-800 cursor-pointer"></i></td>
                                </tr>

                                @empty
                                <tr>
                                    <td>
                                        <p>No users found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="flex justify-end mt-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($selected_user_id != '')
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Employee: {{$name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">

                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" wire:model.defer="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" wire:model.defer="email" class="form-control" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label>Job Title</label>
                            <input type="text" wire:model.defer="job_title" class="form-control" name="email" value="{{ $user->job_title }}">
                        </div>
                        <div class="form-group">
                            <label>Dept</label>
                            <select wire:model.defer="department" class="form-control">
                                <option value="">Select Department</option>
                                <option value="IT">IT</option>
                                <option value="M&E">M&E</option>
                                <option value="Communications">Communications</option>
                                <option value="Accounts">Accounts</option>
                                <option value="Operations">Operations</option>
                                <option value="Human Resources">Human Resources</option>
                                <option value="Forestry">Forestry</option>
                                <option value="Miti Magazine">Miti Magazine</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Site</label>
                            <select wire:model.defer="site" class="form-control">
                                <option value="">Select Site</option>
                                <option value="Head Office">Head Office</option>
                                <option value="Kiambere">Kiambere</option>
                                <option value="Dokolo">Dokolo</option>
                                <option value="Nyongoro">Nyongoro</option>
                                <option value="7 Forks">7 Forks</option>
                                <option value="Sosoma">Sosoma</option>
                                <option value="Kampala">Kampala</option>
                                <option value="Tanzania">Tanzania</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Manager Title</label>
                            <select wire:model.defer="manager_id" class="form-control">
                                <option value="">Select</option>
                                @foreach ($users_in_site as $user)
                                @if ($user->id != 1)
                                <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>HOD Title</label>
                            <select wire:model.defer="HOD_id" class="form-control">
                                <option value="">Select</option>
                                @foreach ($hod as $user)
                                @if ($user->id != 1)
                                <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select wire:model.defer="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>