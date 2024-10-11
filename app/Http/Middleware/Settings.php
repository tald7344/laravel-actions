<?php

namespace App\Http\Middleware;

use App\Actions\Settings\GetSettingsAction;
use Closure;
use Illuminate\Support\Facades\Cookie;

class Settings
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
        $settings = GetSettingsAction::run();
        foreach($settings as $key => $value)
            config(['app.'.$key =>  $value ] );
        
        return $next($request);
    }
}