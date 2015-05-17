<?php
namespace QuickMemcache\Silex;

use \Silex\Application;
use \Silex\ServiceProviderInterface;
use \QuickMemcache\Memcache;

class MemcacheServiceProvider implements ServiceProviderInterface {

    public function register(Application $app) {
        $app['memcache.options'] = array(
            'host' => 'localhost',
            'port' => '11211'
        );

        $app['memcache'] = $app->share(function (Application $app) {
            $options = $app['memcache.options'];
            return Memcache::create($options['host'], $options['port']);
        });
    }

    public function boot(Application $app) { }

}