{{-- SECTION KONSULTASI (Modern, Minimalis, & Full Portrait Card Style) --}}
<section
    x-data="{
        selected: {{ $consultations->first()?->id ?? 'null' }},
        consultations: @js($consultations),

        get current(){
            return this.consultations.find(item => item.id == this.selected);
        },

        get whatsappLink(){
            if(!this.current || !this.current.phone) return 'javascript:void(0)';

            let phone = this.current.phone.replace(/[^0-9]/g, '');
            if (phone.startsWith('0')) {
                phone = '62' + phone.slice(1);
            }

            return 'https://wa.me/' + phone;
        },

        get isAvailable(){
            return !!(this.current && this.current.phone && this.current.officer_name);
        }
    }"
    class="relative w-full overflow-hidden bg-white flex items-center py-10 lg:py-16 lg:min-h-[calc(100svh-6rem)]">

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- MAIN CARD CONTAINER --}}
        <div class="relative overflow-hidden rounded-[32px] sm:rounded-[40px] bg-slate-50/50 border border-slate-100 shadow-xl shadow-slate-200/50 p-6 sm:p-8 lg:p-12">

            {{-- Background Soft Blur Accents --}}
            <div class="pointer-events-none absolute -top-24 -left-24 h-80 w-80 rounded-full bg-blue-100/60 blur-[100px]"></div>
            <div class="pointer-events-none absolute -bottom-24 -right-24 h-80 w-80 rounded-full bg-purple-100/60 blur-[100px]"></div>

            <div class="relative grid items-center gap-8 lg:grid-cols-12 lg:gap-12">

                {{-- ================= KOLOM KIRI: INFORMASI & PILIHAN ================= --}}
                <div class="lg:col-span-7 flex flex-col items-center text-center lg:items-start lg:text-left">

                    {{-- Badge --}}
                    <span class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-1.5 text-xs sm:text-sm font-semibold text-purple-600 shadow-sm ring-1 ring-slate-200/60">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-purple-400 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-purple-600"></span>
                        </span>
                        Layanan Konsultasi Online
                    </span>

                    {{-- Heading --}}
                    <h2 class="mt-4 text-3xl sm:text-4xl lg:text-[2.55rem] font-extrabold tracking-tight text-slate-900 leading-[1.15]">
                        Konsultasikan Permasalahan <br class="hidden sm:inline">
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-rose-600 bg-clip-text text-transparent">
                            Kesehatan Anda
                        </span>
                    </h2>

                    {{-- Deskripsi --}}
                    <p class="mt-4 max-w-xl text-sm sm:text-base leading-relaxed text-slate-600">
                        Pilih topik kesehatan yang ingin dikonsultasikan. Sistem akan menghubungkan Anda secara langsung dengan petugas medis yang bertanggung jawab melalui WhatsApp.
                    </p>

                    {{-- Dropdown Pilih Topik --}}
                    <div class="mt-6 w-full max-w-md text-left">
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-400">
                            Pilih Topik Konsultasi
                        </label>

                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-purple-600">
                                <i class="ti ti-stethoscope text-xl"></i>
                            </span>

                            <select
                                x-model="selected"
                                class="w-full appearance-none rounded-2xl border border-slate-200/80 bg-white py-3.5 pl-12 pr-12 text-sm sm:text-base font-semibold text-slate-800 shadow-sm transition focus:border-purple-500 focus:outline-none focus:ring-4 focus:ring-purple-100">
                                <template x-for="item in consultations" :key="item.id">
                                    <option :value="item.id" x-text="item.topic"></option>
                                </template>
                            </select>

                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                <i class="ti ti-chevron-down text-lg"></i>
                            </span>
                        </div>
                    </div>

                    {{-- Keunggulan (Badge List) --}}
                    <div class="mt-6 flex flex-wrap justify-center gap-3 lg:justify-start">
                        <div class="inline-flex items-center gap-2.5 rounded-2xl bg-white px-4 py-2.5 shadow-sm ring-1 ring-slate-200/60">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <i class="ti ti-shield-check text-lg"></i>
                            </span>
                            <div class="text-left leading-tight">
                                <p class="text-xs font-bold text-slate-800">100% Gratis</p>
                                <p class="text-[11px] text-slate-400">Tanpa biaya layanan</p>
                            </div>
                        </div>

                        <div class="inline-flex items-center gap-2.5 rounded-2xl bg-white px-4 py-2.5 shadow-sm ring-1 ring-slate-200/60">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                                <i class="ti ti-bolt text-lg"></i>
                            </span>
                            <div class="text-left leading-tight">
                                <p class="text-xs font-bold text-slate-800">Respons Cepat</p>
                                <p class="text-[11px] text-slate-400">Langsung via WhatsApp</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ================= KOLOM KANAN: KARTU PETUGAS STYLE REFERENSI ================= --}}
                <div class="lg:col-span-5 w-full mx-auto max-w-md lg:max-w-none">

                    {{-- Wrapper Card Utama --}}
                    <div class="relative overflow-hidden rounded-[28px] bg-white shadow-xl shadow-slate-200/60 border border-slate-100 p-4 sm:p-5">

                        {{-- Kotak Foto Petugas dengan Gradasi Latar Belakang --}}
                        <div class="relative h-72 sm:h-80 w-full overflow-hidden rounded-2xl bg-gradient-to-tr from-blue-500 via-indigo-500 to-purple-500 flex items-end justify-center shadow-inner">

                            {{-- Foto Petugas --}}
                            <template x-if="current?.photo_url">
                                <img :src="current.photo_url"
                                     :alt="current.officer_name"
                                     loading="lazy"
                                     class="absolute inset-0 h-full w-full object-cover object-top">
                            </template>

                            <template x-if="!current?.photo_url">
                                <div class="absolute inset-0 flex items-center justify-center text-white/80">
                                    <i class="ti ti-user text-7xl"></i>
                                </div>
                            </template>

                            {{-- Status Badge (Online/Offline) di Pojok Kanan Atas Foto --}}
                            <div class="absolute top-4 right-4 z-10">
                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold backdrop-blur shadow-sm ring-1"
                                    :class="isAvailable ? 'bg-white/90 text-emerald-700 ring-emerald-200/50' : 'bg-white/90 text-slate-500 ring-slate-200/50'">
                                    <span class="h-1.5 w-1.5 rounded-full"
                                        :class="isAvailable ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400'"></span>
                                    <span x-text="isAvailable ? 'Online' : 'Offline'"></span>
                                </span>
                            </div>

                        </div>

                        {{-- Card Bagian Bawah (Floating White Box) --}}
                        <div class="relative -mt-10 mx-3 sm:mx-4 rounded-2xl bg-white p-5 shadow-lg ring-1 ring-slate-100 text-center">

                            {{-- Nama Petugas --}}
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900"
                                x-text="current?.officer_name || 'Belum Tersedia'">
                            </h3>

                            {{-- Bio Singkat / Deskripsi Petugas --}}
                            <p x-show="current?.bio"
                               x-text="current?.bio"
                               class="mt-2 text-xs sm:text-sm leading-relaxed text-slate-500 line-clamp-2">
                            </p>

                            {{-- Topik Kesehatan Info --}}
                            <div class="mt-4 flex items-center justify-between text-xs border-t border-slate-100 pt-3">
                                <span class="text-slate-400 font-medium">Topik Kesehatan</span>
                                <span class="rounded-full bg-purple-50 px-3 py-1 font-semibold text-purple-700"
                                    x-text="current?.topic || '-'">
                                </span>
                            </div>

                            {{-- Tombol WhatsApp --}}
                            <a :href="whatsappLink"
                               :target="isAvailable ? '_blank' : '_self'"
                               :rel="isAvailable ? 'noopener noreferrer' : ''"
                               :class="isAvailable
                                    ? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-md shadow-emerald-200 hover:-translate-y-0.5 active:scale-[0.98] cursor-pointer'
                                    : 'bg-slate-100 text-slate-400 cursor-not-allowed pointer-events-none'"
                               class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl py-3 text-sm font-bold transition duration-200">
                                <i class="ti ti-brand-whatsapp text-xl"></i>
                                <span x-text="isAvailable ? 'Hubungi via WhatsApp' : 'Konsultasi Tidak Tersedia'"></span>
                            </a>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>