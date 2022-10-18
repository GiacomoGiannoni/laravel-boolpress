<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
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

        $newTag = new Tag();
        $newTag->fill($data);

        $slug = $this->getSlug($newTag->name);
        $newTag->slug = $slug;

        $newTag->save();

        return redirect()->route('admin.tags.index')->with('created', 'Creazione avvenuta con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = $request->all();

        if ($tag->name !== $data['name']) {
            $data['slug'] = $this->getSlug($data['name']);
        }

        $tag->update($data);

        return redirect()->route('admin.tags.index')->with('edited', 'Modifiche apportate correttamente');
    }


    protected function getSlug($title)
    {
        //**Crea uno slug univoco per ogni titolo */
        $slug = Str::slug($title, '-');
        $checkSlug = Tag::where('slug', $slug)->first();
        $counter = 1;

        while($checkSlug) {
            $slug = Str::slug($title . '-' . $counter, '-');
            $counter++;
            $checkSlug = Tag::where('slug', $slug)->first();
        }

        return $slug;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->posts()->detach();
        $tag->delete();

        return redirect()->route('admin.categories.index')->with('cancelled', 'Eliminazione avvvenuta con successo');
    }
}
