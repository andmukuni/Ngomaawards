<?php

namespace App\Http\Controllers;

use App\Models\Nomination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NominationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   /**
 * Display a listing of the resource.
 */
public function index(Request $request)
{
    if ($request->ajax()) {
        return $this->getNominationsData($request);
    }

    $categories = [
        'Best TV Series of the Year',
        'Best Actress of the Year (TV & Film)',
        'Best Actor of the Year (TV & Film)',
        'Best Song of the Year',
        'Best Song Collaboration of the Year',
        'Best Online/Social Media Comedian',
        'Best Male Model of the Year',
        'Best Female Model of the Year',
        'Best Regional Artist Male',
        'Best Regional Artist Female',
        'Overall Best Artist',
    ];

    return view('nominations.index', compact('categories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'Best TV Series of the Year',
            'Best Actress of the Year (TV & Film)',
            'Best Actor of the Year (TV & Film)',
            'Best Song of the Year',
            'Best Song Collaboration of the Year',
            'Best Online/Social Media Comedian',
            'Best Male Model of the Year',
            'Best Female Model of the Year',
            'Best Regional Artist Male',
            'Best Regional Artist Female',
            'Overall Best Artist',
        ];
        
        return view('nominations.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define validation rules based on category
        $rules = [
            'category' => 'required|string|max:255',
        ];
        
        // Add specific validation rules based on category
        switch($request->category) {
            case 'Best TV Series of the Year':
                $rules['series_name'] = 'required|string|max:255';
                $rules['network'] = 'required|string|max:255';
                $rules['year'] = 'required|integer|min:1900|max:' . (date('Y') + 1);
                break;
                
            case 'Best Actress of the Year (TV & Film)':
                $rules['actress_name'] = 'required|string|max:255';
                $rules['movie'] = 'required|string|max:255';
                $rules['role'] = 'required|string|max:255';
                break;
                
            case 'Best Actor of the Year (TV & Film)':
                $rules['actor_name'] = 'required|string|max:255';
                $rules['movie'] = 'required|string|max:255';
                $rules['role'] = 'required|string|max:255';
                break;
                
            case 'Best Song of the Year':
                $rules['song_title'] = 'required|string|max:255';
                $rules['artist'] = 'required|string|max:255';
                $rules['release_year'] = 'required|integer|min:1900|max:' . (date('Y') + 1);
                break;
                
            case 'Best Song Collaboration of the Year':
                $rules['song_title'] = 'required|string|max:255';
                $rules['main_artist'] = 'required|string|max:255';
                $rules['featured_artists'] = 'required|string|max:255';
                break;
                
            case 'Best Online/Social Media Comedian':
                $rules['stage_name'] = 'required|string|max:255';
                $rules['platform'] = 'required|string|in:Facebook,Instagram,TikTok,YouTube,X (Twitter)';
                $rules['profile_url'] = 'nullable|url|max:255';
                break;
                
            case 'Best Male Model of the Year':
            case 'Best Female Model of the Year':
                $rules['model_name'] = 'required|string|max:255';
                $rules['agency'] = 'nullable|string|max:255';
                $rules['portfolio_url'] = 'nullable|url|max:255';
                break;
                
            case 'Best Regional Artist Male':
            case 'Best Regional Artist Female':
                $rules['stage_name'] = 'required|string|max:255';
                $rules['region'] = 'required|string|max:255';
                $rules['popular_song'] = 'nullable|string|max:255';
                break;
                
            case 'Overall Best Artist':
                $rules['stage_name'] = 'required|string|max:255';
                $rules['domain'] = 'required|string|in:Music,Dance,Comedy,Theatre,Film & Media,Fashion,Visual Arts';
                $rules['signature_work'] = 'nullable|string|max:255';
                break;
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $nominationData = $request->all();
            
            // Add user ID if authenticated
            if (Auth::check()) {
                $nominationData['user_id'] = Auth::id();
            }
            
            $nomination = Nomination::create($nominationData);
            
            return response()->json([
                'success' => true,
                'message' => 'Nomination submitted successfully!',
                'data' => $nomination
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error submitting nomination: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Nomination $nomination)
    {
        $nomination->load('user');
        return view('nominations.show', compact('nomination'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nomination $nomination)
    {
        $categories = [
            'Best TV Series of the Year',
            'Best Actress of the Year (TV & Film)',
            'Best Actor of the Year (TV & Film)',
            'Best Song of the Year',
            'Best Song Collaboration of the Year',
            'Best Online/Social Media Comedian',
            'Best Male Model of the Year',
            'Best Female Model of the Year',
            'Best Regional Artist Male',
            'Best Regional Artist Female',
            'Overall Best Artist',
        ];
        
        return view('nominations.edit', compact('nomination', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nomination $nomination)
    {
        // Define validation rules based on category
        $rules = [
            'category' => 'required|string|max:255',
        ];
        
        // Add specific validation rules based on category
        switch($request->category) {
            case 'Best TV Series of the Year':
                $rules['series_name'] = 'required|string|max:255';
                $rules['network'] = 'required|string|max:255';
                $rules['year'] = 'required|integer|min:1900|max:' . (date('Y') + 1);
                break;
                
            case 'Best Actress of the Year (TV & Film)':
                $rules['actress_name'] = 'required|string|max:255';
                $rules['movie'] = 'required|string|max:255';
                $rules['role'] = 'required|string|max:255';
                break;
                
            case 'Best Actor of the Year (TV & Film)':
                $rules['actor_name'] = 'required|string|max:255';
                $rules['movie'] = 'required|string|max:255';
                $rules['role'] = 'required|string|max:255';
                break;
                
            case 'Best Song of the Year':
                $rules['song_title'] = 'required|string|max:255';
                $rules['artist'] = 'required|string|max:255';
                $rules['release_year'] = 'required|integer|min:1900|max:' . (date('Y') + 1);
                break;
                
            case 'Best Song Collaboration of the Year':
                $rules['song_title'] = 'required|string|max:255';
                $rules['main_artist'] = 'required|string|max:255';
                $rules['featured_artists'] = 'required|string|max:255';
                break;
                
            case 'Best Online/Social Media Comedian':
                $rules['stage_name'] = 'required|string|max:255';
                $rules['platform'] = 'required|string|in:Facebook,Instagram,TikTok,YouTube,X (Twitter)';
                $rules['profile_url'] = 'nullable|url|max:255';
                break;
                
            case 'Best Male Model of the Year':
            case 'Best Female Model of the Year':
                $rules['model_name'] = 'required|string|max:255';
                $rules['agency'] = 'nullable|string|max:255';
                $rules['portfolio_url'] = 'nullable|url|max:255';
                break;
                
            case 'Best Regional Artist Male':
            case 'Best Regional Artist Female':
                $rules['stage_name'] = 'required|string|max:255';
                $rules['region'] = 'required|string|max:255';
                $rules['popular_song'] = 'nullable|string|max:255';
                break;
                
            case 'Overall Best Artist':
                $rules['stage_name'] = 'required|string|max:255';
                $rules['domain'] = 'required|string|in:Music,Dance,Comedy,Theatre,Film & Media,Fashion,Visual Arts';
                $rules['signature_work'] = 'nullable|string|max:255';
                break;
        }
        
        $validated = $request->validate($rules);
        
        $nomination->update($validated);
        
        return redirect()->route('nominations.index')
            ->with('success', 'Nomination updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nomination $nomination)
    {
        $nomination->delete();
        
        return redirect()->route('nominations.index')
            ->with('success', 'Nomination deleted successfully.');
    }
    
    /**
     * Update nomination status (for admin)
     */
    public function updateStatus(Request $request, Nomination $nomination)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);
        
        $nomination->update(['status' => $request->status]);
        
        return back()->with('success', 'Nomination status updated successfully.');
    }
    
    /**
     * Get nominations by category
     */
    public function byCategory($category)
    {
        $nominations = Nomination::where('category', $category)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('nominations.by-category', compact('nominations', 'category'));
    }

    /**
     * Export nominations
     */
    public function export()
    {
        $nominations = Nomination::with('user')->get();
        
        $filename = 'nominations-export-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($nominations) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID', 'Category', 'Nominee Name', 'Details', 'User', 'Status', 'Submitted At'
            ]);
            
            foreach ($nominations as $nomination) {
                $nomineeName = $this->getNomineeName($nomination);
                $details = $this->getNominationDetails($nomination);
                
                fputcsv($file, [
                    $nomination->id,
                    $nomination->category,
                    $nomineeName,
                    $details,
                    $nomination->user ? $nomination->user->name : 'Anonymous',
                    $nomination->status,
                    $nomination->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Get cluster/view of nominations
     */
    public function cluster()
    {
        $nominationsByCategory = Nomination::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();
            
        $recentNominations = Nomination::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $statusCounts = Nomination::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
            
        return view('nominations.cluster', compact('nominationsByCategory', 'recentNominations', 'statusCounts'));
    }
    
    /**
     * Helper method to get nominee name from nomination
     */
    private function getNomineeName($nomination)
    {
        switch($nomination->category) {
            case 'Best TV Series of the Year':
                return $nomination->series_name;
            case 'Best Actress of the Year (TV & Film)':
                return $nomination->actress_name;
            case 'Best Actor of the Year (TV & Film)':
                return $nomination->actor_name;
            case 'Best Song of the Year':
            case 'Best Song Collaboration of the Year':
                return $nomination->song_title . ' by ' . $nomination->artist;
            case 'Best Online/Social Media Comedian':
                return $nomination->stage_name;
            case 'Best Male Model of the Year':
            case 'Best Female Model of the Year':
                return $nomination->model_name;
            case 'Best Regional Artist Male':
            case 'Best Regional Artist Female':
            case 'Overall Best Artist':
                return $nomination->stage_name;
            default:
                return 'Unknown';
        }
    }
    
    /**
     * Helper method to get nomination details
     */
    private function getNominationDetails($nomination)
    {
        $details = [];
        
        switch($nomination->category) {
            case 'Best TV Series of the Year':
                $details[] = 'Network: ' . $nomination->network;
                $details[] = 'Year: ' . $nomination->year;
                break;
            case 'Best Actress of the Year (TV & Film)':
            case 'Best Actor of the Year (TV & Film)':
                $details[] = 'Movie: ' . $nomination->movie;
                $details[] = 'Role: ' . $nomination->role;
                break;
            case 'Best Song of the Year':
                $details[] = 'Artist: ' . $nomination->artist;
                $details[] = 'Year: ' . $nomination->release_year;
                break;
            case 'Best Song Collaboration of the Year':
                $details[] = 'Main Artist: ' . $nomination->main_artist;
                $details[] = 'Featured: ' . $nomination->featured_artists;
                break;
            case 'Best Online/Social Media Comedian':
                $details[] = 'Platform: ' . $nomination->platform;
                if ($nomination->profile_url) {
                    $details[] = 'Profile: ' . $nomination->profile_url;
                }
                break;
            case 'Best Male Model of the Year':
            case 'Best Female Model of the Year':
                if ($nomination->agency) {
                    $details[] = 'Agency: ' . $nomination->agency;
                }
                if ($nomination->portfolio_url) {
                    $details[] = 'Portfolio: ' . $nomination->portfolio_url;
                }
                break;
            case 'Best Regional Artist Male':
            case 'Best Regional Artist Female':
                $details[] = 'Region: ' . $nomination->region;
                if ($nomination->popular_song) {
                    $details[] = 'Popular Song: ' . $nomination->popular_song;
                }
                break;
            case 'Overall Best Artist':
                $details[] = 'Domain: ' . $nomination->domain;
                if ($nomination->signature_work) {
                    $details[] = 'Signature Work: ' . $nomination->signature_work;
                }
                break;
        }
        
        return implode(', ', $details);
    }

        /**
     * Get nominations for DataTables
     */
    public function getNominationsData(Request $request)
    {
        $query = Nomination::with('user')->select('nominations.*');

        // Apply filters
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return DataTables::of($query)
            ->addColumn('nominee_name', function($nomination) {
                return $this->getNomineeName($nomination);
            })
            ->addColumn('details', function($nomination) {
                return $this->getNominationDetails($nomination);
            })
            ->addColumn('actions', function($nomination) {
                return view('nominations.partials.actions', compact('nomination'))->render();
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }


}