<?php

namespace App\Http\Controllers;

use App\Business_unit;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use File;
use Image;

class ProductController extends Controller
{
    public function index()
    {

        if (getUserRoleScope() == "Company") {
            $product = Product::whereHas('category', function ($q) {
                return $q->whereHas('business_unit', function ($q) {
                    return $q->where('company_id', userCompanyId());
                });
            });
        }

        if (getUserRoleScope() == "Business Unit") {
            $product = Product::whereHas('category', function ($q) {
                return $q->whereHas('business_unit', function ($q) {
                    return $q->where('id', userBusinessUnitId());
                });
            });
        }

        if (getUserRoleScope() == "Branch") {
            $product = Product::whereHas('category', function ($q) {
                return $q->whereHas('business_unit', function ($q) {
                    return $q->where('id', userBusinessUnitId());
                });
            });
        }

        $products = $product->with('category')->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $business_unit = Business_unit::where('company_id', userCompanyId());

        if (getUserRoleScope() == "Business Unit") {
            $business_unit->where('id', userBusinessUnitId());
        }

        if (getUserRoleScope() == "Branch") {
            $business_unit->where('id', userBusinessUnitId());
        }

        $business_units = $business_unit->orderBy('business_unit_name', 'ASC')->get();

        return response()->json([
            'data' => $business_units
        ]);
    }

    public function category(Request $request)
    {
        $categories = Category::where('business_unit_id', $request->id)->orderBy('category_name', 'ASC')->get();

        return response()->json([
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        //validasi data
        $this->validate($request, [
            'product_sku' => 'required|string|max:10|unique:products',
            'product_name' => 'required|string|max:100',
            'product_description' => 'nullable|string|max:100',
            'product_cogs' => 'nullable|integer|lt:product_price',
            'product_stock' => 'required|integer',
            'product_price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'product_photo' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        try {
            //default $photo = null
            $product_photo = null;
            //jika terdapat file (Foto / Gambar) yang dikirim
            if ($request->hasFile('product_photo')) {
                //maka menjalankan method saveFile()
                $product_photo = $this->saveFile($request->product_name, $request->file('product_photo'));
            }

            //Simpan data ke dalam table products
            $product = Product::firstOrCreate([
                'product_sku' => $request->product_sku,
                'product_name' => $request->product_name,
                'product_description' => $request->product_description,
                'product_cogs' => $request->product_cogs,
                'product_stock' => $request->product_stock,
                'product_price' => $request->product_price,
                'category_id' => $request->category_id,
                'product_photo' => $product_photo
            ]);

            //jika berhasil direct ke produk.index
            return redirect()->back()->with(['success' => $product->product_name . ' Created']);
        } catch (\Exception $e) {
            //jika gagal, kembali ke halaman sebelumnya kemudian tampilkan error
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        //query select berdasarkan id
        $products = Product::findOrFail($id);

        // Get business units data
        $business_unit = Business_unit::where('company_id', userCompanyId());

        if (getUserRoleScope() == "Business Unit") {
            $business_unit->where('id', userBusinessUnitId());
        }

        if (getUserRoleScope() == "Branch") {
            $business_unit->where('id', userBusinessUnitId());
        }

        $business_units = $business_unit->orderBy('business_unit_name', 'ASC')->get();

        // Variable dibawah digunakan sebagai pembanding untuk memunculkan class 'selected'
        $current_business_unit = Business_unit::whereHas('categories', function ($q) use ($id) {
            return $q->whereHas('products', function ($q) use ($id) {
                return $q->where('id', $id);
            });
        })->get()->first();

        // Get branches data by current business unit
        $categories = Category::where('business_unit_id', $current_business_unit->id)->get();
        // Variable dibawah digunakan sebagai pembanding untuk memunculkan class 'selected'
        $current_product_categories = Category::whereHas('products', function ($q) use ($id) {
            return $q->where('id', $id);
        })->get()->first();

        return response()->json([
            'data' => $products,
            'business_units' => $business_units,
            'current_business_unit' => $current_business_unit,
            'categories' => $categories,
            'current_product_categories' => $current_product_categories
        ]);
    }

    public function update(Request $request, $id)
    {
        //validasi
        $this->validate($request, [
            'product_sku' => 'required|string|max:10|exists:products,product_sku',
            'product_name' => 'required|string|max:100',
            'product_description' => 'nullable|string|max:100',
            'product_cogs' => 'nullable|integer|lt:product_price',
            'product_stock' => 'required|integer',
            'product_price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'product_photo' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        try {
            //query select berdasarkan id
            $product = Product::findOrFail($id);
            $product_photo = $product->product_photo;


            //cek jika ada file yang dikirim dari form
            if ($request->hasFile('product_photo')) {
                //cek, jika photo tidak kosong maka file yang ada di folder uploads/product akan dihapus
                !empty($product_photo) ? File::delete(public_path('uploads/product/' . $product_photo)) : null;
                //uploading file dengan menggunakan method saveFile() yg telah dibuat sebelumnya
                $product_photo = $this->saveFile($request->product_name, $request->file('product_photo'));
            }


            //perbaharui data di database
            $product->update([
                'product_name' => $request->product_name,
                'product_description' => $request->product_description,
                'product_cogs' => $request->product_cogs,
                'product_stock' => $request->product_stock,
                'product_price' => $request->product_price,
                'category_id' => $request->category_id,
                'product_photo' => $product_photo
            ]);


            return redirect(route('product.index'))->with(['success' => '<strong>' . $product->product_name . '</strong>  Updated']);
        } catch (\Exception $e) {
            return redirect(route('product.index'))->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        //query select berdasarkan id
        $products = Product::findOrFail($id);
        //mengecek, jika field photo tidak null / kosong
        if (!empty($products->product_photo)) {
            //file akan dihapus dari folder uploads/produk
            File::delete(public_path('uploads/product/' . $products->product_photo));
        }
        //hapus data dari table
        $products->delete();
        return redirect()->back()->with(['success' => '<strong>' . $products->product_name . '</strong> Deleted']);
    }

    private function saveFile($name, $photo)
    {
        //set nama file adalah gabungan antara nama produk dan time(). Ekstensi gambar tetap dipertahankan
        $images = str_slug($name) . time() . '.' . $photo->getClientOriginalExtension();
        //set path untuk menyimpan gambar
        $path = public_path('uploads/product');

        if (!File::isDirectory($path)) {
            //maka folder tersebut dibuat
            File::makeDirectory($path, 0777, true, true);
        }

        //simpan gambar yang diuplaod ke folrder uploads/produk
        Image::make($photo)->save($path . '/' . $images);
        //mengembalikan nama file yang ditampung divariable $images
        return $images;
    }
}
