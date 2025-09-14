<?php

namespace Modules\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait Filterable
{
    public function scopeFilters(Builder $query, array $inputs = []): void
    {
        $filterInputs = $this->getFilterInputs();
        foreach (self::$filterColumns as $filterColumn) {
            if (isset($inputs[$filterColumn]) && $inputs[$filterColumn]) {
                $operator = $filterInputs[$filterColumn]['operator'];
                $columnType = $filterInputs[$filterColumn]['column_type'];
                $relation = $filterInputs[$filterColumn]['relation'] ?? null;
                $type = $filterInputs[$filterColumn]['type'];
                $column = $filterInputs[$filterColumn]['column'];
                $value = $inputs[$filterColumn];
                if ($relation) {
                    if ($relation['type'] == 'belongsToMany') {
                        $query->whereHas($relation['name'], function (Builder $query) use ($column, $operator, $value) {
                            $query->where($column, $operator, $value);
                        });
                    } elseif ($relation['type'] == 'belongsTo') {
                        $query->where($column, '=', $value);
                    }
                } elseif (in_array($type, ['text', 'email']) && $operator == 'like') {
                    $query->where($column, 'like', "%{$value}%");
                } elseif ($columnType == 'date') {
                    $query->whereDate($column, $operator, $value);
                } elseif ($type == 'select') {
                    if (in_array($value, ['on', 'off'])) {
                        $value = $value == 'on' ? 1 : 0;
                    }
                    $query->where($column, $operator, $value);
                } else {
                    $query->where($column, $operator, $value);
                }
            }
        }
    }

    public static function getFilterInputs(): array
    {
        return Arr::only(config('core.filters'), self::$filterColumns);
    }

    // If select columns has dynamic options, override getFilterInputs method
    // Example
    // public static function getFilterInputs(): array
    // {
    //    $filters = Arr::only(config('core.filters'), self::$filterColumns);
    //    $filters['category_id']['options'] = Category::query()->pluck('name', 'id')->toArray();
    //
    //    return $filters;
    // }
}

