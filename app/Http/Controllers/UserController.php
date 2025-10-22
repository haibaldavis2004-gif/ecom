<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        return UserResource::collection(User::with('role')->get());
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Get default role (customer) if no role_id provided
        $defaultRoleId = $request->role_id ?? Role::where('name', 'customer')->first()->id;

        $user = User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $defaultRoleId,
        ]);

        $user->load('role'); // load role relationship
        return new UserResource($user);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('role'); // load role relationship
        return new UserResource($user);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Get validated data, now includes role_id
        $data = $request->validated();

        // Re-hash password only if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Update user including role_id
        $user->update($data);

        // Load role relationship to return with resource
        $user->load('role');

        return new UserResource($user);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204); // no content response
    }
}
