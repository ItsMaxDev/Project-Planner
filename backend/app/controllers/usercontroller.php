<?php
namespace Controllers;

use Exception;
use Services\UserService;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class UserController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new UserService();
    }

    public function login()
    {
        try {
            $data = $this->getPostedJson();

            // Check if username and password are provided
            if (empty($data->username) || empty($data->password)) {
                throw new Exception("Username and password are required.");
            }

            // Check username and password against database
            $user = $this->service->checkUsernamePassword($data->username, $data->password);

            if (!$user) {
                throw new Exception("Invalid username or password.");
            }

            // Generate JWT token
            $token = $this->generateToken($user);

            // Send token back to the client
            $this->respond(['token' => $token]);
        } catch (Exception $e) {
            $this->respondWithError(400, $e->getMessage());
        }
    }

    public function register()
    {
        try {
            $data = $this->getPostedJson();

            // Check if username, email, and password are provided
            if (empty($data->username) || empty($data->email) || empty($data->password)) {
                throw new Exception("Username, email, and password are required.");
            }

            // Check if username or email already exists
            if (!$this->service->isUsernameEmailAvailable($data->username, $data->email)) {
                throw new Exception("Username or email already exists.");
            }

            // Create user
            $user = $this->service->createUser($data->username, $data->email, $data->password);

            if (!$user) {
                throw new Exception("Failed to create user.");
            }

            // Generate JWT token
            $token = $this->generateToken($user);

            // Send token back to the client
            $this->respond(['token' => $token]);
        } catch (Exception $e) {
            $this->respondWithError(400, $e->getMessage());
        }
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

        return JWT::encode($payload, $key, 'HS256'); // Encode payload using HS256 algorithm
    }

    public function verifyToken($token)
    {
        if (strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }

        try {
            $decoded = JWT::decode($token, new Key('verysecretkey', 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            // Token verification failed
            return false;
        }
    }
}
