<?php

namespace App\Controllers;

use App\Models\User;
use App\Validators\Auth\AuthValidator;
use App\Validators\Auth\RegisterValidator;
use Core\Controller;
use ReallySimpleJWT\Token;
use App\Enums\Status;
use Dotenv\Dotenv;

if (!defined('BASE_DIR')) {
    define('BASE_DIR', dirname(__DIR__, 2));
}

class AuthController extends Controller
{
    private string $secretKey;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(BASE_DIR);
        $dotenv->load();

        $this->secretKey = $_ENV['JWT_SECRET'];
    }

    public function register(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $validator = new RegisterValidator();
        if (!$validator->validate($data)) {
            $this->jsonResponse(['errors' => $validator->getErrors()], Status::BAD_REQUEST->value);
            return;
        }

        $user = new User();
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_BCRYPT);

        if ($user->save()) {
            $this->jsonResponse(['message' => 'User registered successfully'], Status::CREATED->value);
        } else {
            $this->jsonResponse(['message' => 'Failed to register user'], Status::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function login(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $validator = new AuthValidator();
        if (!$validator->validate($data)) {
            $this->jsonResponse(['errors' => $validator->getErrors()], Status::BAD_REQUEST->value);
            return;
        }

        $user = User::findBy('email', $data['email']);

        if ($user && password_verify($data['password'], $user->password)) {
            $token = Token::create($user->id, $this->secretKey, time() + 3600, 'localhost');

            $this->jsonResponse(['token' => $token], Status::OK->value);
        } else {
            $this->jsonResponse(['message' => 'Invalid credentials'], Status::UNAUTHORIZED->value);
        }
    }
}

