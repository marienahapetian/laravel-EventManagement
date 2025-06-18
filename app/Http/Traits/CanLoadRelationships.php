<?php

namespace App\Http\Traits;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelationships
{
    public function loadRelationships(
        Model|QueryBuilder|EloquentBuilder|HasMany $for,
        $relations = null

    ): Model|QueryBuilder|EloquentBuilder|HasMany {
        $relations = $relations ?? $this->relations ?? [];

        foreach ($relations as $r) {
            $for->when(
                $this->shouldIncludeRelation($r),
                fn($q) => $for instanceof Model ? $for->load($r) : $q->with($r)
            );
        }

        return $for;
    }

    protected function shouldIncludeRelation(string $relation): bool
    {
        $include = request()->query('include');

        if (!$include)
            return false;

        $relations = array_map('trim', explode(',', $include));
        return in_array($relation, $relations);
    }
}
