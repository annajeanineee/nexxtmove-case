<?php

declare(strict_types=1);

namespace App\Http\Requests\Listing;

use App\Enums\Listing\Status;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array|string>
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
            'filter.status' => ['sometimes', 'string', Rule::enum(Status::class)],
            'filter.price_min' => ['sometimes', 'integer'],
            'filter.price_max' => ['sometimes', 'integer'],
        ];
    }

    public function getPerPage(): int
    {
        return (int) $this->validated('per_page', Config::integer('pagination.per_page'));
    }
}
