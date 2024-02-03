<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("search");

        /** @var Builder $users */
        $users = User::onlyActive();
        if (null !== $search) {
            $users = $users->where(function (Builder $query) use ($search) {
                $query->where(User::COLUMN_NAME, "LIKE", "%" . $search . "%");
                $query->orWhere(User::COLUMN_USERNAME, "LIKE", "%" . $search . "%");
            });    
        }
        $users = $users->orderBy(User::COLUMN_USERNAME)->get();

        return view('users.index', compact('users', 'search'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
