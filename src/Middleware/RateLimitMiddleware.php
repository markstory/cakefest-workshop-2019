<?php
declare(strict_types=1);

namespace App\Middleware;

use Cake\Cache\Cache;
use Cake\Cache\CacheEngineInterface;
use Cake\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * RateLimit middleware
 */
class RateLimitMiddleware implements MiddlewareInterface
{
    protected $threshold;
    protected $cache;

    public function __construct(int $threshold, CacheEngineInterface $cache)
    {
        $this->threshold = $threshold;
        $this->cache = $cache;
    }

    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var $request \Cake\Http\ServerRequest */
        $key = md5($request->clientIp());
        $count = $this->cache->get($key);
        if ($count > $this->threshold) {
            return new Response([
                'body' => 'Rate limit exceeded',
                'status' => 429,
            ]);
        }

        if ($count === null) {
            $count = 0;
        }
        $this->cache->set($key, $count + 1);

        $response = $handler->handle($request);
        return $response->withHeader('X-Rate-Limit', $this->threshold - $count);
    }
}
