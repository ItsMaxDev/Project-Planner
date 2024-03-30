<?php
namespace Services;

use Exception;
use Repositories\UserRepository;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

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

    public function isUserAdmin($userId) {
        return $this->repository->isUserAdmin($userId);
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

    public function generateToken($user)
    {
        $key = 'verysecretkey';
        $payload = [
            'iat' => time(),
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'is_admin' => $user->is_admin
            ]
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public function verifyToken($token)
    {
        $token = str_replace('Bearer ', '', $token);

        try {
            $decoded = JWT::decode($token, new Key('verysecretkey', 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            // Token verification failed
            return false;
        }
    }
}