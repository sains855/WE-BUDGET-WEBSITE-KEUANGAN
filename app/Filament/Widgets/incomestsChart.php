<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Builder;

class incomestsChart extends ChartWidget
{
    use InteractsWithPageFilters;


    protected static ?string $heading = 'Pemasukan';
    protected static string $color = 'success';

    protected function getData(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
        Carbon::parse($this->filters['startDate']) :
        now()->startOfMonth();

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
        Carbon::parse($this->filters['endDate']) :
        now();

        $data = Trend::query(Transaksi::query()
            ->where('user_id', auth()->id())
            ->outcome())
        ->between(
            start: $startDate,
            end: $endDate,
        )
                ->perDay()
                ->sum('Jumlah');

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan Per Hari',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
