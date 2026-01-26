<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
   public function create(){
    return view('user.index');
   }

  public function store(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|max:255',

    ]);

    $user = User::create([
        'name' => $validated['username'],
    ]);

    return redirect()->back()->with('success', 'User created successfully');
}

}
