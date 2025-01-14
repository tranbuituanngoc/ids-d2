<?php
namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all instances of model
     *
     * @return mixed
     */
    public function all();

    /**
     * create a new record in the database
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * update record in the database
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * remove record from the database
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Get the associated model
     *
     * @return mixed
     */
    public function getModel();
}
