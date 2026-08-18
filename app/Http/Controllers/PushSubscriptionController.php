<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|string',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        /** @var \App\Models\Student $student */
        $student = auth('student')->user();

        $student->updatePushSubscription(
            $request->endpoint,
            $request->input('keys.p256dh'),
            $request->input('keys.auth')
        );

        return response()->json(['message' => 'Subscribed']);
    }
    public function destroy(Request $request)
    {
        $student = auth('student')->user();
        $student->pushSubscriptions()->where('endpoint', $request->endpoint)->delete();

        return response()->json(['message' => 'Unsubscribed']);
    }
}
