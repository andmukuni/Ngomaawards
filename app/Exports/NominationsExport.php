<?php

namespace App\Exports;

use App\Models\Nomination;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NominationsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected ?string $q;

    /** Text filter across columns (for ?q=...) */
    protected array $searchable = [
        'category',
        'series_name',
        'network',
        'year',
        'actress_name',
        'actor_name',
        'movie',
        'role',
        'song_title',
        'artist',
        'release_year',
        'main_artist',
        'featured_artists',
        'stage_name',
        'platform',
        'profile_url',
        'model_name',
        'agency',
        'portfolio_url',
        'region',
        'popular_song',
        'domain',
        'signature_work',
        'user_id',
        'status',
    ];

    public function __construct(?string $q = null)
    {
        $this->q = $q ? trim($q) : null;
    }

    public function query(): Builder
    {
        // Select only what we'll export (+ id for ordering)
        $cols = array_merge(['id'], $this->searchable);

        return Nomination::query()
            ->select($cols)
            ->when($this->q, function (Builder $query) {
                $like = '%' . $this->q . '%';
                $query->where(function (Builder $sub) use ($like) {
                    foreach ($this->searchable as $col) {
                        $sub->orWhere($col, 'like', $like);
                    }
                });
            })
            ->orderByDesc('id');
    }

    public function headings(): array
    {
        return [
            'Category',
            'Series Name',
            'Network',
            'Year',
            'Actress Name',
            'Actor Name',
            'Movie',
            'Role',
            'Song Title',
            'Artist',
            'Release Year',
            'Main Artist',
            'Featured Artists',
            'Stage Name',
            'Platform',
            'Profile URL',
            'Model Name',
            'Agency',
            'Portfolio URL',
            'Region',
            'Popular Song',
            'Domain',
            'Signature Work',
            'User ID',
            'Status',
        ];
    }

    public function map($n): array
    {
        return [
            $n->category,
            $n->series_name,
            $n->network,
            $n->year,
            $n->actress_name,
            $n->actor_name,
            $n->movie,
            $n->role,
            $n->song_title,
            $n->artist,
            $n->release_year,
            $n->main_artist,
            $n->featured_artists,
            $n->stage_name,
            $n->platform,
            $n->profile_url,
            $n->model_name,
            $n->agency,
            $n->portfolio_url,
            $n->region,
            $n->popular_song,
            $n->domain,
            $n->signature_work,
            $n->user_id,
            $n->status,
        ];
    }
}
