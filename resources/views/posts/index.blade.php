@extends('layouts.app')

@section('content')


<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('posts.create') }}" class="btn btn-success">Add Post</a> <!-- the href is the NAME of the route for creating cats from php artisan route:list -->
</div>

<div class="card card-default">

    <div class="card-header">Posts</div>  

    <div class="card-body">

    @if($posts->count() > 0)

        <table class="table">

            <thead>

                <th>Image</th>

                <th>Title</th>

                <th>Category</th>

                <th></th>

                <th></th>


            </thead>

            <tbody>

                @foreach($posts as $post)
                <tr>
                
                    <td>

                    <img src="storage/{{$post->image}}"  width="100">

                    </td>

                    <td>

                    {{ $post->title }}

                    </td>

                    <td>

                        <a href="{{ route('categories.edit', $post->category->id) }}">

                            {{ $post->category->name }}

                        </a>

                    </td>

                    <td>

                    @if($post->trashed())

                    <!-- 'restore-posts' is comming from the NAME inf the controller, whitch is
                    Route::put('restore-post/{post}', 'PostsController@restore')->name('restore-posts'); // PUT, because we are updating the post
                    -->
                    <form action="{{ route('restore-posts', $post->id) }}" method="POST"> 

                    @csrf 

                    @method('PUT')

                        <button type="submit" class="btn btn-info float-right btn-sm mx-1">Restore</button>

                    </form>

                    @else

                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info float-right btn-sm mx-1">Edit</a>

                    @endif


                    </td>

                    <td>

                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">

                            @csrf

                            @method('DELETE')

                            <button type="submit" class="btn btn-danger float-right btn-sm">
                            
                            {{ $post->trashed() ? 'Delete' : 'Trash' }}
                            
                            </button>

                        </form>
                    
                    </td>

                </tr>
                @endforeach

            </tbody>
    
        </table>

    @else

        <h3 class="text-center">No Posts yet</h3>

    @endif

    </div>

</div>


@endsection