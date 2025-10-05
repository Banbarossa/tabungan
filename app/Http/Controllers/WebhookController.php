<?php

namespace App\Http\Controllers;

use App\Models\DeviceStatusLog;
use App\Models\Message;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleDeviceStatus(Request $request)
    {
        // Validasi data yang diterima
        $data = $request->validate([
            'device' => 'required|string',
            'status' => 'nullable',
            'timestamp' => 'nullable',
            'reason' => 'nullable|string',
        ]);

        $device = $data['device'];
        $status = $data['status'];
        $timestamp = $data['timestamp'];
        $reason = $data['reason'] ?? null;

        DeviceStatusLog::create([
            'device' => $device,
            'status' => $status,
            'timestamp' => $timestamp,
            'reason' => $reason,
        ]);

        return response()->json(['message' => 'Device status processed successfully.']);
    }

    public function handleMessageStatus(Request $request)
    {
        $data = $request->validate([
            'device' => 'required|string',
            'id' => 'nullable|integer',
            'stateid' => 'nullable|string',
            'status' => 'nullable|string',
            'state' => 'nullable|string',
        ]);

        $device = $data['device'];
        $id = $data['id'] ?? null;
        $stateid = $data['stateid'] ?? null;
        $status = $data['status'] ?? null;
        $state = $data['state'] ?? null;

        if ($id && $stateid) {
            Message::where('message_id', $id)->update([
                'status' => $status,
                'state' => $state,
                'stateid' => $stateid,
            ]);
        } elseif ($id && !$stateid) {
            Message::where('message_id', $id)->update([
                'status' => $status,
            ]);
        } elseif ($stateid) {
            Message::where('stateid', $stateid)->update([
                'status' => $status,
            ]);
        }

        return response()->json(['message' => 'Message status updated successfully.'], 200);
    }
}
