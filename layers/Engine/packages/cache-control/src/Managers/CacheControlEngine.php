<?php

declare(strict_types=1);

namespace PoP\CacheControl\Managers;

use PoP\Root\App;

class CacheControlEngine implements CacheControlEngineInterface
{
    protected ?int $minimumMaxAge = null;

    /**
     * Add a max age from a requested field
     */
    public function addMaxAge(int $maxAge): void
    {
        if (!$this->isCachingEnabled()) {
            return;
        }
        // Keep the minumum max age
        if (is_null($this->minimumMaxAge) || $maxAge < $this->minimumMaxAge) {
            $this->minimumMaxAge = $maxAge;
        }
    }

    /**
     * By default, enable caching only when executing GET operations
     */
    protected function isCachingEnabled(): bool
    {
        return App::server('REQUEST_METHOD') === 'GET';
    }

    /**
     * Calculate the request's max age as the minimum max age from all the requested fields.
     * Return an array with [key]: header name, [value]: header value
     *
     * @return array<string,string>|null
     */
    public function getCacheControlHeaders(): ?array
    {
        if ($this->minimumMaxAge !== null) {
            // If the minimum age is 0, send the "do not cache" instruction
            if ($this->minimumMaxAge === 0) {
                return [
                    'Cache-Control' => 'no-store'
                ];
            }
            return [
                'Cache-Control' => sprintf(
                    'max-age=%s',
                    $this->minimumMaxAge
                ),
            ];
        }

        // No field was requested, return no headers
        return null;
    }
}
