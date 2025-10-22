<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();
        $role = $user->role;

        if (!$role) {
            return response()->json(['error' => 'No role assigned to user'], 403);
        }

        $permissions = $role->permissions->pluck('name')->toArray();

        if (!in_array($permission, $permissions)) {
            return response()->json([
                'error' => "Cannot perform this action: You do not have permission '$permission'"
            ], 403);
        }

        return $next($request);
    }
}

