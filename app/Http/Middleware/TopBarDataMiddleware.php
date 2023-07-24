<?php

namespace App\Http\Middleware;

use Closure;

class TopBarDataMiddleware
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
        $timeData = [
            'Dhaka' => new \DateTime('now', new \DateTimeZone('Asia/Dhaka')),
            'London' => new \DateTime('now', new \DateTimeZone('Europe/London')),
            'Italy' => new \DateTime('now', new \DateTimeZone('Europe/Rome')),
            'Australia' => new \DateTime('now', new \DateTimeZone('Australia/Sydney')),
            'Canada' => new \DateTime('now', new \DateTimeZone('America/Toronto')),
        ];

        // Share the $timeData variable with all views
        view()->share('timeData', $timeData);

        return $next($request);
    }


}
