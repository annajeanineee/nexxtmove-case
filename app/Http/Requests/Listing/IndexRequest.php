<?php

declare(strict_types=1);

namespace App\Http\Requests\Listing;

use App\Enums\Listing\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'include' => ['sometimes', 'string'],
            'sort' => ['sometimes', 'string'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'filter' => ['sometimes', 'array'],
            'filter.city' => ['sometimes', 'string'],
            'filter.status' => ['sometimes', 'string', Rule::in(array_map(static fn (\App\Enums\Listing\Status $c) => $c->value, Status::cases()))],
            'filter.price_min' => ['sometimes', 'integer'],
            'filter.price_max' => ['sometimes', 'integer'],
        ];
    }
}
