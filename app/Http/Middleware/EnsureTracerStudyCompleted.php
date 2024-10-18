<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTracerStudyCompleted
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->has_completed_tracer_study) {
            return response()->json(['message' => 'Please complete the tracer study first.'], 403);
        }

        return $next($request);
    }
}