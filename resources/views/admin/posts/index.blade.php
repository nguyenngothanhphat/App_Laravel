@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800 text-center">Welcome to Posts</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Owner</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @if ($posts)
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->category ? $post->category->name : "Uncategorized" }}</td>
                            <td><img height="50" src="{{ $post->photo ? $post->photo->path : "http://placehold.it/400x400"}}" alt=""></td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->content }}</td>
                            <td>{{ $post->created_at->diffForHumans() }}</td>
                            <td>{{ $post->updated_at->diffForHumans() }}</td>
                            <td><a href="">Edit</a></td>
                            <td><a href="">Delete</a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection