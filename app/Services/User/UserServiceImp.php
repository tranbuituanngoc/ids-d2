<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;

class UserServiceImp implements UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Paginate model
     *
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage)
    {
        return $this->userRepository->paginate($perPage);
    }

    /**
     * Get all instances of model
     *
     * @return mixed
     */
    public function all()
    {
        return $this->userRepository->all();
    }

    /**
     * Create a new instance of model
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        //check if the email already exists
        $user = $this->userRepository->findBy('email', $data['email']);
        if ($user) {
            throw new \Exception('Email already exists');
        }

        return $this->userRepository->create($data);
    }

    /**
     * Find a model by its primary key
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * Update the specified model in the database
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $user = $this->userRepository->find($id);

        if ($user->email !== $data['email']) {
            $existUser = $this->userRepository->findBy('email', $data['email']);
            if ($existUser) {
                throw new \Exception('Email already exists');
            }
        }
        if ($user) {
            $data['name'] = !empty($data['name']) ? $data['name'] : $user->name;
            $data['email'] = !empty($data['email']) ? $data['email'] : $user->email;
            $data['password'] = !empty($data['password']) ? bcrypt($data['password']) : $user->password;

            $this->userRepository->update($data, $id);
            return $user;
        }
        throw new \Exception('User not found');
    }

    /**
     * Remove the specified model from the database
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        $user = $this->userRepository->find($id);
        if ($user) {
            return $this->userRepository->delete($id);
        }
        return null;
    }

    /**
     * Update user profile
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateProfile(array $data, $id)
    {
        $user = $this->userRepository->find($id);
        if ($user) {
            return $this->userRepository->update($data, $id);
        }
        throw new \Exception('User not found');
    }
}
