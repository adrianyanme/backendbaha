<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountManagementController extends Controller
{
    public function addChildAccount(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required|min:6',
        ]);

        $parent = Auth::user();

        $child = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'password' => Hash::make($request->password),
            'parent_id' => $parent->id, // Isi parent_id secara otomatis
            'role' => 'child', // Set role sebagai child
        ]);

        return response()->json(['message' => 'Child account created successfully', 'child' => $child]);
    }

    public function getChildAccounts()
    {
        $parent = Auth::user();
        $children = $parent->children;

        return response()->json(['children' => $children]);
    }

    public function controlDoorFromArduino(Request $request)
    {
        $request->validate([
            'action' => 'required|in:open,close',
            'api_key' => 'required', // Tambahkan validasi API key untuk keamanan
        ]);

        // Validasi API key
        if ($request->api_key !== env('ARDUINO_API_KEY')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Lakukan aksi membuka atau menutup pintu
        $action = $request->action;
        if ($action == 'open') {
            // Logika untuk membuka pintu
            // Contoh: Kirim sinyal ke relay atau motor pintu
        } elseif ($action == 'close') {
            // Logika untuk menutup pintu
            // Contoh: Kirim sinyal ke relay atau motor pintu
        }

        return response()->json(['message' => 'Door ' . $action . 'ed successfully']);
    }
}