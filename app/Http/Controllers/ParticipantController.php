<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ParticipantController extends Controller {
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
            ->with('success', 'Participante cadastrado com sucesso!');
    }

    public function update(Request $request, Participant $participant) {

        // \dd($request);
        $validatedFields = $request->validate([
            'name' => 'required|max:150',
            'email' => [
                'required',
                'email',
                Rule::unique('participants', 'email')
                    ->ignore($participant->id, 'id'),
            ],
            'cpf' => [
                'required',
                'max:14',
                Rule::unique('participants', 'cpf')
                    ->ignore($participant->id, 'id'),
            ],
            'phone' => 'max:15',
            'activity_ids' => 'required|array|min:1',
            'activity_ids.*' => 'exists:activities,id',
        ]);

        DB::transaction(function () use ($validatedFields, $participant) {
            $participant->update([
                'name' => $validatedFields['name'],
                'email' => $validatedFields['email'],
                'cpf' => $validatedFields['cpf'],
                'phone' => $validatedFields['phone'] ?? null,
            ]);

            $participant->activities()->sync(
                $validatedFields['activity_ids']
            );
        });

        return redirect()
            ->back()
            ->with('success', 'Participante atualizado com sucesso!');
    }
}
