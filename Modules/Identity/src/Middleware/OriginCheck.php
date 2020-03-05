<?php

namespace Modules\Identity\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class OriginCheck{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next){
    $client_id = $request->header('client-id');
    $client_secret = $request->header('client-secret');

    $validator = Validator::make($request->headers->all(), [
      'client-id' => [
        'required',
        Rule::exists('oauth_clients', 'id')->where(function ($query) use ($client_secret) {
          $query->where('secret', $client_secret);
        })
      ],
      'client-secret' => [
        'required',
        Rule::exists('oauth_clients', 'secret')->where(function ($query) use ($client_id) {
          $query->where('id', $client_id);
        })
      ]
    ]);

    if ($validator->fails()) {
        return forbidden_request();
    }

    return $next($request);
  }
}
