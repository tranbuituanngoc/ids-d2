<?php
namespace App\Repositories\User;
use App\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\User::class;
    }
    /**
     * Get model by id
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
    /**
     * Find model by column
     *
     * @param string $attribute
     * @param string $value
     * @return mixed
     */
    public function findBy($attribute, $value)
    {
        return $this->model->where($attribute, $value)->first();
    }
}
