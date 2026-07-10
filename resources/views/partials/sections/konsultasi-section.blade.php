{{-- SECTION DENGAN FULL BACKGROUND SEPERTI SECTION VIDEO --}}
<section
    x-data="{
        selected: {{ $categories->first()?->id ?? 'null' }},
        categories: @js($categories),

        get current(){
            return this.categories.find(item => item.id == this.selected);
        },

        get whatsappLink(){
            if(!this.current || !this.current.consultation_phone) return 'javascript:void(0)';

            return 'https://wa.me/' + this.current.consultation_phone.replace(/[^0-9]/g,'');
        },

        get isAvailable(){
            return this.current && this.current.consultation_phone && this.current.consultation_name;
        }
    }"
    class="relative py-12 md:py-20
           w-screen
           ml-[calc(50%-50vw)]
           overflow-hidden
           bg-white"> {{-- Menggunakan bg-white penuh ke kanan-kiri layar --}}
    {{-- PEMBUNGKUS KONTEN UTAMA: Menjamin lebar & alignment sejajar pas dengan Section Video --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- MAIN CARD CONTAINER (Card melayang di tengah section yang full-width) --}}
        <div
            class="relative
                   overflow-hidden
                   rounded-[32px] sm:rounded-[40px]
                   border border-slate-200/80
                   bg-gradient-to-br
                   from-white
                   via-slate-50/40
                   to-rose-50/20
                   p-6
                   sm:p-10
                   lg:p-16
                   shadow-xl shadow-slate-200/60">

            {{-- Background Blur Overlays di dalam Card --}}
            <div class="absolute -top-40 -left-40 w-[300px] sm:w-[500px] h-[300px] sm:h-[500px] rounded-full bg-blue-100 blur-[100px] sm:blur-[140px] opacity-50 pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] sm:w-[500px] h-[300px] sm:h-[500px] rounded-full bg-purple-100 blur-[100px] sm:blur-[140px] opacity-40 pointer-events-none"></div>
            <div class="absolute -bottom-40 -right-40 w-[300px] sm:w-[500px] h-[300px] sm:h-[500px] rounded-full bg-rose-100 blur-[100px] sm:blur-[140px] opacity-50 pointer-events-none"></div>

            {{-- Grid Konten di dalam Card --}}
            <div class="relative grid lg:grid-cols-12 gap-8 lg:gap-14 items-center">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-7 flex flex-col items-start">
                    
                    {{-- LEFT COLUMN: BADGE, HEADING, & DESKRIPSI SAJA --}}
                    <div class="lg:col-span-7 flex flex-col items-center lg:items-start text-center lg:text-left">
                        
                        {{-- BADGE (Di-center dengan mx-auto pada mobile) --}}
                        <span
                            class="inline-flex items-center gap-2
                                px-4 py-2 mx-auto lg:mx-0
                                rounded-full
                                bg-rose-50
                                text-rose-600
                                border border-rose-100
                                text-xs sm:text-sm
                                font-semibold tracking-wide">
                            <i class="ti ti-brand-whatsapp text-lg"></i>
                            Konsultasi Online
                        </span>

                        {{-- HEADING --}}
                        <h2
                            class="mt-4 sm:mt-6
                                text-3xl sm:text-4xl lg:text-5xl
                                font-extrabold
                                text-slate-900
                                leading-tight
                                tracking-tight">
                            Konsultasikan <br class="hidden sm:inline"/>
                            Permasalahan
                            <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-rose-600 bg-clip-text text-transparent">
                                Kesehatan Anda
                            </span>
                        </h2>

                        {{-- DESKRIPSI (mx-auto agar blok pembungkus max-w tetap center di mobile) --}}
                        <p
                            class="mt-4 sm:mt-6
                                text-base sm:text-lg
                                leading-relaxed
                                text-slate-600
                                max-w-xl mx-auto lg:mx-0">
                            Pilih kategori kesehatan yang ingin Anda konsultasikan.
                            Sistem akan menghubungkan Anda langsung kepada petugas
                            yang bertanggung jawab pada bidang tersebut melalui
                            WhatsApp.
                        </p>

                    </div>

                    <div class="mt-8 w-full max-w-md">
                        <label
                            class="block
                                   mb-2.5
                                   text-sm sm:text-base
                                   font-semibold
                                   text-slate-700">
                            Pilih Topik Konsultasi
                        </label>

                        <div class="relative">
                            <select
                                x-model="selected"
                                class="w-full
                                       appearance-none
                                       rounded-2xl
                                       border border-slate-300
                                       bg-white
                                       py-3.5 sm:py-4
                                       pl-5 pr-12
                                       text-sm sm:text-base
                                       text-slate-800
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-purple-500
                                       focus:border-purple-500
                                       transition">
                                <template x-for="item in categories" :key="item.id">
                                    <option :value="item.id" x-text="item.name"></option>
                                </template>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                <i class="ti ti-chevron-down text-lg"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Features List --}}
                    <div class="grid grid-cols-2 gap-4 sm:gap-6 mt-8 sm:mt-10 w-full max-w-xl border-t border-slate-200/60 pt-6">
                        
                        <div class="flex gap-3 items-start">
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-blue-50 flex shrink-0 items-center justify-center">
                                <i class="ti ti-gift text-blue-600 text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm sm:text-base text-slate-800">Gratis</h4>
                                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Tanpa biaya konsultasi.</p>
                            </div>
                        </div>

                        <div class="flex gap-3 items-start">
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-purple-50 flex shrink-0 items-center justify-center">
                                <i class="ti ti-bolt text-purple-600 text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm sm:text-base text-slate-800">Cepat</h4>
                                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Respons langsung via WA.</p>
                            </div>
                        </div>

                    </div>

                </div>

                {{-- RIGHT COLUMN (INNER MINI CARD) --}}
                <div class="lg:col-span-5 w-full mt-4 lg:mt-0">
                    
                    <div
                        class="bg-white/90
                               backdrop-blur-sm
                               rounded-3xl
                               border
                               border-slate-200/80
                               shadow-lg shadow-slate-100/50
                               p-6 sm:p-8">

                        <div class="flex justify-between items-center">
                            
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16
                                       rounded-2xl
                                       bg-gradient-to-br
                                       from-blue-600
                                       via-purple-600
                                       to-rose-500
                                       text-white
                                       flex
                                       items-center
                                       justify-center
                                       shadow-md shadow-purple-100">
                                <i class="ti ti-user-heart text-2xl sm:text-3xl"></i>
                            </div>

                            {{-- Status Badge --}}
                            <template x-if="isAvailable">
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold flex items-center gap-1.5 animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Online
                                </span>
                            </template>
                            <template x-if="!isAvailable">
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    Offline
                                </span>
                            </template>

                        </div>

                        <div class="mt-6 sm:mt-8">
                            <p class="text-xs font-medium tracking-wide text-slate-400">
                                Petugas Konsultasi
                            </p>
                            <h3
                                class="text-lg sm:text-2xl
                                       font-bold
                                       text-slate-900
                                       mt-1"
                                x-text="current?.consultation_name || 'Belum Tersedia'">
                            </h3>
                        </div>

                        <div class="mt-6 border-t border-slate-100 pt-5">
                            <div class="flex justify-between items-center gap-4 text-sm sm:text-base">
                                <span class="text-slate-500">Topik Kesehatan</span>
                                <strong
                                    class="text-purple-600 font-semibold text-right"
                                    x-text="current?.name || '-'">
                                </strong>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        <a
                            :href="whatsappLink"
                            :target="isAvailable ? '_blank' : '_self'"
                            :class="isAvailable 
                                ? 'bg-green-600 text-white shadow-lg shadow-green-100 active:scale-[0.98] lg:hover:scale-[1.02] cursor-pointer' 
                                : 'bg-slate-100 text-slate-400 cursor-not-allowed pointer-events-none'"
                            class="mt-8
                                   inline-flex
                                   w-full
                                   justify-center
                                   items-center
                                   gap-3
                                   rounded-2xl
                                   py-4
                                   font-bold
                                   transition duration-200">
                            <i class="ti ti-brand-whatsapp text-2xl"></i>
                            <span x-text="isAvailable ? 'Hubungi via WhatsApp' : 'Konsultasi Tidak Tersedia'"></span>
                        </a>

                        <p
                            class="mt-4
                                   text-xs
                                   text-center
                                   text-slate-400
                                   leading-relaxed"
                            x-text="isAvailable 
                                ? 'Nomor WhatsApp akan otomatis disesuaikan dengan topik yang Anda pilih di atas.' 
                                : 'Petugas belum dikonfigurasi untuk kategori ini. Silakan pilih topik lain.'">
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>