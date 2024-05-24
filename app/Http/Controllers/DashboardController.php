<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Exports\ProductExportWithStyle;
use App\Models\Product;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    // Products
    public function products()
    {
        $products = Product::all();
        return view('dashboard.products.index', compact('products'));
    }

    // add product
    public function addProduct()
    {
        return view('dashboard.products.add');
    }

    // store product
    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required|string',
            'berat' => 'required|integer',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'kondisi' => 'required|in:Bekas,Baru',
            'deskripsi' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.products.add')
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move('storage/products', $fileName);

        Product::create([
            'user_id' => Auth::user()->id,
            'image' => '/storage/products/' . $fileName,
            'name' => $request->nama,
            'weight' => $request->berat,
            'price' => $request->harga,
            'condition' => $request->kondisi,
            'stock' => $request->stok,
            'description' => $request->deskripsi,
        ]);

        return redirect()->route('dashboard.products')->with('success', 'Product added successfully');

        // advance III
        
    }

    // edit product
    public function editProduct($id)
    {
        $product = Product::find($id);
        return view('dashboard.products.edit', compact('product'));
    }

    // update product
    public function updateProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required|string',
            'berat' => 'required|integer',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'kondisi' => 'required|in:Bekas,Baru',
            'deskripsi' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.products.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::find($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('storage/products', $fileName);

            $imagePath = public_path($product->image);
            if (file_exists($imagePath))
                unlink($imagePath);

            $product->image = '/storage/products/' . $fileName;
        }

        $product->name = $request->nama;
        $product->weight = $request->berat;
        $product->price = $request->harga;
        $product->condition = $request->kondisi;
        $product->stock = $request->stok;
        $product->description = $request->deskripsi;
        $product->save();

        return redirect()->route('dashboard.products')->with('success', 'Product updated successfully');
    }

    // delete product
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();

        // delete image
        $imagePath = public_path($product->image);
        if (file_exists($imagePath))
            unlink($imagePath);

        return redirect()->route('dashboard.products')->with('success', 'Product deleted successfully');
    }

    public function exportProduct(Request $request)
    {
        return Excel::download(new ProductExportWithStyle($request), 'List Product With Style.xlsx');
    }

    // Users
    public function users()
    {
        $users = User::all();
        return view('dashboard.users.index', compact('users'));
    }

    // add user
    public function addUser()
    {
        return view('dashboard.users.add');
    }

    // store user
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:superadmin,user',
            'gender' => 'required|in:male,female',
            'age' => 'required|integer',
            'birth' => 'required|date',
            'address' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.users.add')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'age' => $request->age,
            'birth' => $request->birth,
            'address' => $request->address,
        ]);

        $user->assignRole($request->role);

        if ($user) {
            return redirect()->route('dashboard.users')->with('success', 'User added successfully');
        } else {
            return redirect()->route('dashboard.users.add')->with('error', 'Failed to add user');
        }
    }

    // edit user
    public function editUser($id)
    {
        $user = User::find($id);
        $user->role = $user->roles->first()->name;
        return view('dashboard.users.edit', compact('user'));
    }

    // update user
    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:superadmin,user',
            'gender' => 'required|in:male,female',
            'age' => 'required|integer',
            'birth' => 'required|date',
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.users.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password)
            $user->password = Hash::make($request->password);

        $user->gender = $request->gender;
        $user->age = $request->age;
        $user->birth = $request->birth;
        $user->address = $request->address;
        $user->save();

        $user->syncRoles([$request->role]);

        return redirect()->route('dashboard.users')->with('success', 'User updated successfully');
    }

    // delete user
    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user->id == Auth::user()->id)
            return redirect()->route('dashboard.users')->with('error', 'You cannot delete your own account');

        $user->delete();

        // detech role
        $user->syncRoles([]);

        return redirect()->route('dashboard.users')->with('success', 'User deleted successfully');
    }
}