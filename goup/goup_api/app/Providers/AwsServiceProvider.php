<?php

namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
use Aws\Sns\SnsClient;
 
class AwsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $awsCredentials = [
            'region'      => 'us-east-1',
            'version'     => 'latest',
            'credentials' => [
                'key' => 'AKIA3CQXHX3HNWJOMMKU',
                'secret' => '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',
            ],
        ];
 
        $this->app->instance(SnsClient::class, new SnsClient($awsCredentials));
    }
}