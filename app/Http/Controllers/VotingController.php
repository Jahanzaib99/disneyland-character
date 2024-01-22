<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function showVoteScreen()
    {
        $characters = Character::paginate(10); // Retrieve characters from the database
        return view('voting', ['characters' => $characters]);
    }

    public function registerVote(Request $request)
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // Register the vote for authenticated user
            Vote::create([
                'character_id' => $request->input('character'),
                'user_id' => auth()->id(),
            ]);

            // Redirect to thank you screen for authenticated users
            return redirect('/thank-you');
        } else {
            // Register the vote for guest user (without user_id)
            Vote::create([
                'character_id' => $request->input('character'),
            ]);

            // Redirect to thank you screen for guest users
            return redirect('/thank-you');
        }
        return redirect()->back()->withSuccess('Thank you for casting your vote!');
    }

    public function showThankYouScreen()
    {
        // Show thank you screen
        return view('thank_you');
    }

    public function adminDashboard(Request $request)
    {
        try {
            // Retrieve filter values from the request
            $period = $request->input('period');
            $characterId = $request->input('character');
            // Retrieve data for the admin dashboard with filters
            $votesOverTime = $this->getVotesOverTime($period);
            $votesPerCharacter = $this->getVotesPerCharacter($period, $characterId);
            $topCharacters = $this->getTopCharacters($period);
            $characterPopularityByTime = $this->getCharacterPopularityByTime($period);

            return response()->json([
                'votesOverTime' => $votesOverTime,
                'votesPerCharacter' => $votesPerCharacter,
                'topCharacters' => $topCharacters,
                'characterPopularityByTime' => $characterPopularityByTime
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    private function getVotesOverTime($period = null)
    {
        $query = Vote::selectRaw('DATE(created_at) as date, COUNT(*) as count');

        if ($period) {
            // Convert $period to timestamps
            $periodStart = Carbon::parse($period)->startOfDay();
            $periodEnd = Carbon::parse($period)->endOfDay();

            $query->whereBetween('created_at', [$periodStart, $periodEnd]);
        }

        return $query->groupBy('date')->get();
    }

    private function getVotesPerCharacter($period = null, $characterId = null)
    {
        $query = Character::withCount('votes')->orderByDesc('votes_count');

        if ($period) {

            $query->whereHas('votes', function ($subQuery) use ($period) {
                // Convert $period to timestamps
                $periodStart = Carbon::parse($period)->startOfDay();
                $periodEnd = Carbon::parse($period)->endOfDay();

                $subQuery->whereBetween('created_at', [$periodStart, $periodEnd]);
            });
        }

        if ($characterId) {
            $query->where('id', $characterId);
        }

        return $query->get();
    }

    private function getTopCharacters($period = null)
    {
        $query = Character::withCount('votes')->orderByDesc('votes_count')->take(5);

        if ($period) {
            $query->whereHas('votes', function ($subQuery) use ($period) {
                // Convert $period to timestamps
                $periodStart = Carbon::parse($period)->startOfDay();
                $periodEnd = Carbon::parse($period)->endOfDay();

                $subQuery->whereBetween('created_at', [$periodStart, $periodEnd]);
            });
        }

        return $query->get();
    }

    private function getCharacterPopularityByTime($period = null)
    {
        $query = Vote::selectRaw('HOUR(created_at) as hour, character_id, COUNT(*) as count');

        if ($period) {
            // Convert $period to timestamps
            $periodStart = Carbon::parse($period)->startOfDay();
            $periodEnd = Carbon::parse($period)->endOfDay();

            $query->whereBetween('created_at', [$periodStart, $periodEnd]);
        }

        return $query->groupBy('hour', 'character_id')->orderBy('hour')->get();
    }
}
