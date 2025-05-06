<div>
    <div>
        @foreach ($financials as $index => $financial)
            <div class="mb-4 border p-4 rounded">
                <input type="text" wire:model="financials.{{ $index }}.name" placeholder="Name" class="block mb-2 w-full border rounded p-2" />
                <input type="number" wire:model="financials.{{ $index }}.amount" placeholder="Amount" class="block mb-2 w-full border rounded p-2" />
                <textarea wire:model="financials.{{ $index }}.description" placeholder="Description" class="block mb-2 w-full border rounded p-2"></textarea>
            </div>
        @endforeach

        <button wire:click="addFinancial" type="button" class="bg-green-900 text-black p-2 rounded">Add Financial Field</button>

        <button wire:click="save" type="button" class="bg-blue-500 text-black p-2 rounded mt-4">Save Financials</button>

        @if (session()->has('message'))
            <div class="text-green-500 mt-4">{{ session('message') }}</div>
        @endif
    </div>
</div>
