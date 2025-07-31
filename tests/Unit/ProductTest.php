<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Repositories\ProductRepository;
use PHPUnit\Framework\Attributes\Test;

class ProductTest extends TestCase
{
    
    #[Test]
    public function it_creates_a_product_successfully(): void
    {
        $data = [
            'name' => 'Test Product',
            'price' => 999.99,
            'barcode' => '1234567890123',
            'category_id' => null,
        ];

        $product = Product::query()->create($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Test Product', $product->name);
        $this->assertEquals(999.99, $product->price);
        $this->assertEquals('1234567890123', $product->barcode);
    }
    
    #[Test]
    public function it_can_update_a_product_successfully(): void
    {
        $product = Product::query()->latest()->first();
        $product->price = 150.00;
        $product->name = 'Updated Product';
        $product->save();

        $this->assertEquals('Updated Product', $product->fresh()->name);
        $this->assertEquals(150.00, $product->fresh()->price);
    }
}
