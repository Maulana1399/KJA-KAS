<?php

namespace App\Filament\Widgets;

use illuminate\support\carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\transaction;

class WTIncomesChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Pemasukan';
    protected static string $color = 'success';

    protected function getData(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
                Carbon::parse($this->filters['startDate']) :
                null;
    
            $endDate = ! is_null($this->filters['endDate'] ?? null) ?
                Carbon::parse($this->filters['endDate']) :
                now();
                
            $data = Trend::query(transaction::Incomes())    
                ->dateColumn('date_transactions')
                ->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear(),
                )
                ->perDay()
                ->sum('amount');
        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan Dalam Satu Hari',
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
