@php
    $id = 'pyramid-' . \Illuminate\Support\Str::random(8);
    $rows = collect($block['data'] ?? [])->values();
    $isPercent = ($block['unit'] ?? 'jiwa') === 'persen';
    $suffix = $isPercent ? '%' : ' jiwa';

    $male = $rows->sum(fn ($r) => (float) ($r['male'] ?? 0));
    $female = $rows->sum(fn ($r) => (float) ($r['female'] ?? 0));
    $total = $male + $female;

    // Indeks tetap: 0-2 = usia 0-14, 3-12 = usia 15-64, 13-15 = usia 65+
    $sumRange = fn (int $from, int $to) => $rows->slice($from, $to - $from + 1)
        ->sum(fn ($r) => (float) ($r['male'] ?? 0) + (float) ($r['female'] ?? 0));
    $young = $sumRange(0, 2);
    $working = $sumRange(3, 12);
    $old = $sumRange(13, 15);

    $sexRatio = $female > 0 ? $male / $female * 100 : null;
    $dependency = $working > 0 ? ($young + $old) / $working * 100 : null;

    // Urutan dibalik agar kelompok umur tertua berada di atas piramida
    $reversed = $rows->reverse()->values();
    $labels = $reversed->pluck('age_group')->all();
    $maleValues = $reversed->map(fn ($r) => -1 * (float) ($r['male'] ?? 0))->all();
    $femaleValues = $reversed->map(fn ($r) => (float) ($r['female'] ?? 0))->all();
    $max = max(1, collect($maleValues)->map(fn ($v) => abs($v))->max(), collect($femaleValues)->max());
@endphp

<figure class="my-6">
    <figcaption class="mb-1 font-semibold">{{ $block['title'] }}</figcaption>
    <p class="mb-3 text-sm text-gray-600">{{ $block['area'] ?? '' }} @if(filled($block['year'] ?? null)) · {{ $block['year'] }} @endif</p>

    <div class="mb-4 grid grid-cols-2 gap-3 md:grid-cols-4">
        <div class="rounded-lg border p-3">
            <div class="text-xs text-gray-500">Total Penduduk</div>
            <div class="text-lg font-semibold">{{ number_format($total, $isPercent ? 1 : 0, ',', '.') }}{{ $suffix }}</div>
        </div>
        <div class="rounded-lg border p-3">
            <div class="text-xs text-gray-500">Laki-laki / Perempuan</div>
            <div class="text-lg font-semibold">
                {{ number_format($male, $isPercent ? 1 : 0, ',', '.') }} / {{ number_format($female, $isPercent ? 1 : 0, ',', '.') }}
            </div>
        </div>
        <div class="rounded-lg border p-3">
            <div class="text-xs text-gray-500">Rasio Jenis Kelamin</div>
            <div class="text-lg font-semibold">{{ $sexRatio ? number_format($sexRatio, 1, ',', '.') : '-' }}</div>
        </div>
        <div class="rounded-lg border p-3">
            <div class="text-xs text-gray-500">Rasio Ketergantungan</div>
            <div class="text-lg font-semibold">{{ $dependency ? number_format($dependency, 1, ',', '.') : '-' }}</div>
        </div>
    </div>

    <div class="relative h-[28rem]">
        <canvas id="{{ $id }}"></canvas>
    </div>

    <details class="mt-3 text-sm">
        <summary class="cursor-pointer text-gray-700">Lihat data dalam tabel</summary>
        <div class="mt-2 overflow-x-auto">
            <table class="min-w-full border text-left">
                <thead class="bg-gray-50">
                    <tr><th class="p-2">Umur</th><th class="p-2">Laki-laki</th><th class="p-2">Perempuan</th></tr>
                </thead>
                <tbody>
                    @foreach ($rows as $r)
                        <tr class="border-t">
                            <td class="p-2">{{ $r['age_group'] }}</td>
                            <td class="p-2">{{ number_format((float) $r['male'], $isPercent ? 1 : 0, ',', '.') }}</td>
                            <td class="p-2">{{ number_format((float) $r['female'], $isPercent ? 1 : 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </details>

    <p class="mt-3 text-xs text-gray-500">
        Rasio jenis kelamin = laki-laki per 100 perempuan. Rasio ketergantungan = jumlah penduduk usia 0–14 dan 65+ per 100 penduduk usia 15–64.
    </p>

    @if (filled($block['description'] ?? null))
        <p class="mt-2 text-sm text-gray-700">{{ $block['description'] }}</p>
    @endif
    @if (filled($block['source'] ?? null))
        <p class="mt-1 text-xs text-gray-500">Sumber: {{ $block['source'] }}</p>
    @endif
</figure>


@push('scripts')
<script>
(function () {
    const init = () => {
        const canvas = document.getElementById(@json($id));
        if (!canvas || typeof Chart === 'undefined') return;

        const suffix = @json($suffix);
        const max = @json($max);
        const fmt = (v) => Math.abs(v).toLocaleString('id-ID');

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [
                    { label: 'Laki-laki', data: @json($maleValues), backgroundColor: '#2563eb' },
                    { label: 'Perempuan', data: @json($femaleValues), backgroundColor: '#db2777' },
                ],
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                barPercentage: 1,
                categoryPercentage: 0.95,
                scales: {
                    x: {
                        stacked: true,
                        min: -max,
                        max: max,
                        ticks: { callback: (v) => fmt(v) },
                    },
                    y: { stacked: true },
                },
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.dataset.label}: ${fmt(ctx.raw)}${suffix}`,
                        },
                    },
                },
            },
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endpush