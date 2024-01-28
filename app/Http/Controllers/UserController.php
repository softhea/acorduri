<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input("search", ""));

        $users = User::query()->whereNotNull('email_verified_at');
        if ("" !== $search) {
            $users = $users->where("name", "LIKE", "%" . $search . "%");    
        }
        $users = $users->get();

        return view('users.index', compact('users', 'search'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
