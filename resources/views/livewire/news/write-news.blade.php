<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <form wire:submit.prevent="createNews" class="space-y-6">
            @csrf
            <!-- Top Grid Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- NEWS TYPE -->
                <div class="flex flex-col items-center p-4 rounded-lg bg-gray-50 dark:bg-gray-800 h-full">
                    <label for="newsType" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">News
                        Type</label>
                    <select name="newsType" wire:model="newsType"
                        class="w-full px-4 py-2 border rounded-md bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="" class="text-gray-500 dark:text-gray-400" disabled>Select news type</option>
                        <option value="national">National</option>
                        <option value="local">Local</option>
                    </select>
                </div>

                <!-- COUNTY -->
                <div class="flex flex-col items-center p-4 rounded-lg bg-gray-50 dark:bg-gray-800 h-full">
                    <label for="county" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">County</label>
                    <p class="text-green-500 text-sm mb-1">{{$selectedCounty}}</p>
                    <div class="relative w-full">
                        <input id="county" type="text" wire:model.live="searchCounty"
                            placeholder="{{ $newsType === 'local' ? 'Search for a county...' : 'Select local news to enable' }}"
                            class="w-full px-4 py-2 mt-4 border rounded-md bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        @if(!empty($counties))
                            <ul
                                class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg max-h-60 overflow-y-auto">
                                @foreach($counties as $county)
                                    <li wire:click="selectCounty('{{ $county->id }}','{{ $county->name }}')"
                                        class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                                        {{ $county->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @elseif(!empty($searchCounty))
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No counties found for
                                "{{ $searchCounty }}".</p>
                        @endif
                    </div>
                </div>

                <!-- CONSTITUENCY -->
                <div class="flex flex-col items-center p-4 rounded-lg bg-gray-50 dark:bg-gray-800 h-full">
                    <label for="constituency"
                        class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Constituency</label>
                    <p class="text-green-500 text-sm mb-1">{{$selectedConstituency}}</p>
                    <div class="relative w-full">
                        <input id="constituency" type="text" wire:model.live="searchConstituency"
                            placeholder="Search for a constituency..."
                            class="w-full px-4 py-2 border rounded-md bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white" />

                        @if(!empty($constituencies))
                            <ul
                                class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg max-h-60 overflow-y-auto">
                                @foreach($constituencies as $constituency)
                                    <li wire:click="selectConstituency('{{ $constituency->id }}','{{$constituency->name}}')"
                                        class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer transition-colors
                                                                            {{ $selectedConstituencyId == $constituency->id ? 'bg-blue-50 dark:bg-blue-800' : '' }}">
                                        {{ $constituency->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @elseif(!empty($searchConstituency))
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                No constituencies found for "{{ $searchConstituency }}".
                            </p>
                        @endif
                    </div>
                </div>

                <!-- SUBCOUNTY -->
                <div class="flex flex-col items-center p-4 rounded-lg bg-gray-50 dark:bg-gray-800 h-full">
                    <label for="subcounty"
                        class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Subcounty</label>
                    <p class="text-green-500 text-sm mb-1">{{$selectedSubcounty}}</p>
                    <div class="relative w-full">
                        <input id="subcounty" type="text" wire:model.live="searchSubcounty"
                            placeholder="Search for a subcounty..."
                            class="w-full px-4 py-2 border rounded-md bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white" />

                        @if(!empty($subcounties))
                            <ul
                                class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg max-h-60 overflow-y-auto">
                                @foreach($subcounties as $subcounty)
                                    <li wire:click="selectSubcounty('{{ $subcounty->id }}','{{ $subcounty->name }}')"
                                        class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                                        {{ $subcounty->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @elseif(!empty($searchSubcounty))
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No subcounties found for
                                "{{ $searchSubcounty }}".</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Title Section -->
            <div class="flex flex-col p-6 rounded-lg bg-gray-50 dark:bg-gray-800 mb-6">
                <label for="title" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <textarea name="title" id="title" wire:model="title" rows="2"
                    class="w-full px-4 py-2 border rounded-md bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
            </div>

            <!-- Image Upload Section -->
            <div class="flex flex-col p-6 rounded-lg bg-gray-50 dark:bg-gray-800 mb-6">
                <label for="image" class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Featured
                    Image</label>
                <input type="file" name="image" id="image" wire:model="image"
                    class="w-full px-4 py-2 border rounded-md bg-white dark:bg-gray-700 dark:border-gray-600 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-gray-600 dark:file:text-gray-200 dark:hover:file:bg-gray-500">
            </div>

            <!-- Quill Editor Section -->
            {{-- <div class="flex flex-col p-6 rounded-lg bg-gray-50 dark:bg-gray-800 mb-6">
                <label class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
                <div wire:ignore>
                    <div id="quill-editor" style="height: 300px;" class="bg-white dark:bg-gray-700 rounded-md"></div> --}}
                    <textarea id="quill-content" name="content" wire:model.live="content" style="height: 300px;" class="w-full bg-white dark:bg-gray-700 rounded-md" ></textarea>

                {{-- </div> --}}
            {{-- </div> --}}

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" wire:loading.attr="disabled" type="button"
                    class="px-8 pl-6 bg-blue-600 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    <span wire:loading.remove wire:target="createNews">Publish News</span>
                    <span wire:loading wire:target="createNews">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Publishing...
                    </span>
                </button>

                {{-- <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center justify-center gap-2 disabled:opacity-70">
                    <span wire:loading.remove wire:target="createNews">Publish News</span>
                    <span wire:loading wire:target="createNews">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Publishing...
                    </span>
                </button> --}}
            </div>
        </form>
    </div>
</div>



<script>
    document.getElementById('quill-content').dispatchEvent(new Event('input'));

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Quill editor
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            },
            placeholder: 'Write your news content here...',
        });

        // Set initial content if there's any
        @if (isset($content) && !empty($content))
            console.log($content);
        quill.root.innerHTML = `{!! $content !!}`;
        @endif

        let timeout;
        quill.on('text-change', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const content = quill.root.innerHTML;
                document.getElementById('quill-content').value = content;
                Livewire.emit('quillContentUpdated', content);
            }, 300); // Debounce input
        });

        // Livewire hook to update editor when model changes
        Livewire.hook('message.processed', (message, component) => {
            console.log(message.updateQueue);
            if (message.updateQueue[0]?.payload.name === 'content') {
                quill.root.innerHTML = message.component.get('content');
            }
        });
    });
</script>