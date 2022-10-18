@extends('layouts.app')

@section('content')

    <div class="container text-center">
        <div>
            <h1 class="mb-3">{{$category->name}}</h1>
        </div>

        <h4>
            <span class="font-weight-bold mb-3">Slug:</span>
            {{$category->slug}}
        </h4>

        @if (count($category->posts))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($category->posts as $post)
                    <tr>
                        <th scope="row">{{$post->id}}</th>
                        <td>{{$post->title}}</td>
                        <td>{{$post->slug}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <a href="{{route('admin.categories.index')}}" class="btn btn-primary mb-3">Back</a>
    </div>

   
    
@endsection