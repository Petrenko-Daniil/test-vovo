<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     title="Product",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="iPhone 15"),
 *     @OA\Property(property="price", type="number", format="float", example=999.99),
 *     @OA\Property(property="in_stock", type="boolean", example=true),
 *     @OA\Property(property="rating", type="number", format="float", example=4.5),
 *     @OA\Property(property="category_id", type="integer", example=1),
 *     @OA\Property(
 *         property="category",
 *         ref="#/components/schemas/Category"
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2026-02-04T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2026-02-04T12:00:00Z")
 * )
 */
class Product extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'price',
        'in_stock',
        'rating',
        'category_id'
    ];

    public function searchableAs(): string
    {
        return 'products_index';
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function scoutSettings(): array
    {
        return [
            'sortableAttributes' => ['price', 'rating', 'created_at'],
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
