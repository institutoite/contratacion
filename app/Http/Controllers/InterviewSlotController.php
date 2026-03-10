<?php

namespace App\Http\Controllers;

use App\Models\InterviewSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InterviewSlotController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'interview_date' => ['required', 'date', 'after_or_equal:today'],
            'interview_time' => ['required', 'date_format:H:i'],
        ]);

        $exists = InterviewSlot::query()
            ->whereDate('interview_date', $validated['interview_date'])
            ->where('interview_time', $validated['interview_time'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'interview_time' => 'Ese horario ya fue registrado.',
            ]);
        }

        InterviewSlot::query()->create($validated + ['is_active' => true]);

        return back()->with('success', 'Horario de entrevista registrado.');
    }

    public function toggle(InterviewSlot $interviewSlot): RedirectResponse
    {
        $interviewSlot->update([
            'is_active' => !$interviewSlot->is_active,
        ]);

        return back()->with('success', 'Estado del horario actualizado.');
    }

    public function destroy(InterviewSlot $interviewSlot): RedirectResponse
    {
        $interviewSlot->delete();

        return back()->with('success', 'Horario eliminado.');
    }
}
