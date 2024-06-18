<?php

namespace App\Controllers;

use App\Enums\Status;
use Core\Controller;
use Core\Model;
use Exception;
use ReallySimpleJWT\Token;

abstract class BaseApiController extends Controller
{
    abstract protected function getModelClass(): string;

    protected ?Model $model;

    /**
     * @throws \Exception
     */
    public function before(string $action, array $params = []): bool
    {
        $token = getAuthToken();

        if (!Token::validate($token, $this->secretKey)) {
            throw new Exception('Token is invalid', 422);
        }

        $this->checkModelOwner($action, $params, $this->getModelClass());

        return true;
    }

    protected function checkModelOwner(string $action, array $params, string $modelClass): void
    {
        if (in_array($action, ['update', 'delete'])) {
            $result = call_user_func_array([$modelClass, 'findById'], $params);

            if (!$result) {
                throw new Exception("Resource is not found", Status::NOT_FOUND->value);
            }
        }
    }
}
