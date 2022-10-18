<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = $request->all();

        $newCategory = new Category();
        $newCategory->fill($data);

        $slug = $this->getSlug($newCategory->name);
        $newCategory->slug = $slug;

        $newCategory->save();

        return redirect()->route('admin.categories.index')->with('created', 'Creazione avvenuta con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = $request->all();

        if ($category->name !== $data['name']) {
            $data['slug'] = $this->getSlug($data['name']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('edited', 'Modifiche apportate correttamente');
    }


    protected function getSlug($title)
    {
        //**Crea uno slug univoco per ogni titolo */
        $slug = Str::slug($title, '-');
        $checkSlug = Category::where('slug', $slug)->first();
        $counter = 1;

        while($checkSlug) {
            $slug = Str::slug($title . '-' . $counter, '-');
            $counter++;
            $checkSlug = Category::where('slug', $slug)->first();
        }

        return $slug;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('cancelled', 'Eliminazione avvvenuta con successo');
    }
}
