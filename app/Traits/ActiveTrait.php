<?php

namespace Rhemo\Traits;

use Illuminate\Database\Eloquent\Builder;
use Rhemo\Scopes\ActiveScope;

trait ActiveTrait {

    private static $ACTIVE_COLUMN = 'active';
    private static $ACTIVE = 1;
    private static $DEACTIVATE = 0;

    /**
     * Boot the scope.
     *
     * @return void
     */
    public static function bootActiveTrait() {
        static::addGlobalScope(new ActiveScope);
    }

    /**
     * Get the fully qualified column name for applying the scope.
     *
     * @return string
     */
    public function getQualifiedActiveColumn() {
        return $this->getTable() . '.' . static::$ACTIVE_COLUMN;
    }

    /**
     * Deactivates the record
     *
     * @param Builder $q
     * @return string
     */
    public function scopeDeactivate(Builder $q) {
        return $q->update([$this->getQualifiedActiveColumn() => static::$DEACTIVATE]);
    }

    /**
     * activates the record
     *
     * @return mixed
     */
    public function activate() {
        return $this->update(['active' => static::$ACTIVE]);
    }
}