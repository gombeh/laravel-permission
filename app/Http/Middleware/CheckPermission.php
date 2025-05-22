<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();


        $hasPermissionInTeam = Permission::whereHas('teams.users', fn($query) => $query->wherekey($user->getKey()))
            ->where('name', $permission)
            ->exists();

        if (
            $user->permissions->pluck('name')->contains($permission) ||
            $hasPermissionInTeam
        ) {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }
}
