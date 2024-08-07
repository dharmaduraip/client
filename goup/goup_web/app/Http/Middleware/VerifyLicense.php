<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Redis;

class VerifyLicense
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
        $domain = $_SERVER['SERVER_NAME'];
        $path = storage_path('license') . '/' . $domain . '.json';
        $config_file = file_exists($path);

        if ($config_file) {

            $config = file_get_contents($path);
            $access_key = json_decode($config, true)['accessKey'];

            try {
                $client = new \GuzzleHttp\Client();
                $params['form_params'] = ['access_key' => $access_key, 'domain' => $domain];
                $result = $client->post(env('BASE_URL') . '/verify', $params);
                $redis = Redis::connection();
                //if($redis->get($domain) == null) {
                    $redis->set($domain, json_encode(json_decode($result->getBody())));
                //}

            } catch (GuzzleHttp\Exception\ClientException $exception) {
                abort(503);
                dd(json_decode($exception->getResponse()->getBody())->message);
            } catch (\Exception $exception) {
                dd($exception);
                return abort(500, 'Contact our team to access your domain');
                dd($exception);
            }

        } else {
            return abort(500, 'Contact our team to access your domain');
        }

        return $next($request);

    }
}
