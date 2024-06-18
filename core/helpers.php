<?php

use App\Enums\Status;
use ReallySimpleJWT\Token;

/**
 * @throws Exception
 */
function getAuthToken(): string
    {
        $headers = apache_request_headers();

        if (empty($headers['Authorization'])) {
            throw new Exception('The request should contain an auth token', Status::UNPROCESSABLE_ENTITY->value);
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);

        if (!Token::validateExpiration($token)) {
            throw new Exception('Token is invalid', Status::UNPROCESSABLE_ENTITY->value);
        }

        return $token;
    }

/**
 * @throws Exception
 */
function authId(): int
    {
        $token = Token::getPayload(getAuthToken());

        if (empty($token['user_id'])) {
            throw new Exception('Token structure is invalid', Status::UNPROCESSABLE_ENTITY->value);
        }

        return $token['user_id'];
    }
