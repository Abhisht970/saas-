<?php

namespace App\Http\Controllers;

use App\Models\UserActivityLog;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    public function idle(Request $request)
    {
        $user = $request->user();
        $sessionToken = $request->session()->get('activity_session_token');
        if (!$sessionToken) {
            $sessionToken = (string) \Illuminate\Support\Str::uuid();
            $request->session()->put('activity_session_token', $sessionToken);
        }
        $activity = UserActivityLog::firstOrCreate(['user_id' => $user->id, 'session_token' => $sessionToken,], ['session_started_at' => now(), 'last_activity_at' => now(), 'idle_started_at' => now(),]);
        if (!$activity->idle_started_at) {
            $activity->idle_started_at = now();
            $activity->save();
        }
        return response()->json(['success' => true, 'message' => 'Idle event saved', 'id' => $activity->id,]);
    }

    public function active(Request $request)
    {
        $user = $request->user();

        $sessionToken = $request->session()->get('activity_session_token');

        if (!$sessionToken) {
            return response()->json([
                'success' => false,
                'message' => 'Session token not found',
            ], 404);
        }

        $activity = UserActivityLog::where('user_id', $user->id)
            ->where('session_token', $sessionToken)
            ->first();

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Activity record not found',
            ], 404);
        }

        if ($activity->idle_started_at) {
            $idleSeconds = max(
                0,
                (int) now()->timestamp - (int) $activity->idle_started_at->timestamp
            );

            $activity->idle_duration_seconds += $idleSeconds;
            $activity->idle_started_at = null;
        }

        $activity->last_activity_at = now();
        $activity->save();

        return response()->json([
            'success' => true,
            'message' => 'User active again',
            'idle_duration_seconds' => $activity->idle_duration_seconds,
        ]);
    }

}
