@php
    $id = 'chart-' . \Illuminate\Support\Str::random(8);
    $type = $block['chart_type'] ?? 'bar';
    $isHorizontal = $type === 'horizontal_bar';
    $jsType = $isHorizontal ? 'bar' : $type;

    $rows = collect($block['data'] ?? []);
    $labels = $rows->pluck('label')->all();
    $values = $rows->pluck('value')->map(fn ($v) => (float) $v)->all();

    $palette = ['#2563eb', '#16a34a', '#f59e0b', '#dc2626', '#9333ea', '#0891b2', '#db2777', '#65a30d'];
    $multiColor = in_array($type, ['pie', 'doughnut']);

    if ($multiColor) {
        $background = collect($labels)->keys()->map(fn ($i) => $palette[$i % count($palette)])->all();
        $border = '#ffffff';
    } elseif (in_array($type, ['line', 'radar'])) {
        $background = $palette[0] . '33';
        $border = $palette[0];
    } else {
        $background = $palette[0];
        $border = $palette[0];
    }

    $unit = $block['unit'] ?? '';
    $isPieLike = in_array($type, ['pie', 'doughnut']);
    $isRadar = $type === 'radar';

    $config = [
        'type' => $jsType,
        'data' => [
            'labels' => $labels,
            'datasets' => [[
                'label' => $unit ?: ($block['title'] ?? ''),
                'data' => $values,
                'backgroundColor' => $background,
                'borderColor' => $border,
                'borderWidth' => 2,
                'tension' => 0.3,
                'fill' => $type === 'radar',
            ]],
        ],
        'options' => [
            'indexAxis' => $isHorizontal ? 'y' : 'x',
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                    'legend' => ['display' => $multiColor],
                    'datalabels' => [
                        'display' => ! $isRadar,
                        'color' => $isPieLike ? '#ffffff' : '#1e293b',
                        'anchor' => $isPieLike ? 'center' : 'end',
                        'align' => $isPieLike ? 'center' : ($isHorizontal ? 'right' : 'top'),
                        'offset' => 2,
                        'clamp' => true,
                        'font' => ['weight' => 'bold', 'size' => 13],
                    ],
                ],
        ],
    ];
@endphp

<figure class="my-6 not-prose">
    <figcaption class="mb-2 text-lg font-semibold text-slate-900">{{ $block['title'] ?? '' }}</figcaption>

    <div class="relative h-80 w-full">
        <canvas id="{{ $id }}"></canvas>
    </div>

    @if (filled($block['description'] ?? null))
        <p class="mt-3 text-sm text-slate-700">{{ $block['description'] }}</p>
    @endif
    @if (filled($block['source'] ?? null))
        <p class="mt-1 text-xs text-slate-500">Sumber: {{ $block['source'] }}</p>
    @endif
</figure>


@push('scripts')
<script>
(function () {
    const init = () => {
        const canvas = document.getElementById(@json($id));
        if (!canvas || typeof Chart === 'undefined') return;

        const config = @json($config);
        const unit = @json($unit);

        config.options.plugins.tooltip = {
            callbacks: {
                label: (ctx) => `${ctx.label}: ${ctx.formattedValue} ${unit}`,
            },
        };
        config.options.plugins.datalabels.formatter = (value) =>
            Number(value).toLocaleString('id-ID') + (unit ? ' ' + unit : '');

        config.options.layout = { padding: { top: 24, right: 48 } };

        config.plugins = [ChartDataLabels];

        new Chart(canvas, config);
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endpush