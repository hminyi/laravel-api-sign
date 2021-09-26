<?php

namespace Zsirius\Signature\Middleware;

use Closure;
use Illuminate\Http\Request;
use Zsirius\Signature\Facades\Signature;

class ApiSign
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('GET') || $request->isMethod('DEELTE')) {
            $params = $request->query();
        } else {
            $params = $request->query();
            if (!strpos($request->header('content-type'), 'multipart/form-data')) {
                $params['body'] = md5($request->getContent());
            }
        }
        if (config('signature.status')) {
            Signature::checkSign($params); // 不通过抛出异常
        }
        return $next($request);
    }
}
