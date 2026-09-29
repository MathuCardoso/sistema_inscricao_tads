<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InscricaoController extends Controller {
    public function create() {
        $activities = Activity::all();
        $registrations = Registration::all();


        return Inertia::render('Inscricao', [
            'activities' => $activities,
            'registrations' => $registrations,
        ]);
    }

    public function store(Request $request) {

        $validatedFields = $request->validate(
            [
                'name' => 'required|max:150',
                'email' => 'required|email|unique:participants,email',
                'cpf' => 'required|max:14|unique:participants,cpf',
                'phone' => 'max:15',
                'activity_ids' => 'required'
            ],
        );

        DB::transaction(function () use ($validatedFields) {

            $participant = Participant::create([
                'name' => $validatedFields['name'],
                'email' => $validatedFields['email'],
                'cpf' => $validatedFields['cpf'],
                'phone' => $validatedFields['phone'] ?? null,
            ]);

            $participant->activities()->attach($validatedFields['activity_ids']);
        });

        return \redirect()->back()
            ->with('success', "Inscrição realizada com sucesso! Aproveite o evento, " . $validatedFields['name'] . ".");
    }
}
