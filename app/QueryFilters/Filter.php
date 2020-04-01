<?php

/**
 * QueryFilters
 * php version 7.1
 *
 * @category Eloquent
 * @package  Clinker
 * @author   Faisal Ahmed <hello@imfaisal.me>
 * @license  http://license.imfaisal.me/private Private
 * @link     http://imfaisal.me/ Faisal Ahmed
 */

namespace App\QueryFilters;

use ReflectionMethod;
use ReflectionException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Abstract filter class
 *
 * @category Filter
 * @package  IMain
 * @author   softzino
 * @license  
 * @link   
 */
abstract class Filter
{
    /**
     * Eloquent Builder instance
     *
     * @var Builder $builder
     */
    protected $builder;
    /**
     * Illuminate http request
     *
     * @var Request $request
     */
    protected $request;
    /**
     * Append all query string on paginate url
     *
     * @var array $_appends
     */
    private $_appends = [];

    private $_reservedMethods = ['order_by', 'sort_by', 'order', 'sort'];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Capture Request Query string
     *
     * @return array
     */
    public function query(): array
    {
        return $this->request->query();
    }
    /**
     * Apply Query Builder
     *
     * @param Builder $builder Eloquent Builder
     *
     * @return Builder|LengthAwarePaginator
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        $this->_appends = [];

        $this->_callToDefault();

        $skipToCall = array_merge(
            [],
            $this->_reservedMethods
        );
        foreach ($this->query() as $name => $value) {
            if (
                method_exists($this, Str::camel($name))
                & !in_array(Str::snake($name), $skipToCall, true)
            ) {
                $this->_appends[$name] = $value;
                $params = is_array($value) ? [$value] : explode(',', $value);
                array_unshift($params, $this->builder);
                call_user_func_array(
                    [$this, Str::camel($name)],
                    array_filter($params)
                );
            }
        }
        return $this->builder;
    }

    /**
     * @param Builder $query
     * @param string $column
     * @param string $direction
     * @return Builder
     */
    public function orderBy(
        Builder $query,
        string  $column,
        string  $direction
    ): Builder {
        return $query->orderBy($column, $direction);
    }

    /**
     * Call that method which is protected and has a default value
     * but not exists in query string
     */
    private function _callToDefault()
    {
        foreach (get_class_methods($this) as $method) {
            try {
                $that = new ReflectionMethod($this, $method);
            } catch (ReflectionException $exception) {
                break;
            }
            if (
                $that->isProtected()
                && !array_key_exists($method, $this->query())
            ) {
                $this->{$method}($this->builder);
            }
        }
    }

    /**
     * @return array
     */
    public function getAppendedQueryStrings()
    {
        return $this->_appends;
    }
}
