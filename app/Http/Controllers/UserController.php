<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\SearchService;
class UserController extends Controller
{
   public function index(Request $request, SearchService $searchService)
    {
        $users = $searchService->search(
            model: User::class,
            columns: ['name', 'email'],
            search: $request->search,
            perPage: 5,
            orderBy: 'id',
            direction: 'desc'
        );

        return view('user', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('user_index')
            ->with('success', 'User registered successfully!');
    }
     // Update an existing user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:4',
                'confirmed'
            ],
        ]);

        // Update name and email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Change password only if a new password was entered
        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()
            ->route('user_index')
            ->with('success', 'User updated successfully!');
    }
}
