<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function create()
    {
        $roles = config('roles');
        $users = User::all();
        return view('user.index', compact('roles', 'users'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required|min:6|max:255',
            'role'     => 'required|in:superadmin,admin,user',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),

            'role' => $validated['role']
        ]);

        return response()->json([
            'message' => 'User created successfully!',
            'user' => $user
        ]);
    }

    public function edit($id)
    {
        $user_datas = User::findOrFail($id); // fetch user or fail
        return response()->json([
            'user' => $user_datas
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:6|max:255',
            'role' => 'required|in:superadmin,admin,user',
        ]);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully!',
            'user' => $user
        ]);
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json([
        'message' => 'User deleted successfully!'
    ]);
}
}
