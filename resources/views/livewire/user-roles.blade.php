<div>
    <form wire:submit.prevent="assignRoleToUser">
        <input type="hidden" name="user_id" wire:model="userId" />

        <select wire:model="role" required>
            @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>

        <button type="submit">Assign Role</button>
    </form>
</div>
