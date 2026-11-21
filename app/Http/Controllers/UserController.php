<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.form', ['user' => new User(['role' => 'staf', 'is_active' => true])]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'Akun pengguna baru berhasil dibuat.');
    }

    public function edit(User $user): View
    {
        return view('users.form', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Data akun pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'Anda tidak dapat menghapus akun yang sedang login.']);
        }

        if ($user->storages()->exists() || $user->logs()->exists()) {
            return back()->withErrors(['user' => 'Akun tidak dapat dihapus karena memiliki riwayat pencatatan transaksi. Nonaktifkan akun saja.']);
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
