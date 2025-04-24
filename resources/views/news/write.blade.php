<x-app-layout>
   
    @if(session('success'))
        <div class="p-2 bg-green-200 text-green-800 rounded mb-2">
            {{ session('success') }}
        </div>
    @endif

@livewire('news.write-news')

</x-app-layout>