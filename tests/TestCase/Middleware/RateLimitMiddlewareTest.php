<?php
declare(strict_types=1);

namespace App\Test\TestCase\Middleware;

use App\Middleware\RateLimitMiddleware;
use Cake\Cache\Cache;
use Cake\Http\Response;
use Cake\TestSuite\TestCase;
use Psr\Http\Server\RequestHandlerInterface;
use Cake\Http\ServerRequestFactory;
use Zend\HttpHandlerRunner\RequestHandlerRunner;

/**
 */
class RateLimitMiddlewareTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->cache = Cache::pool('ratelimit');
    }
    public function tearDown(): void
    {
        parent::tearDown();
        $this->cache->clear();
    }

    public function testRatelimitOk()
    {
        $middleware = new RateLimitMiddleware(1, $this->cache);
        $request = ServerRequestFactory::fromGlobals(['REQUEST_URI' => '/tests']);
        $response = new Response(['status' => 200]);
        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        $handler->method('handle')
            ->will($this->returnValue($response));

        $response = $middleware->process($request, $handler);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRateLimitExceeded()
    {
        $request = ServerRequestFactory::fromGlobals(['REQUEST_URI' => '/tests']);

        $middleware = new RateLimitMiddleware(1, $this->cache);
        $key = $middleware->getKey($request);
        $this->cache->set($key, 5);

        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        $handler->expects($this->never())->method('handle');

        $response = $middleware->process($request, $handler);
        $this->assertEquals(429, $response->getStatusCode());
    }
}
