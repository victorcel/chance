<?php

namespace App\Http\Middleware;

use App\Loteria;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ChanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $now = new \DateTime();
//        dd($now->format('H'));
        $dato = DB::select('SELECT count(*) as result FROM loterias WHERE loterias.tarjeta='.$request->user()->username.' and hour(loterias.created_at) =' . $now->format('H'));
        $dato = $dato[0]->result;
        if ($dato >= 1) {
              //alert()->info('Notificación de Información');
          // Alert::info('Info', 'El cliente ya redimio su chance a esta hora.');
            //alert()->success('El cliente ya redimio su chance a esta hora.','Info')->autoclose(3000);
            Auth::logout();
           return \Redirect::route('login')
        ->with('info', 'El cliente ya redimio su chance a esta hora');
        }
        return $next($request);
    }
}

//        //if ($request->user()->username)