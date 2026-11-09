{{-- ============================================================
     POPUP PERINGATAN MASA AKTIF HOSTING
     Muncul sekali setiap web dibuka (per sesi browser).
     Matikan: HOSTING_ALERT=false di .env (lalu php artisan config:clear)
     Hapus total: hapus @include('partials.hosting-alert') di layout
     ============================================================ --}}
@if(config('app.hosting_alert', false))
<div x-data="{
        show: false,
        key: 'hosting_alert_dismissed',
        init() {
            try { this.show = !sessionStorage.getItem(this.key); } catch (e) { this.show = true; }
            document.body.classList.toggle('overflow-hidden', this.show);
            this.$watch('show', v => document.body.classList.toggle('overflow-hidden', v));
        },
        close() {
            this.show = false;
            try { sessionStorage.setItem(this.key, '1'); } catch (e) {}
        }
     }"
     x-show="show"
     x-cloak
     @keydown.escape.window="if (show) close()"
     class="fixed inset-0 z-[200] flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="hosting-alert-title">

    {{-- Latar gelap (klik untuk menutup) --}}
    <div x-show="show"
         x-transition.opacity
         @click="close()"
         class="absolute inset-0 bg-black/60"></div>

    {{-- Kotak modal --}}
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-6 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-white rounded-xl border-t-[6px] border-red-600 shadow-2xl">

        {{-- Tombol tutup --}}
        <button type="button"
                @click="close()"
                class="absolute right-4 top-4 z-10 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-full p-1 transition"
                aria-label="Tutup">
            <i class="ti ti-x text-2xl"></i>
        </button>

        <div class="p-6 sm:p-10">

            {{-- Badge --}}
            <span class="inline-block bg-red-600 text-white text-xs font-bold tracking-wide px-3 py-1.5 rounded">
                PENTING
            </span>

            {{-- Judul & isi --}}
            <h2 id="hosting-alert-title" class="mt-6 text-2xl sm:text-3xl font-semibold text-slate-900">
                Masa aktif hosting akan segera berakhir!
            </h2>

            <p class="mt-4 text-sm sm:text-base text-slate-700 leading-relaxed">
                Pemberitahuan: masa aktif hosting website ini
                @if(config('app.hosting_expired_at'))
                    akan berakhir pada
                    <strong>{{ \Carbon\Carbon::parse(config('app.hosting_expired_at'))->translatedFormat('d F Y') }}</strong>.
                @else
                    akan segera berakhir.
                @endif
            </p>

            <p class="mt-3 text-sm sm:text-base text-slate-700 leading-relaxed">
                <strong>Mohon segera lakukan pembayaran perpanjangan</strong> agar website tetap dapat
                diakses oleh pengunjung dan seluruh data tetap aman.
            </p>

            {{-- Tombol aksi --}}
            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                @if(config('app.hosting_contact_url'))
                    <a href="{{ config('app.hosting_contact_url') }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-lg transition">
                        <i class="ti ti-brand-whatsapp text-xl"></i>
                        Hubungi untuk Pembayaran
                    </a>
                @endif
                <button type="button" @click="close()"
                        class="inline-flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold px-6 py-3 rounded-lg transition">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>
@endif