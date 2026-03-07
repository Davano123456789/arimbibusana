<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Get all users who are not admins (assuming role-based or just all registered users)
        // If there's no role column, we just show all users.
        $users = User::latest()->get();
        return view('dashboard.users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting current user
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
