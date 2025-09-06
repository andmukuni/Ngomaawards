<?php

namespace App\Exports;

use App\Models\Nomination;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NominationsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected int $row = 0;
    protected ?string $q;

    public function __construct(?string $q = null)
    {
        $this->q = $q ? trim($q) : null;
    }

    public function query()
    {
        return Nomination::query()
            ->when($this->q, function ($query) {
                $q = "%{$this->q}%";
                $query->where(function ($sub) use ($q) {
                    $sub->where('category', 'like', $q)
                        ->orWhere('nominee_name', 'like', $q);
                });
            })
        ->select('nominations.*')
        ->selectRaw('soundex(nominee_name) as nominee_sx')
        ->selectRaw('(SELECT COUNT(*) FROM nominations n2 WHERE n2.nominee_sx = soundex(nominations.nominee_name)) as similar_count')
        ->latest();
    }

    public function headings(): array
    {
        return ['#', 'Category', 'Nominee Name', 'Phonetic Key', 'Cluster Size', 'Created'];
    }

    public function map($nomination): array
    {
        $this->row++;
        return [
            $this->row,
            $nomination->category,
            $nomination->nominee_name,
            $nomination->nominee_sx ?? null,
            (int)($nomination->similar_count ?? 1),
            optional($nomination->created_at)->format('Y-m-d'),
        ];
    }

}
