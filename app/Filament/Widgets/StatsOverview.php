<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Transaksi;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            now()->startOfMonth();

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();

        $Pemasukan = Transaksi::income()
            ->where('user_id', auth()->id()) // Filter berdasarkan user_id
            ->whereBetween('waktu', [$startDate, $endDate])
            ->sum('Jumlah');
        $Pengeluaran = Transaksi::outcome()
            ->where('user_id', auth()->id()) // Filter berdasarkan user_id
            ->whereBetween('waktu', [$startDate, $endDate])
            ->sum('Jumlah');
        return [
            Stat::make('Total Pemasukan:', 'RP.'.' ' .$Pemasukan),
            Stat::make('Total Pengeluaran:', 'RP.'.' ' .$Pengeluaran),
            Stat::make('Selisih:', 'RP.'.' ' .$Pemasukan-$Pengeluaran),
        ];
    }

}
