<div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl p-6 sm:p-10">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-100 flex items-center gap-3">

            📰 Publish News
        </h1>

        <form wire:submit.prevent="createNews" class="space-y-10">
            @csrf

            <!-- Top grid section -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 m-8">
                <!-- News Type -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">News Type</label>
                    <select wire:model.live="newsType"
                        class="w-full px-3 py-2 text-sm border-2 border-gray-200 dark:border-gray-600 rounded-full shadow-sm bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        <option value="" disabled>Select type…</option>
                        <option value="national">National</option>
                        <option value="local">Local</option>
                    </select>
                    @error('newsType')
                        <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- County -->
                <div class="space-y-2 relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">County</label>
                    <div class="relative">
                        <input type="text" wire:model.live="searchCounty"
                            placeholder="{{ $newsType === 'local' ? 'Search for a county…' : 'Select “Local” to enable' }}"
                            class="w-full px-3 py-2 text-sm border-2 border-gray-200 dark:border-gray-600 rounded-full shadow-sm bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            @disabled($newsType !== 'local') />

                    </div>
                    @if($selectedCounty)
                        <p class="text-green-600 text-sm font-medium flex items-center gap-1.5">

                            {{ $selectedCounty }}
                        </p>
                    @endif
                    @if(!empty($counties))
                        <ul
                            class="absolute z-20 w-full mt-1 bg-white dark:bg-gray-700 rounded-xl shadow-lg max-h-60 overflow-auto border border-gray-100 dark:border-gray-600">
                            @foreach($counties as $c)
                                <li wire:click="selectCounty('{{ $c->id }}','{{ $c->name }}')"
                                    class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer transition-colors
                                                           {{ $selectedCountyId == $c->id ? 'bg-blue-50 dark:bg-blue-900' : '' }}">
                                    {{ $c->name }}
                                </li>
                            @endforeach
                        </ul>
                    @elseif($searchCounty)
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">No counties found for "{{ $searchCounty }}"
                        </p>
                    @endif
                    @error('selectedCountyId') <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Constituency -->
                <div class="space-y-2 relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Constituency</label>
                    <div class="relative">
                        <input type="text" wire:model.live="searchConstituency" placeholder="Search for a constituency…"
                        class="w-full px-3 py-2 text-sm border-2 border-gray-200 dark:border-gray-600 rounded-full shadow-sm bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">

                    </div>
                    @if($selectedConstituency)
                        <p class="text-green-600 text-sm font-medium flex items-center gap-1.5">

                            {{ $selectedConstituency }}
                        </p>
                    @endif
                    @if(!empty($constituencies))
                        <ul
                            class="absolute z-20 w-full mt-1 bg-white dark:bg-gray-700 rounded-xl shadow-lg max-h-60 overflow-auto border border-gray-100 dark:border-gray-600">
                            @foreach($constituencies as $c)
                                <li wire:click="selectConstituency('{{ $c->id }}','{{ $c->name }}')"
                                    class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer transition-colors
                                                           {{ $selectedConstituencyId == $c->id ? 'bg-blue-50 dark:bg-blue-900' : '' }}">
                                    {{ $c->name }}
                                </li>
                            @endforeach
                        </ul>
                    @elseif($searchConstituency)
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">No constituencies found for
                            "{{ $searchConstituency }}"</p>
                    @endif
                    @error('selectedConstituencyId') <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Subcounty -->
                <div class="space-y-2 relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sub-county</label>
                    <div class="relative">
                        <input type="text" wire:model.live="searchSubcounty" placeholder="Search for a sub-county…"
                        class="w-full px-3 py-2 text-sm border-2 border-gray-200 dark:border-gray-600 rounded-full shadow-sm bg-white dark:bg-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">

                    </div>
                    @if($selectedSubcounty)
                        <p class="text-green-600 text-sm font-medium flex items-center gap-1.5">
                            {{-- <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg> --}}
                            {{ $selectedSubcounty }}
                        </p>
                    @endif
                    @if(!empty($subcounties))
                        <ul
                            class="absolute z-20 w-full mt-1 bg-white dark:bg-gray-700 rounded-xl shadow-lg max-h-60 overflow-auto border border-gray-100 dark:border-gray-600">
                            @foreach($subcounties as $s)
                                <li wire:click="selectSubcounty('{{ $s->id }}','{{ $s->name }}')"
                                    class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer transition-colors
                                                           {{ $selectedSubcountyId == $s->id ? 'bg-blue-50 dark:bg-blue-900' : '' }}">
                                    {{ $s->name }}
                                </li>
                            @endforeach
                        </ul>
                    @elseif($searchSubcounty)
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">No sub-counties found for
                            "{{ $searchSubcounty }}"</p>
                    @endif
                    @error('selectedSubcountyId') <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
<br/>
            <!-- Title Input -->
            <div class="space-y-2 w-full">
                <label class="block text-base font-semibold text-gray-800 dark:text-gray-200">Title</label>
                <input type="text" wire:model.live="title"
                    class="block w-full max-w-full px-3 py-2 text-lg font-semibold border-2 border-gray-200 dark:border-gray-600 rounded-full shadow-sm bg-white dark:bg-gray-700 placeholder-gray-400 dark:placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                    placeholder="Enter news title..." />
                @error('title')
                    <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

<br/>
<!-- Featured Image Upload -->
<div class="space-y-2">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Featured Image</label>

    <!-- Upload Container -->
    <div
        class="relative flex items-center justify-center w-full h-56 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl shadow-md bg-white dark:bg-gray-900 transition hover:border-blue-500 overflow-hidden group"
        x-data="{ isUploading: false }"
        x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false"
    >
        <!-- File Input -->
        <input
            type="file"
            wire:model="image"
            accept="image/*"
            id="featured-image-upload"
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
        />

        <!-- Clickable label that triggers the file input -->
        <label for="featured-image-upload" class="absolute inset-0 w-full h-full cursor-pointer">
            <!-- Conditional image preview or default icon -->
            @if ($image)
                <!-- Image Preview -->
                <div class="w-full h-full flex items-center justify-center">
                    <img
                        src="{{ is_string($image) ? asset($image) : $image->temporaryUrl() }}"
                        class="w-full h-full object-cover rounded-2xl"
                    />
                    <!-- Change image overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                        <span class="text-white font-medium">Change Image</span>
                    </div>
                </div>
            @else
                <!-- Default upload state -->
                <div class="pointer-events-none text-center p-4">
                    <img
                        src="{{ asset('images/upload.png') }}"
                        alt="Upload"
                        class="mx-auto w-10 h-10 object-contain opacity-70 group-hover:opacity-100 transition duration-200"
                    />
                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 group-hover:text-blue-500">
                        Click to upload or drag and drop
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                        Recommended: 1200x630 pixels
                    </p>
                </div>
            @endif
        </label>

        <!-- Loading indicator -->
        <template x-if="isUploading">
            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                <svg class="animate-spin h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </template>
    </div>

    <!-- Validation Error -->
    @error('image')
        <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
    @enderror
</div>


</div></br>

            {{-- new editor section --}}

            <div wire:ignore>
                <textarea name="content" id="snow-editor1" cols="30" rows="10"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-8 text-center">
                <button type="submit" wire:loading.attr="disabled" class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-black font-semibold rounded-xl transition-all
                               disabled:opacity-50 disabled:cursor-not-allowed w-full sm:w-auto">
                    <span wire:loading.remove>Publish News</span>
                    <span wire:loading class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Publishing...
                    </span>
                </button>
            </div>
            <script
                src="https://cdn.tiny.cloud/1/ul1npk37t68rbwppxs00ivosayatgvo58p26imn4nkk61s5w/tinymce/7/tinymce.min.js"
                referrerpolicy="origin"></script>

            <script>
                    tinymce.init({
                        selector: '#snow-editor1',
                        plugins: 'code table lists',
                        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
                        setup: function (editor) {
                            // Set initial content from Livewire (escaped properly)
                            editor.on('init', function (e) {
                                editor.setContent(@this.get('content'));
                            });

                            // Update Livewire when content changes
                            editor.on('Change KeyUp', function () {
                                @this.set('content', editor.getContent());
                            });
                        }
                    });
            </script>

        </form>
    </div>
</div>