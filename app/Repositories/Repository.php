<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class Repository
{
    private $_errors = [];
    /**
     *     get all errors
      *@return array
     */

     public function errors() : array
     {
         return $this->_errors;
     }

    /**
     * @param array|string $errors
     */
    public function setErrors($errors): void
    {
        if (is_string($errors)) {
            $this->_errors[] = $errors;
        } else {
            $this->_errors = $errors;
        }
    }

    /**
     * Get All data with Paginator
     *
     * @param int|null          $perPage set how many data show per page
     * @param string|array|null $with    retrieve data with given relationship
     *
     * @return Collection|Model|LengthAwarePaginator|null
     */
    abstract public function all($perPage = null, $with = null);

    /**
     * Get specific data by primary key
     *
     * @param int $id primary key
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    abstract public function show(int $id);

    /**
     * Add new record into database
     *
     * @param array $data record array
     *
     * @return Model|null
     */
    abstract public function create(array $data);

        /**
     * Update existing database record
     *
     * @param int   $id   record table primary key
     * @param array $data updated record data
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    abstract public function update(int $id, array $data);

        /**
     * Delete single database record
     *
     * @param int $id primary key
     *
     * @return int|null
     */
    abstract public function delete(int $id);

}
