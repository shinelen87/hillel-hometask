<?php

namespace App\Controllers;

use App\Enums\Status;
use App\Models\Product;
use App\Validators\API\ProductValidationService;

class ProductController extends BaseApiController {
    protected function getModelClass(): string {
        return Product::class;
    }

    public function index(): void
    {
        $products = Product::select(['id', 'name', 'price', 'unit'])->get();

        $this->jsonResponse($products, Status::OK->value);
    }

    public function show($id): void
    {
        if (!ProductValidationService::validateId($id)) {
            $this->jsonResponse(['errors' => ProductValidationService::getErrors()], Status::BAD_REQUEST->value);
            return;
        }

        $product = Product::findById($id);
        if ($product) {
            $this->jsonResponse($product, Status::OK->value);
        } else {
            $this->jsonResponse(['message' => 'Product not found'], Status::NOT_FOUND->value);
        }
    }

    public function create(): void
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->jsonResponse(['message' => 'Invalid JSON input'], Status::BAD_REQUEST->value);
            return;
        }

        if (!ProductValidationService::validateRequiredFields($data, ['name', 'unit', 'price'])) {
            $this->jsonResponse(['errors' => ProductValidationService::getErrors()], Status::UNPROCESSABLE_ENTITY->value);
            return;
        }

        if (!ProductValidationService::validate($data)) {
            $this->jsonResponse(['errors' => ProductValidationService::getErrors()], Status::UNPROCESSABLE_ENTITY->value);
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
        if (!ProductValidationService::validateId($id)) {
            $this->jsonResponse(['errors' => ProductValidationService::getErrors()], Status::BAD_REQUEST->value);
            return;
        }

        if (!ProductValidationService::validateProductExists($id)) {
            $this->jsonResponse(['errors' => ProductValidationService::getErrors()], Status::NOT_FOUND->value);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $data['id'] = $id;

        if (!ProductValidationService::validate($data)) {
            $this->jsonResponse(['errors' => ProductValidationService::getErrors()], Status::UNPROCESSABLE_ENTITY->value);
            return;
        }

        $product = Product::findById($id);
        $product->fill($data);
        if ($product->save()) {
            $this->jsonResponse(['message' => 'Product updated', 'data' => $product], Status::OK->value);
        } else {
            $this->jsonResponse(['message' => 'Failed to update product'], Status::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function delete($id): void
    {
        if (!ProductValidationService::validateId($id)) {
            $this->jsonResponse(['errors' => ProductValidationService::getErrors()], Status::BAD_REQUEST->value);
            return;
        }

        if (!ProductValidationService::validateProductExists($id)) {
            $this->jsonResponse(['errors' => ProductValidationService::getErrors()], Status::NOT_FOUND->value);
            return;
        }

        $product = Product::findById($id);
        if ($product->delete()) {
            $this->jsonResponse(['message' => 'Product deleted'], Status::OK->value);
        } else {
            $this->jsonResponse(['message' => 'Failed to delete product'], Status::INTERNAL_SERVER_ERROR->value);
        }
    }
}
