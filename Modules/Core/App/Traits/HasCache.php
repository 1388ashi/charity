<?php

namespace Modules\Core\App\Traits;

use Illuminate\Support\Facades\Cache;

trait HasCache
{
    /**
     * This function is responsible for clearing the cache when a specific cache key is passed.
     * It is useful for paginated Resources that are cached
     */
    public function clearPaginatedCache(string $key, int $total = 1000): void
    {
        for ($i = 1; $i <= $total; $i++) {
            $newKey = $key . $i;
            if (Cache::has($newKey)) {
                Cache::forget($newKey);
            } else {
                break;
            }
        }
    }

    private static function forgetAll(array $cacheKeys): void
    {
        foreach ($cacheKeys as $cacheKey) {
            if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            }
        }
    }

    protected static function clearAllCaches(array $keys): void
    {
        static::created(function () use ($keys) {
            static::forgetAll($keys);
        });
        static::saved(function () use ($keys) {
            static::forgetAll($keys);
        });
        static::deleted(function () use ($keys) {
            static::forgetAll($keys);
        });
    }
}
