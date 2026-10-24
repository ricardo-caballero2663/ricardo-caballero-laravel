<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index', ['products' => Product::orderByDesc('id')->paginate(10)]);
    }

    public function create()
    {
        return view('product.create', ['product' => new Product]);
    }

    public function store(Request $request)
    {
        $product = Product::create($this->validated($request));

        return redirect()->route('products.index')->with('success', 'Producto creado correctamente: '.$product->description);
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request));

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
    }

    private function validated(Request $request): array
    {
        return $request->validate(['description' => ['required', 'string', 'max:255'], 'price' => ['required', 'numeric', 'min:0', 'max:999999.99', 'decimal:0,2'], 'stock' => ['required', 'integer', 'min:0', 'max:2147483647']]);
    }
}
