<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin-users.index', compact('admins'));
    }

    public function create()
    {
        return view('admin-users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'User',
            'model_id' => $admin->id,
            'description' => 'Superadmin ' . auth()->user()->name . ' menambah admin ' . $admin->name,
        ]);

        return redirect()->route('admin-users.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit(User $admin)
    {
        if ($admin->role !== 'admin') {
            return redirect()->route('admin-users.index')->with('error', 'Hanya admin yang bisa diedit.');
        }
        return view('admin-users.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        if ($admin->role !== 'admin') {
            return redirect()->route('admin-users.index')->with('error', 'Hanya admin yang bisa diedit.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8',
        ]);

        $oldValues = $admin->getAttributes();
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        if ($validated['password']) {
            $admin->password = Hash::make($validated['password']);
        }
        $admin->save();

        $newValues = $admin->getAttributes();
        $changes = array_diff_assoc($newValues, $oldValues);

        if ($changes) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model_type' => 'User',
                'model_id' => $admin->id,
                'old_values' => array_intersect_key($oldValues, $changes),
                'new_values' => array_intersect_key($newValues, $changes),
                'description' => 'Superadmin ' . auth()->user()->name . ' mengupdate admin ' . $admin->name,
            ]);
        }

        return redirect()->route('admin-users.index')->with('success', 'Admin berhasil diupdate.');
    }

    public function destroy($id)
    {
        $admin = User::find($id);
        Log::info('Destroy attempt', [
            'current_user' => auth()->user()->toArray(),
            'target_admin_id' => $id,
            'target_admin' => $admin ? $admin->toArray() : 'Not found',
        ]);

        if (!$admin) {
            Log::warning('Destroy failed', ['reason' => 'Admin not found']);
            return redirect()->route('admin-users.index')->with('error', 'Admin tidak ditemukan.');
        }

        if (auth()->user()->role !== 'developer' || $admin->role !== 'admin') {
            Log::warning('Destroy blocked', ['reason' => 'Unauthorized or wrong role']);
            return redirect()->route('admin-users.index')->with('error', 'Hanya superadmin yang bisa menghapus admin.');
        }

        try {
            $adminName = $admin->name;
            $admin->delete();
            Log::info('Admin deleted', ['admin_id' => $admin->id, 'admin_name' => $adminName]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'model_type' => 'User',
                'model_id' => $admin->id,
                'description' => 'Superadmin ' . auth()->user()->name . ' menghapus admin ' . $adminName,
            ]);

            return redirect()->route('admin-users.index')->with('success', 'Admin berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Delete failed', ['error' => $e->getMessage()]);
            return redirect()->route('admin-users.index')->with('error', 'Gagal menghapus admin: ' . $e->getMessage());
        }
    }
}
