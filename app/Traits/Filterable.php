<?php
/**
 * Filterable
 * php version 7.1
 *
 * @category Eloquent
 * @package  Clinker
 * @author
 * @license
 * @link
 */
namespace App\Traits;

use App\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
/**
 * User filter trait
 *
 * @category Eloquent
 * @package  app
 * @author
 * @license
 * @link
 */
trait Filterable
{
    /**
     * @var Filter $_self
     */
    private $_self;
    /**
     * Filter scope
     *
     * @param Builder $query   Eloquent query builder
     * @param Filter  $filters Query Filter
     *
     * @return Builder
     */
    public function scopeFilter(Builder $query, Filter $filters)
    {
        $this->_self = $filters;
        return $filters->apply($query);
    }

    /**
     * @param Builder $query
     * @param int $perPage
     * @return LengthAwarePaginator|null
     */
    public function scopeFilterPaginate(Builder $query, int $perPage): ?LengthAwarePaginator
    {
        $paginate = $query->paginate($perPage);
        $paginate->appends($this->_self->getAppendedQueryStrings())->links();
        return $paginate;
    }
}
