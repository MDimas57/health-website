<div class="md:sticky md:top-24 flex flex-col gap-4 sm:gap-6">

    {{-- Layout Grid Berdampingan di Mobile, Bertumpuk di Desktop --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 gap-4">
        
        {{-- 1. Blok Dropdown Kategori (Kembali Ke Sidebar) --}}
        <div class="bg-white rounded-[20px] md:rounded-[24px] border border-slate-100 p-4 sm:p-5 md:p-6 shadow-sm">
            <h3 class="font-bold text-sm md:text-base text-slate-900 tracking-tight flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span>Pilih Kategori</span>
            </h3>

            <div class="mt-3 relative">
                <select
                    onchange="location=this.value"
                    class="w-full pl-3 pr-8 py-2 sm:py-2.5 rounded-xl border border-slate-200 
                           text-xs sm:text-sm font-medium text-slate-700 bg-white cursor-pointer appearance-none
                           focus:border-blue-500 focus:ring focus:ring-blue-100 focus:outline-none transition duration-200">
                    
                    <option value="{{ route('documents.index', request()->except(['category', 'page'])) }}" {{ !request('category') ? 'selected' : '' }}>
                        Semua Kategori
                    </option>

                    @foreach($categories as $category)
                        <option 
                            value="{{ route('documents.index', array_merge(request()->except('page'), ['category' => $category->slug])) }}"
                            @selected(request('category') == $category->slug)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                
                {{-- Panah Chevron Custom --}}
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- 2. Blok Urutkan --}}
        <div class="bg-white rounded-[20px] md:rounded-[24px] border border-slate-100 p-4 sm:p-5 md:p-6 shadow-sm">
            <h3 class="font-bold text-sm md:text-base text-slate-900 tracking-tight flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                </svg>
                <span>Urutan Tampilan</span>
            </h3>

            <div class="mt-3 relative">
                <select
                    onchange="location=this.value"
                    class="w-full pl-3 pr-8 py-2 sm:py-2.5 rounded-xl border border-slate-200 
                           text-xs sm:text-sm font-medium text-slate-700 bg-white cursor-pointer appearance-none
                           focus:border-blue-500 focus:ring focus:ring-blue-100 focus:outline-none transition duration-200">

                    <option
                        value="{{ route('documents.index', request()->except(['sort', 'page']) + ['sort'=>'latest']) }}"
                        @selected(request('sort') == 'latest' || !request('sort'))>
                        Terbaru Rilis
                    </option>

                    <option
                        value="{{ route('documents.index', request()->except(['sort', 'page']) + ['sort'=>'oldest']) }}"
                        @selected(request('sort') == 'oldest')>
                        Terlama Rilis
                    </option>

                    <option
                        value="{{ route('documents.index', request()->except(['sort', 'page']) + ['sort'=>'popular']) }}"
                        @selected(request('sort') == 'popular')>
                        Paling Banyak Diunduh
                    </option>
                </select>

                {{-- Panah Chevron Custom --}}
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

</div>