<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DataType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('dataTypes')->latest()->paginate(10);
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $dataTypes = DataType::all();
        return view('superadmin.users.create', compact('dataTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'nullable|string|max:50|unique:users,nip',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:superadmin,admin_data',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        if ($request->has('assigned_data_types') && $user->role === 'admin_data') {
            $user->dataTypes()->sync($request->assigned_data_types);
        }

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Pengguna berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $dataTypes = DataType::all();
        $assignedDataTypes = $user->dataTypes->pluck('id')->toArray();
        return view('superadmin.users.edit', compact('user', 'dataTypes', 'assignedDataTypes'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:50|unique:users,nip,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:superadmin,admin_data',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        if ($user->role === 'admin_data') {
            $user->dataTypes()->sync($request->assigned_data_types ?? []);
        } else {
            $user->dataTypes()->sync([]);
        }

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('superadmin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('superadmin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}