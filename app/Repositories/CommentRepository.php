<?php


namespace App\Repositories;


use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends Repository
{

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
           $comment = Comment::create($data);

        }catch (\Throwable $exception)
        {
            $this->setErrors($exception->getMessage());
            return null;
        }
        return $comment;
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }
}
