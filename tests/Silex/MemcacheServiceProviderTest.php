<?php
namespace QuickMemcache\Tests\Silex;

use \Silex\Application;
use \Silex\ServiceProviderInterface;
use \QuickMemcache\Memcache;
use QuickMemcache\Silex\MemcacheServiceProvider;

class MemcacheServiceProviderTest extends \PHPUnit_Framework_TestCase {

    public function testRegistration() {
        $app = new \Silex\Application();

        $app->register(new MemcacheServiceProvider(), array(
            'memcache.options' => array(
                'host' => 'localhost',
                'port' => '11211'
            )
        ));

        $this->assertInstanceOf('\QuickMemcache\Memcache', $app['memcache']);
    }

    public function testReplaceOptions() {
        $app = new \Silex\Application();

        $app->register(new MemcacheServiceProvider(), array(
            'memcache.options' => array(
                'host' => 'localhost',
                // Invalid port
                'port' => '10101'
            )
        ));

        $this->setExpectedException('\QuickMemcache\Exception\CannotConnectException');
        $memcache = $app['memcache'];
    }

}