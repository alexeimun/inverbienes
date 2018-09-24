<?php namespace Rhemo\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Query\Builder as BaseBuilder;

class ActiveScope implements Scope {

    /**
     * Apply scope on the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model) {
        $builder->where('active', 1);
    }

    /**
     * Remove scope from the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function remove(Builder $builder) {
        $column = 'active';
        $query = $builder->getQuery();
        $bindingKey = 0;
        foreach ((array)$query->wheres as $key => $where) {
            if($this->isActiveConstraint($where, $column)) {
                $this->removeWhere($query, $key);
                // Here SoftDeletingScope simply removes the where
                // but since we use Basic where (not Null type)
                // we need to get rid of the binding as well
                $this->removeBinding($query, $bindingKey);
            }

            // Check if where is either NULL or NOT NULL type,
            // if that's the case, don't increment the key
            // since there is no binding for these types
            if(!in_array($where['type'], ['Null', 'NotNull'])) $bindingKey++;
        }
    }

    /**
     * Remove scope constraint from the query.
     *
     * @param BaseBuilder $query
     * @param  int $key
     * @return void
     */
    protected function removeWhere(BaseBuilder $query, $key) {
        unset($query->wheres[$key]);
        $query->wheres = array_values($query->wheres);
    }

    /**
     * Remove scope constraint from the query.
     *
     * @param BaseBuilder $query
     * @param  int $key
     * @return void
     */
    protected function removeBinding(BaseBuilder $query, $key) {
        $bindings = $query->getRawBindings()['where'];
        unset($bindings[$key]);
        $query->setBindings($bindings);
    }

    /**
     * Check if given where is the scope constraint.
     *
     * @param  array $where
     * @param  string $column
     * @return boolean
     */
    protected function isActiveConstraint(array $where, $column) {
        return ($where['type'] == 'Basic' && $where['column'] == $column && $where['value'] == 1);
    }

    /**
     * Extend Builder with custom method.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     */
    protected function addWithDeactives(Builder $builder) {
        $builder->macro('withDrafts', function (Builder $builder) {
            $this->remove($builder);
            return $builder;
        });
    }
}