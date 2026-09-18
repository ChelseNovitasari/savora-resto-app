<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('back.menu.index', [
            'menus' => Menu::with('category')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('back.menu.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Data
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|min:3|unique:menus,name',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak valid.',
            'name.required'        => 'Nama menu wajib diisi.',
            'name.unique'          => 'Nama menu sudah ada.',
            'price.required'       => 'Harga wajib diisi.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'image.image'          => 'File harus berupa gambar.',
            'image.max'            => 'Ukuran foto maksimal 2MB.',
        ]);

        // Inisialisasi variabel gambar (default null)
        $imagePath = null;

        // 2. Process Upload Foto (jika ada)
        if ($request->hasFile('image')) {
    $file = $request->file('image');
    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
    // Simpan ke storage/app/public/back/menu-images/
    $file->storeAs('back/menu-images', $fileName, 'public');

    $imagePath = $fileName;
}

        // 3. Simpan ke Database
        Menu::create([
            'category_id'  => $request->category_id,
            'name'         => $request->name,
            'slug'         => Str::slug($request->name),
            'price'        => $request->price,
            'description'  => strip_tags($request->description),
            'image'        => $imagePath,
            'is_available' => $request->has('is_available') ? true : false,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::with('category')->findOrFail($id);
        return view('back.menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('back.menu.edit', [
            'menu'       => $menu,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        // 1. Validasi Input Data
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|min:3|unique:menus,name,' . $menu->id,
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Tampung nama gambar lama dari database
        $fileName = $menu->image;

        // 2. Jika User Mengunggah Foto Baru
        if ($request->hasFile('image')) {
            // Hapus foto lama
        if ($menu->image && Storage::disk('public')->exists('back/menu-images/' . $menu->image)) {
        Storage::disk('public')->delete('back/menu-images/' . $menu->image);
    }

    $file = $request->file('image');
    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('back/menu-images', $fileName, 'public');

    $fileName = $fileName;
}

        // 3. Update Data di Database
        $menu->update([
            'category_id'  => $request->category_id,
            'name'         => $request->name,
            'slug'         => Str::slug($request->name),
            'price'        => $request->price,
            'description'  => strip_tags($request->description),
            'image'        => $fileName,
            'is_available' => $request->has('is_available') ? true : false,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
 * Remove the specified resource from storage.
 */
public function destroy(Menu $menu)
{
    // 1. Hapus file gambar dari storage jika ada
    if ($menu->image && Storage::disk('public')->exists('back/menu-images/' . $menu->image)) {
        Storage::disk('public')->delete('back/menu-images/' . $menu->image);
    }

    // 2. Hapus data dari database
    $menu->delete();

    // 3. Mengembalikan Response JSON (Sesuai dengan AJAX di JavaScript)
    return response()->json([
        'message' => 'Menu berhasil dihapus!'
    ]);
}

public function toggleStatus(Menu $menu)
{
    // 1. Balik status ketersediaan
    $menu->update([
        'is_available' => !$menu->is_available
    ]);

    // 2. Kirim respon balik ke JavaScript
    return response()->json([
        'success' => true,
        'message' => 'Status menu berhasil diperbarui!',
        'is_available' => $menu->is_available
    ]);
}
}
