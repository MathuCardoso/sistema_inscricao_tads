<?php

namespace App\Http\Controllers;

use App\Models\Registration;

class RegistrationController extends Controller {
    public function togglePresence(Registration $registration) {
        $registration->update([
            'presence' => !$registration->presence
        ]);

        return \back()->with('success', 'Presença alterada com sucesso.');
    }
}
