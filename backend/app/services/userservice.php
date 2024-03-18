<?php
namespace Services;

use Repositories\UserRepository;

class UserService {

    private $repository;

    function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function isUsernameEmailAvailable($username, $email) {
        return $this->repository->isUsernameEmailAvailable($username, $email);
    }

    public function checkUsernamePassword($username, $password) {
        return $this->repository->checkUsernamePassword($username, $password);
    }

    public function createUser($username, $email, $password) {
        $user = new \Models\User();
        $user->username = $username;
        $user->email = $email;
        $user->password = $this->hashPassword($password);
        
        return $this->repository->insert($user);
    }

    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}