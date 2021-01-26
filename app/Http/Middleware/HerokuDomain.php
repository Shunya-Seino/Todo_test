<?php
namespace App\Http\Middleware;

use Closure;

class HerokuDomain {

  public function handle($request, Closure $next)
  {
    if (substr($request->header('host'), -13) === 'herokuapp.com') {
        // ドメイン末尾がherokuapp.comのアクセスの場合、.envで指定したAPP_URLに遷移させる
        return redirect()->away(config('app.url') . $_SERVER['REQUEST_URI']);
    }
    return $next($request);
  }
}