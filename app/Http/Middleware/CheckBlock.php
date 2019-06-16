<?php

namespace App\Http\Middleware;

use Closure;

class CheckBlock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->input('job_id');
        if($id)
        {
        return response()->json([
            "message"=>"her is the workers",
            "data"=> $id
        ]);
        }
        return $next($request);
    }
}
