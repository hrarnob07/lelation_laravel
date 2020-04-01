<?php


namespace App\Repositories;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class PostRepository extends Repository
{
    protected $postFilter;
    public function __construct(){

    }
    /**
     * @inheritDoc
     */
    public function all($perPage = null, $with = null)
    {
        // TODO: Implement all() method.
    }

    /**
     * @inheritDoc
     */
    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        $this->setErrors([]);
        try{
           $post = Post::create($data);

        }catch (\Throwable $exception)
        {
            $this->setErrors($exception->getMessage());
            return null;
        }
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data)
    {
        $this->setErrors([]);

        Try{
            $post = DB::transaction(function () use($id, $data){
                $post = Post::find($id);
                $post->update($data);
            });

        }catch (\Throwable $exception)
        {
            $this->setErrors($exception->getMessage());
            return null;

        }
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }
}
