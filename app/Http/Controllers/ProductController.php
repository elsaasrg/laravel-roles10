<?php
 namespace App\Http\Controllers;
 use App\Models\Product;
 use App\Http\Requests\StoreProductRequest;
 use App\Http\Requests\UpdateProductRequest;
 use Illuminate\View\View;
 use Illuminate\Http\RedirectResponse;
 class ProductController extends Controller
 {
 /**
 *InstantiateanewProductControllerinstance.
 */
 public function __construct()
 {
 $this->middleware('auth');
 $this->middleware('permission:create-mahasiswa|edit-mahasiswa|delete-mahasiswa', ['only' => ['index','show']]);
 $this->middleware('permission:create-mahasiswa', ['only' => ['create','store']]);
 $this->middleware('permission:edit-mahasiswa', ['only' => ['edit','update']]);
 $this->middleware('permission:delete-mahasiswa', ['only' => ['destroy']]);
 }
 /**
 *Displayalistingoftheresource.
 */
 public function index(): View
 {
 return view('products.index', [
 'products' => Product::latest()->paginate(3)
 ]);
 }
 /**
 *Showtheformforcreatinganewresource.
 */
 public function create(): View
 {
 return view('products.create');
 }
 /**
 *Storeanewlycreatedresourceinstorage.
 */
 public function store(StoreProductRequest $request): RedirectResponse
 {
 Product::create($request->all());
 return redirect()->route('products.index')->withSuccess('New product is added successfully.');
 }
 /**
 *Displaythespecifiedresource.
 */
 public function show(Product $product): View
 {
 return view('products.show', [
 'product' => $product
 ]);
 }
 /**
 *Showtheformforeditingthespecifiedresource.
 */
 public function edit(Product $product): View
 {
 return view('products.edit', [
 'product' => $product
 ]);
 }
 /**
 *Updatethespecifiedresourceinstorage.
 */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {

    $product->update($request->all());
    return redirect()->back()->withSuccess('Product is updated successfully.');
    }
    /**
    *Removethespecifiedresourcefromstorage.
    */
    public function destroy(Product $product): RedirectResponse
    {
    $product->delete();
    return redirect()->route('products.index')->withSuccess('Product is deleted successfully.');
    }
    
 }