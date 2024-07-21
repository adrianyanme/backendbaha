<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Perangkat;
use App\Models\DeviceLog;
use App\Models\Perangkat_logs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RelayController extends Controller
{
    private function checkAccess($user, $serial_number)
    {
        $userId = $user->parent_id ?? $user->id;

        return Perangkat::where('serial_number', $serial_number)
                     ->where('user_id', $userId)
                     ->exists();
    }

    public function openRelay(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|exists:perangkats,serial_number',
        ]);

        $user = Auth::user();
        Log::info('User ID: ' . $user->id);

        $userId = $user->parent_id ?? $user->id;

        $device = Perangkat::where('serial_number', $request->serial_number)
                           ->where('user_id', $userId)
                           ->first();

        if (!$device) {
            Log::error('Device not found for user ID: ' . $userId);
            return response()->json(['message' => 'Device not found'], 404);
        }

        if (!$this->checkAccess($user, $device->serial_number)) {
            Log::error('Access denied for user ID: ' . $userId . ' and device serial number: ' . $device->serial_number);
            return response()->json(['message' => 'Access denied'], 403);
        }

        Cache::put('relay_status_' . $device->serial_number, 'open'); // Simpan instruksi tanpa kadaluarsa

        // Log ke database
        Perangkat_logs::create([
            'user_id' => $user->id,
            'device_id' => $device->id,
            'action' => 'open',
            'username' => $user->username,
            'nama_perangkat' => $device->nama_perangkat,
        ]);

        return response()->json(['message' => 'Relay opened']);
    }

    public function closeRelay(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|exists:perangkats,serial_number',
        ]);

        $user = Auth::user();
        Log::info('User ID: ' . $user->id);

        $userId = $user->parent_id ?? $user->id;

        $device = Perangkat::where('serial_number', $request->serial_number)
                           ->where('user_id', $userId)
                           ->first();

        if (!$device) {
            Log::error('Device not found for user ID: ' . $userId);
            return response()->json(['message' => 'Device not found'], 404);
        }

        if (!$this->checkAccess($user, $device->serial_number)) {
            Log::error('Access denied for user ID: ' . $userId . ' and device serial number: ' . $device->serial_number);
            return response()->json(['message' => 'Access denied'], 403);
        }

        // Set instruksi untuk menutup relay
        Cache::put('relay_status_' . $device->serial_number, 'close'); // Simpan instruksi tanpa kadaluarsa

        // Log ke database
        Perangkat_logs::create([
            'user_id' => $user->id,
            'device_id' => $device->id,
            'action' => 'close',
            'username' => $user->username,
            'nama_perangkat' => $device->nama_perangkat,
        ]);

        return response()->json(['message' => 'Relay closed']);
    }

    public function getRelayStatus($serial_number)
    {
        // Ambil instruksi dari cache
        $status = Cache::get('relay_status_' . $serial_number, 'none');
        return response()->json(['status' => $status]);
    }

    public function addDevice(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|unique:perangkats,serial_number',
            'nama_perangkat' => 'required|string',
        ]);

        $user = Auth::user();

        $device = Perangkat::create([
            'serial_number' => $request->serial_number,
            'user_id' => $user->id,
            'nama_perangkat' => $request->nama_perangkat,
        ]);

        return response()->json(['message' => 'Device added successfully', 'device' => $device], 201);
    }

    public function getDevices()
    {
        $user = Auth::user();
        $userId = $user->parent_id ?? $user->id;

        $devices = Perangkat::where('user_id', $userId)->get();

        return response()->json(['devices' => $devices]);
    }

    public function getAllDeviceLogs(Request $request)
    {
        $user = Auth::user();
        $userId = $user->parent_id ?? $user->id;

        // Ambil semua perangkat yang dimiliki oleh user
        $devices = Perangkat::where('user_id', $userId)->pluck('id');

        // Ambil semua log dari perangkat yang dimiliki oleh user
        $logs = Perangkat_logs::whereIn('device_id', $devices)->get();

        return response()->json(['logs' => $logs]);
    }
}
///