<div class="p-3">
    @session('success')
    <div class="alert alert-success">
        {{ $value }}
    </div>
    @endsession
    <form wire:submit="createUser" class="w-50 mx-auto card shadow-lg my-3 p-3">
        <div class="">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" @class(['form-control', 'border-danger'=> $errors->has('name')])
            wire:model.blur="name">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" wire:model="email">
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="">
            <label for="password">Password</label>
            <input type="text" name="password" id="password" class="form-control" wire:model="password">
            @error('password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create User</button>
    </form>

    <div class="card shadow">
        <table class="table">
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Created on</th>
            </thead>
            @foreach ($users as $key => $user)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    {{ $users->links() }}
</div>