@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{route('admin.posts.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <h1 class="mb-5 text-center">Add post</h1>
            <div class="form-group mb-3">
                <label for="cover">Image cover</label>
                <input type="file" name="image" id="cover" class="form-control-file @error('image') is-invalid @enderror" />

                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="title" class="form-label">Category</label>
                <select name="category_id" class="form-control @error('title') is-invalid @enderror" id="category_id">
                    <option {{(old('category_id')=="")?'selected':''}} value="">Nessuna categoria</option>
                    @foreach ($categories as $category)
                        <option {{(old('category_id')==$category->id)?'selected':''}} value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" max="255" value="{{old('title')}}">
                @error('title')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" value="{{old('content')}}"></textarea>
                @error('content')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <h5>Tag:</h5>
            <div class="card">
                @foreach ($tags as $tag)
                    <div class="form-check form-group ml-2">
                        <input {{(in_array($tag->id, old('tags', [])))?'checked': ''}} name="tags[]" class="form-check-input" type="checkbox" id="tag_{{$tag->id}}" value="{{$tag->id}}">
                        <label class="form-check-label" for="{{$tag->slug}}">{{$tag->name}} {{$tag->id}}</label>
                    </div>
                @endforeach
                @error('tags')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
