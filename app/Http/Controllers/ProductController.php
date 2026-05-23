<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    // Show all products
   private function getCategories()
{
    return [
        ['id' => 1, 'name' => 'Education'],
        ['id' => 2, 'name' => 'Development'],
        ['id' => 3, 'name' => 'Design'],
        ['id' => 4, 'name' => 'Business'],
        ['id' => 5, 'name' => 'Marketing'],
        ['id' => 6, 'name' => 'Other'],
    ];
}

public function index(Request $request)
{
    $query = Product::query();

    // Search by name or description
    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    // Filter by category
    if ($request->has('category') && $request->category != 'all') {
        $query->where('category_id', $request->category);
    }

    // Sorting
    if ($request->has('sort')) {
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sales_count', 'desc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    $products = $query->paginate(12);
    $categories = $this->getCategories(); // ✅ fixed

    return view('products.index', compact('products', 'categories'));
}

public function create()
{
    $categories = $this->getCategories();
    return view('products.create', compact('categories'));
}

    // Store product
    public function store(Request $request)
{
    $categoriesMap = [
        1 => 'Education', 2 => 'Development', 3 => 'Design',
        4 => 'Business', 5 => 'Marketing', 6 => 'Other'
    ];

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'category' => 'required|integer',
        'in_stock' => 'required|boolean',
        'image' => 'nullable|image|max:2048',
        'tags' => 'nullable|string',
        'is_digital' => 'nullable|boolean',
    ]);

    $validated['category'] = $categoriesMap[$validated['category']] ?? 'Other';

if ($request->hasFile('image')) {
    // Store the file in /public/images and save only the filename
    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('images'), $filename);

    $validated['image'] = $filename; // ✅ only filename in DB
} elseif ($request->filled('image')) {
    // In case someone submits just a string (like laravel_course.jpg)
    $validated['image'] = basename($request->input('image'));
} else {
    $validated['image'] = null;
}



    $validated['is_digital'] = $request->has('is_digital') ? 1 : 0;

      $validated['user_id'] = Auth::id();

    Product::create($validated);

    return redirect()->route('products.index')->with('success', 'Product created successfully!');
}


 public function show($id)
{
    $product = Product::with('user')->findOrFail($id);
    return view('products.product_show', compact('product'));
}
public function search(Request $request)
{
    $query = Product::query();

    // Search by name or description
    if ($request->filled('search')) {
        $query->where('name', 'like', "%{$request->search}%")
              ->orWhere('description', 'like', "%{$request->search}%");
    }

    // Filter by category (name)
    if ($request->filled('category') && $request->category != 'all') {
        $categories = $this->getCategories();
        $catName = $categories[$request->category - 1]['name'] ?? null;
        if ($catName) {
            $query->where('category', $catName);
        }
    }

    // Sorting
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('sales_count', 'desc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }
    } else {
        $query->orderBy('created_at', 'desc'); // default
    }

    $products = $query->take(50)->get()->map(function($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'image' => $product->image,
            'category' => $product->category,
            'created_at' => $product->created_at,
            'seller' => $product->user->name ?? 'Seller',
        ];
    });

    return response()->json($products);
}



public function edit(Product $product)
{
    // Only allow owner to edit
    if ($product->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $categories = $this->getCategories();
    return view('products.edit', compact('product', 'categories'));
}

public function update(Request $request, Product $product)
{


    if ($product->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }


    $categoriesMap = [
    'Education' => 'Education',
    'Development' => 'Development',
    'Design' => 'Design',
    'Business' => 'Business',
    'Marketing' => 'Marketing',
    'Other' => 'Other'
];


    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string|max:255',
        'in_stock' => 'required|boolean',
        'image' => 'nullable|image|max:2048',
        'tags' => 'nullable|string',
        'is_digital' => 'nullable|boolean',
    ]);

    $validated['category'] = $categoriesMap[$validated['category']] ?? 'Other';

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename);
        $validated['image'] = $filename;
    }

    if ($request->has('remove_image')) {
    // Delete the old image file if exists
    if ($product->image && file_exists(public_path('images/' . $product->image))) {
        unlink(public_path('images/' . $product->image));
    }
    $product->image = null; // Clear DB field
}


    $validated['is_digital'] = $request->has('is_digital') ? 1 : 0;

    $product->update($validated);

    return redirect()->route('products.show', $product->id)
                     ->with('success', 'Product updated successfully!');
}


public function destroy(Product $product)
{
    // Optional: check if the authenticated user is the owner
     if ($product->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Delete image file if exists
    if ($product->image && file_exists(public_path('images/' . $product->image))) {
        unlink(public_path('images/' . $product->image));
    }

    $product->delete();

    return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
}


}
