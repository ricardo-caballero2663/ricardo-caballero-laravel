<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_products(): void
    {
        $this->get('/products')->assertRedirect('/login');
    }

    public function test_full_product_lifecycle(): void
    {
        $this->actingAs(User::factory()->create());
        $this->post('/products', ['description' => 'Monitor', 'price' => '120.25', 'stock' => 5])->assertRedirect('/products');
        $p = Product::firstOrFail();
        $this->assertSame('120.25', $p->price);
        $this->get('/products')->assertOk()->assertSee('Monitor');
        $this->get('/products/'.$p->id)->assertOk()->assertSee('Monitor');
        $this->put('/products/'.$p->id, ['description' => 'Monitor actualizado', 'price' => '125.50', 'stock' => 8])->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['id' => $p->id, 'description' => 'Monitor actualizado', 'stock' => 8]);
        $this->delete('/products/'.$p->id)->assertRedirect('/products');
        $this->assertDatabaseMissing('products', ['id' => $p->id]);
    }

    public function test_negative_price_and_fractional_stock_are_rejected(): void
    {
        $this->actingAs(User::factory()->create())->post('/products', ['description' => 'Error', 'price' => -1, 'stock' => 1.5])->assertSessionHasErrors(['price', 'stock']);
        $this->assertDatabaseCount('products', 0);
    }

    public function test_zero_values_are_allowed(): void
    {
        $this->actingAs(User::factory()->create())->post('/products', ['description' => 'Muestra', 'price' => 0, 'stock' => 0])->assertRedirect('/products');
        $this->assertDatabaseCount('products', 1);
    }

    public function test_missing_product_returns_404(): void
    {
        $this->actingAs(User::factory()->create())->get('/products/9999')->assertNotFound();
    }
}
