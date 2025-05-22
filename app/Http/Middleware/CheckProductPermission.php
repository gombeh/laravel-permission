<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProductPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $product = $request->route('product');


        if (
            $product &&
            $product->users->contains($user) ||
            $user->teams->intersect($product->teams)->isNotEmpty()
        ) {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }
}
