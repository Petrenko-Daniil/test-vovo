<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductsResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(ProductSearchRequest $request)
    {
        $filters = $request->validated();
        $perPage = $filters['per_page'] ?? 20;

        $foundIds = isset($filters['q']) && $filters['q'] !== null
            ? Product::search($filters['q'])->get()->pluck('id')->toArray()
            : null;

        $productsQuery = Product::query()
            ->when($foundIds !== null, fn($q) => $q->whereIn('id', $foundIds))
            ->when(isset($filters['category_id']), fn($q) => $q->where('category_id', $filters['category_id']))
            ->when(isset($filters['price_from']), fn($q) => $q->where('price', '>=', $filters['price_from']))
            ->when(isset($filters['price_to']), fn($q) => $q->where('price', '<=', $filters['price_to']))
            ->when(array_key_exists('in_stock', $filters), fn($q) => $q->where('in_stock', $filters['in_stock']))
            ->when(isset($filters['rating_from']), fn($q) => $q->where('rating', '>=', $filters['rating_from']));

        $productsQuery = match($filters['sort'] ?? 'newest') {
            'price_asc' => $productsQuery->orderBy('price', 'asc'),
            'price_desc' => $productsQuery->orderBy('price', 'desc'),
            'rating_desc' => $productsQuery->orderBy('rating', 'desc'),
            default => $productsQuery->orderBy('created_at', 'desc'),
        };

        $products = $productsQuery->paginate($perPage)->appends($filters);

        return ProductsResource::collection($products);
    }


    public function store(ProductRequest $request)
    {
        return new ProductsResource(Product::create($request->validated()));
    }

    public function show(Product $products)
    {
        return new ProductsResource($products);
    }

    public function update(ProductRequest $request, Product $products)
    {
        $products->update($request->validated());

        return new ProductsResource($products);
    }

    public function destroy(Product $products)
    {
        $products->delete();

        return response()->json();
    }
}
