{{-- <x-app-layout>

    @if(session('success'))
    <div class="p-2 bg-green-200 text-green-800 rounded mb-2">
        {{ session('success') }}
    </div>
    @endif



</x-app-layout> --}}

@extends('layouts.vertical', ['title' => 'Write News'])

@section('css')
    @vite(['node_modules/quill/dist/quill.bubble.css', 'node_modules/quill/dist/quill.snow.css'])

@endsection

@section('content')

     @livewire('news.write-news')

@endsection

    @section('script-bottom')
        @vite(['resources/js/components/form-quilljs.js'])
    @endsection

