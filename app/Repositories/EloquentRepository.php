<?php
namespace App\Repositories;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Get model.
     *
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model.
     *
     * @return mixed
     */
    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    /**
     * Get all instances of model
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * create a new record in the database
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * update record in the database
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        return $record->update($data);
    }

    /**
     * remove record from the database
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
