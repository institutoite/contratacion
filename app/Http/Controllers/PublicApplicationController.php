<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\InterviewSlot;
use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PublicApplicationController extends Controller
{
    public function index(): View
    {
        $slots = collect();
        $positions = collect();

        try {
            $slots = InterviewSlot::query()
                ->available()
                ->orderBy('interview_date')
                ->orderBy('interview_time')
                ->get();

            $positions = Position::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        } catch (QueryException) {
            // Allows welcome page rendering even before migrations are executed.
        }

        return view('welcome', [
            'slots' => $slots,
            'positions' => $positions,
        ]);
    }

    public function store(): RedirectResponse
    {
        $validated = request()->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:hombre,mujer'],
            'position_id' => ['required', 'integer', 'exists:positions,id'],
            'address' => ['required', 'string'],
            'primary_phone' => ['required', 'string', 'max:100'],
            'reference_phone' => ['required', 'string', 'max:100'],
            'motivation_text' => ['required', 'string', 'max:2000'],
            'interview_slot_id' => ['required', 'integer', 'exists:interview_slots,id'],
        ]);

        DB::transaction(function () use ($validated): void {
            $position = Position::query()
                ->whereKey($validated['position_id'])
                ->where('is_active', true)
                ->first();

            if (!$position) {
                throw ValidationException::withMessages([
                    'position_id' => 'El cargo seleccionado ya no esta disponible.',
                ]);
            }

            $slot = InterviewSlot::query()
                ->lockForUpdate()
                ->findOrFail($validated['interview_slot_id']);

            if (!$slot->is_active || $slot->interview_date->lt(today())) {
                throw ValidationException::withMessages([
                    'interview_slot_id' => 'La fecha y hora seleccionada ya no esta disponible. Elige otra opcion.',
                ]);
            }

            $applicant = Applicant::query()->create([
                'full_name' => $validated['full_name'],
                'gender' => $validated['gender'],
                'position_id' => $validated['position_id'],
                'address' => $validated['address'],
                'primary_phone' => $validated['primary_phone'],
                'reference_phone' => $validated['reference_phone'],
                'motivation_text' => $validated['motivation_text'],
                'application_date' => now()->toDateString(),
                'status' => 'Pendiente de entrevista',
            ]);

            $applicant->interviews()->create([
                'interview_date' => $slot->interview_date->format('Y-m-d'),
                'interview_time' => $slot->interview_time,
                'result' => 'Programada desde landing publica',
            ]);

            $applicant->update([
                'last_interview_at' => $slot->interview_date->format('Y-m-d') . ' ' . $slot->interview_time,
            ]);

            $applicant->histories()->create([
                'action' => 'Registro publico',
                'performed_by' => 'Landing publica',
                'note' => 'Registro creado desde landing en welcome',
                'changes' => [
                    'slot' => [
                        'date' => $slot->interview_date->format('Y-m-d'),
                        'time' => $slot->interview_time,
                    ],
                    'position_id' => $validated['position_id'],
                ],
            ]);

        });

        return redirect()
            ->route('welcome')
            ->with('success', 'Tu registro fue enviado. Te esperamos en la fecha y hora seleccionada.');
    }
}
