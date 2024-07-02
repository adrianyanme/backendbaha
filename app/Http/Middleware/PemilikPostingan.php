<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Post;
use App\Http\Middleware\Pos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikPostingan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = Auth::user();
        $post = Post::findOrFail($request->id);

        if($post->author != $currentUser->id){
            return response()->json(['message' => 'KAMU TIDAK BERHAK'],401);
        }
        return $next($request);
    }
}
