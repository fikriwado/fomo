<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                foreach ($this->input('items', []) as $index => $item) {
                    if (! isset($item['product_id']) || ! is_numeric($item['product_id'])) {
                        continue;
                    }

                    $exists = Product::query()->whereKey($item['product_id'])->exists();

                    if (! $exists) {
                        $validator->errors()->add(
                            "items.$index.product_id",
                            "Product with ID {$item['product_id']} does not exist."
                        );
                    }
                }
            },
        ];
    }
}
