<?php

// app/Http/Controllers/PropertyController.php
namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'city'        => ['sometimes','string'],
            'status'      => ['sometimes','string'],
            'price_min'   => ['sometimes','numeric','min:0'],
            'price_max'   => ['sometimes','numeric','min:0'],
            'bed_min'     => ['sometimes','integer','min:0'],
            'bed_max'     => ['sometimes','integer','min:0'],
            'bath_min'    => ['sometimes','integer','min:0'],
            'bath_max'    => ['sometimes','integer','min:0'],
            'balcony'     => ['sometimes','boolean'],
            'garden'      => ['sometimes','boolean'],
            'q'           => ['sometimes','string'],
            'sort'        => ['sometimes','string'],
            'direction'   => ['sometimes','string','in:asc,desc'],
            'page'        => ['sometimes','integer','min:1'],
            'per_page'    => ['sometimes','integer','min:1','max:50'],
        ]);

        $query = Property::query();

        if (!empty($validated['city'])) {
            $query->where('city', $validated['city']);
        }
        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }
        if (isset($validated['price_min'])) {
            $query->where('price', '>=', $validated['price_min']);
        }
        if (isset($validated['price_max'])) {
            $query->where('price', '<=', $validated['price_max']);
        }
        if (isset($validated['bed_min'])) {
            $query->where('bedrooms', '>=', $validated['bed_min']);
        }
        if (isset($validated['bed_max'])) {
            $query->where('bedrooms', '<=', $validated['bed_max']);
        }
        if (isset($validated['bath_min'])) {
            $query->where('bathrooms', '>=', $validated['bath_min']);
        }
        if (isset($validated['bath_max'])) {
            $query->where('bathrooms', '<=', $validated['bath_max']);
        }
        if (array_key_exists('balcony', $validated)) {
            $query->where('balcony', (bool)$validated['balcony']);
        }
        if (array_key_exists('garden', $validated)) {
            $query->where('garden', (bool)$validated['garden']);
        }
        if (!empty($validated['q'])) {
            $q = $validated['q'];
            $query->where(function ($sub) use ($q) {
                $sub->where('address', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $allowedSorts = ['price','city','status','bedrooms','bathrooms','created_at','address'];
        $sort = $validated['sort'] ?? '';
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'address';
        }
        $dir = $validated['direction'] ?? 'asc';
        $query->orderBy($sort, $dir);

        $perPage   = $validated['per_page'] ?? 20;
        $paginator = $query->paginate($perPage)->appends($validated);

        return response()->json([
            'data' => $paginator->items(),
            'meta' => [
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'has_more'     => $paginator->hasMorePages(),
                'sort'         => $sort,
                'direction'    => $dir,
                'filters'      => [
                    'city'      => $validated['city']      ?? null,
                    'status'    => $validated['status']    ?? null,
                    'price_min' => $validated['price_min'] ?? null,
                    'price_max' => $validated['price_max'] ?? null,
                    'bed_min'   => $validated['bed_min']   ?? null,
                    'bed_max'   => $validated['bed_max']   ?? null,
                    'bath_min'  => $validated['bath_min']  ?? null,
                    'bath_max'  => $validated['bath_max']  ?? null,
                    'balcony'   => $validated['balcony']   ?? null,
                    'garden'    => $validated['garden']    ?? null,
                    'q'         => $validated['q']         ?? null,
                ],
            ],
        ]);
    }

    /**
     * @param Property $property
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Property $property)
    {
        return response()->json(['data' => $property]);
    }
}
