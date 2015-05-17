<?php
namespace QuickMemcache\Tests;

use \QuickMemcache\Memcache;

class MemcacheTest extends \PHPUnit_Framework_TestCase {

    protected $host = 'localhost';
    protected $port = '11211';

    protected function setUp() {
        $memcache = new \Memcache();
        $memcache->connect($this->host, $this->port);
        $memcache->delete('key1');
        $memcache->delete('key2');
    }

    public function testCreate() {
        $memcache = Memcache::create($this->host, $this->port);
        $this->assertInstanceOf('\QuickMemcache\Memcache', $memcache);
    }

    public function testCannotCreate() {
        $this->setExpectedException('\QuickMemcache\Exception\CannotConnectException');
        $invalid_port = 10101;
        Memcache::create($this->host, $invalid_port);
    }

    public function testGetOrSetNewValue() {
        $memcache = Memcache::create($this->host, $this->port);

        $data = $memcache->getOrSet('key1', function () {
            return 'new_value';
        });
        $memcache->close();

        $this->assertEquals('new_value', $data);
    }

    public function testGetOrSetExistValue() {
        $memcache = Memcache::create($this->host, $this->port);

        $memcache->set('key1', 'value');
        $data = $memcache->getOrSet('key1', function () {
            return 'new_value';
        });
        $memcache->close();

        $this->assertEquals('value', $data);
    }

}