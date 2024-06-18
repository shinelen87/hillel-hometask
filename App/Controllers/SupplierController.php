<?php

namespace App\Controllers;

use App\Enums\Status;
use App\Models\Supplier;
use App\Validators\API\SupplierValidationService;

class SupplierController extends BaseApiController {
    protected function getModelClass(): string {
        return Supplier::class;
    }

    public function index(): void
    {
        $suppliers = Supplier::select(['id', 'name', 'address', 'phone'])->get();
        $this->jsonResponse($suppliers, Status::OK->value);
    }

    public function show($id): void
    {
        if (!SupplierValidationService::validateId($id)) {
            $this->jsonResponse(['errors' => SupplierValidationService::getErrors()], Status::BAD_REQUEST->value);
            return;
        }

        $supplier = Supplier::findById($id);
        if ($supplier) {
            $this->jsonResponse($supplier, Status::OK->value);
        } else {
            $this->jsonResponse(['message' => 'Supplier not found'], Status::NOT_FOUND->value);
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

        if (!SupplierValidationService::validateRequiredFields($data, ['name'])) {
            $this->jsonResponse(['errors' => SupplierValidationService::getErrors()], Status::UNPROCESSABLE_ENTITY->value);
            return;
        }

        if (!SupplierValidationService::validate($data)) {
            $this->jsonResponse(['errors' => SupplierValidationService::getErrors()], Status::UNPROCESSABLE_ENTITY->value);
            return;
        }

        $supplier = new Supplier();
        $supplier->fill($data);

        if ($supplier->save()) {
            $this->jsonResponse(['message' => 'Supplier created', 'data' => $supplier], Status::CREATED->value);
        } else {
            $this->jsonResponse(['message' => 'Failed to create supplier'], Status::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function update($id): void
    {
        if (!SupplierValidationService::validateId($id)) {
            $this->jsonResponse(['errors' => SupplierValidationService::getErrors()], Status::BAD_REQUEST->value);
            return;
        }

        if (!SupplierValidationService::validateSupplierExists($id)) {
            $this->jsonResponse(['errors' => SupplierValidationService::getErrors()], Status::NOT_FOUND->value);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $data['id'] = $id;

        if (!SupplierValidationService::validateRequiredFields($data, ['name'])) {
            $this->jsonResponse(['errors' => SupplierValidationService::getErrors()], Status::UNPROCESSABLE_ENTITY->value);
            return;
        }

        if (!SupplierValidationService::validate($data)) {
            $this->jsonResponse(['errors' => SupplierValidationService::getErrors()], Status::UNPROCESSABLE_ENTITY->value);
            return;
        }

        $supplier = Supplier::findById($id);
        $supplier->fill($data);
        if ($supplier->save()) {
            $this->jsonResponse(['message' => 'Supplier updated', 'data' => $supplier], Status::OK->value);
        } else {
            $this->jsonResponse(['message' => 'Failed to update supplier'], Status::INTERNAL_SERVER_ERROR->value);
        }
    }

    public function delete($id): void
    {
        if (!SupplierValidationService::validateId($id)) {
            $this->jsonResponse(['errors' => SupplierValidationService::getErrors()], Status::BAD_REQUEST->value);
            return;
        }

        if (!SupplierValidationService::validateSupplierExists($id)) {
            $this->jsonResponse(['errors' => SupplierValidationService::getErrors()], Status::NOT_FOUND->value);
            return;
        }

        $supplier = Supplier::findById($id);
        if ($supplier->delete()) {
            $this->jsonResponse(['message' => 'Supplier deleted'], Status::OK->value);
        } else {
            $this->jsonResponse(['message' => 'Failed to delete supplier'], Status::INTERNAL_SERVER_ERROR->value);
        }
    }
}
