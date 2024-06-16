<?php

namespace App\Controllers;

use App\Enums\SQL;
use App\Enums\Status;
use App\Models\Product;
use Core\Controller;

class ProductController extends Controller {
    public function index(): void
    {
        $products = Product::select(['id', 'name', 'price', 'unit'])
            ->where('name', SQL::EQUAL, 'banana')
            ->orWhere('name', SQL::EQUAL, 'apple')
            ->get();

        $this->jsonResponse($products, Status::OK->value);
    }

    public function show($id): void
    {
        $product = Product::findById($id);
        if ($product) {
            $this->jsonResponse($product, Status::OK->value);
        } else {
            $this->jsonResponse(['message' => 'Product not found'], Status::NOT_FOUND->value);
        }
    }

    public function create(): void
    {
        error_log("Entering create method");

        $input = file_get_contents('php://input');

        $data = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->jsonResponse(['message' => 'Invalid JSON input'], Status::BAD_REQUEST->value);
            return;
        }

        $product = new Product();
        $product->fill($data);

        if ($product->save()) {
            $this->jsonResponse(['message' => 'Product created', 'data' => $product], Status::CREATED->value);
        } else {
            $this->jsonResponse(['message' => 'Failed to create product'], Status::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function update($id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $product = Product::findById($id);

        if ($product) {
            $product->fill($data);
            if ($product->save()) {
                $this->jsonResponse(['message' => 'Product updated', 'data' => $product], Status::OK->value);
            } else {
                $this->jsonResponse(['message' => 'Failed to update product'], Status::INTERNAL_SERVER_ERROR->value);
            }
        } else {
            $this->jsonResponse(['message' => 'Product not found'], Status::NOT_FOUND->value);
        }
    }

    public function delete($id): void
    {
        $product = Product::findById($id);
        if ($product && $product->delete()) {
            $this->jsonResponse(['message' => 'Product deleted'], Status::OK->value);
        } else {
            $this->jsonResponse(['message' => 'Failed to delete product'], Status::INTERNAL_SERVER_ERROR->value);
        }
    }
}
