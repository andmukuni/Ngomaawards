<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;


class Nomination extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        // Add this method to handle DataTables integration
    public static function dataTable($query)
    {
        return datatables($query);
    }

}