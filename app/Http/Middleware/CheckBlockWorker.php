<?php

namespace App\Http\Middleware;
use App\Worker;
use Closure;

class CheckBlockWorker
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

        $worker_id=$request->input('worker_id');
        $ban=Worker::find($worker_id);

        if($ban->ban==1)
        {
            return response()->json([
                "message"=>'This worker is blocked please log in again'
            ]);

        }
        return $next($request);
    }
}
