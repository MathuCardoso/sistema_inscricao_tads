<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller {
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) {
        $participants = Participant::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('cpf', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        $activities = Activity::all();
        $registrations = Registration::all();

        return Inertia::render('Dashboard', [
            'participants' => $participants,
            'activities' => $activities,
            'registrations' => $registrations,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }
}
