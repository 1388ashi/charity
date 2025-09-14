<?php


namespace Modules\Core\Classes;

use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as DbCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Tag extends \Spatie\Tags\Tag
{
    public array $translatable = [];

    public static function bootHasSlug()
    {
        static::saving(function (Model $model) {
            collect($model->name)
                ->each(fn (string $locale) => $model->slug = $model->generateSlug($locale));
        });
    }

    protected function generateSlug(string $locale): string
    {
        $slugger = config('tags.slugger');

        $slugger ??= '\Illuminate\Support\Str::slug';

        return call_user_func($slugger, $this->name);
    }

    public function scopeWithType(Builder $query, string $type = null): Builder
    {
        if (is_null($type)) {
            return $query;
        }

        return $query->where('type', $type)->ordered();
    }

    public function scopeContaining(Builder $query, string $name, $locale = null): Builder
    {
        $locale = $locale ?? app()->getLocale();

        return $query->whereRaw('lower(' . $this->getQuery()->getGrammar()->wrap('name like ?', ['%' . mb_strtolower($name) . '%']));
    }

    public static function findOrCreate(
        string | array | ArrayAccess $values,
        string | null $type = null,
        string | null $locale = null,
    ): Collection |\Spatie\Tags\Tag| static {
        $tags = collect($values)->map(function ($value) use ($type, $locale) {
            if ($value instanceof self) {
                return $value;
            }

            return static::findOrCreateFromString($value, $type, $locale);
        });

        return is_string($values) ? $tags->first() : $tags;
    }

    public static function getWithType(string $type): DbCollection
    {
        return static::withType($type)->ordered()->get();
    }

    public static function findFromString(string $name, string $type = null, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return static::query()
            ->where("name", $name)
            ->where('type', $type)
            ->first();
    }

    public static function findFromStringOfAnyType(string $name, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return static::query()
            ->where("name", $name)
            ->first();
    }

    protected static function findOrCreateFromString(string $name, string $type = null, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $tag = static::findFromString($name, $type, $locale);

        if (! $tag) {
            $tag = static::create([
                'name' =>  $name,
                'type' => $type,
            ]);
        }

        return $tag;
    }

    public static function getTypes(): Collection
    {
        return static::groupBy('type')->pluck('type');
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->translatable) && ! is_array($value)) {
            return $this->setTranslation($key, app()->getLocale(), $value);
        }

        return parent::setAttribute($key, $value);
    }
}
