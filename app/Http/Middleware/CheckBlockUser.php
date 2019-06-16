<?php

namespace App\Http\Middleware;
use App\User;
use Illuminate\Support\Facades\DB;

use Closure;

class CheckBlockUser
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
        $user_id=$request->input('user_id');
        $ban=User::find($user_id);

        if($ban->ban==1)
        {
            return response()->json([
                "message"=>'This user is blocked please log in again'
            ]);

        }


        return $next($request);
    }
}
