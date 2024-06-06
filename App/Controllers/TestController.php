<?php

namespace App\Controllers;

use Core\Controller;

class TestController extends Controller {
    public function index(): void
    {
        $this->jsonResponse(['message' => 'Hello, World!']);
    }

    public function show($id): void
    {
        $this->jsonResponse(['message' => 'Showing item with ID: ' . $id]);
    }

    public function create(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $this->jsonResponse(['message' => 'Resource created', 'data' => $data], 201);
    }

    public function update($id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $this->jsonResponse(['message' => 'Resource updated', 'id' => $id, 'data' => $data]);
    }

    public function delete($id): void
    {
        $this->jsonResponse(['message' => 'Resource deleted', 'id' => $id]);
    }
}
