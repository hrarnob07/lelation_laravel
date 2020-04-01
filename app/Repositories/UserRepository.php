<?php


namespace App\Repositories;

use Throwable;
use App\Models\User;
use App\QueryFilters\UserFilters;
use Illuminate\Database\QueryException;

class UserRepository extends Repository{
    protected $userFilters;

    public function __construct( UserFilters $userFilters){
        $this->userFilters = $userFilters;
    }

    /**
     * Return all user
     *
     * @param int $perPage how many row return in one request
     *  @return all the user with pagination
     */

     public function all($perPage = null, $with = null){

        $this->setErrors([]);

        try
        {
            $users = User::filter($this->userFilters);
            if (!empty($with) && (is_string($with) || is_array($with))) {
                $users = $users->with($with);
            }
            if (isset($perPage)) {
                $users = $users->filterPaginate($perPage);
            } else {
                $users = $users->get();
            }
        }
        catch(QueryException $exception)
        {
            $this->setErrors($exception->getMessage());
            return null;
        }
        return $users;
     }

     public function show($id)
     {
         $this->setErrors([]);
         try
         {
             $user = User::find($id);

         }
         catch(Throwable $exception)
         {
             $this->setErrors($exception->getMessage());
             return null;
         }
         return $user;
     }

     /**
     * Add new User record into database
     *
     * @param array $data new user record data
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

     public function create(array $data)
     {
         $this->setErrors([]);
         try
         {
            $user = User::create($data);
         }
         catch(QueryException $exception)
         {
             $this->setErrors($exception->getMessage());
             return null;
         }
         return $user;
     }

     public function update(int $id,array $data)
     {
         $this->setErrors([]);

         try
         {
            $user = User::find($id);
            $user->update($data);
         }
         catch(Throwable $exception)
         {
             $this->setErros($exception->getMessage());
             return null;
         }
         return $this->show($id);
     }

     public function delete(int $id)
     {
        $this->setErrors([]);
        try
        {
            $count = User::destory($id);
        }
        catch(Throwable $exception)
        {
            $this->setErrors($exception->getMessage());
            return null;
        }
        return $count;
     }

}

