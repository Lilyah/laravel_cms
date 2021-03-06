@extends('layouts.app')

@section('content')


<div class="card card-default">

    <div class="card-header">

    {{ isset($post) ? 'Edit Post' : 'Create Post' }}

    </div>


    <div class="card-body">

        <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data"> <!-- enctype="multipart/form-data" allows submitting multimedia to the server -->
        
        <!-- Validate the request with @csrf -->
        @csrf 

        @if(isset($post))

        @method('PUT')

        @endif

        <div class="form-group">

            <label for="title">Title</label>

            <input type="text" class="form-control" name="title" id="title" value="{{ isset($post) ? $post->title : '' }}">

        </div>


        <div class="form-group">

            <label for="description">Description</label>

            <textarea name="description" id="description" cols="5" rows="5" class="form-control">{{ isset($post) ? $post->description : '' }}</textarea>

        </div>


        <div class="form-group">

            <label for="content">Content</label>

            <input id="content" type="hidden" name="content" value="{{ isset($post) ? $post->content : '' }}"> <!-- copied from https://github.com/basecamp/trix -->
            <trix-editor input="content"></trix-editor> <!-- copied from https://github.com/basecamp/trix -->

        </div>


        <div class="form-group">

            <label for="published_at">Published At</label>

            <input type="published_at" class="form-control" name="published_at" id="published_at" value="{{ isset($post) ? $post->published_at : '' }}">

        </div>

        @if(isset($post))       

            <div class="form-group">

                <img src="/storage/{{$post->image}}"  width="100%">

            </div>

        @endif

        <div class="form-group">

            <label for="image">Image</label>

            <input type="file" class="form-control" name="image" id="image" style="border: 0px">

        </div>

        <div class="form-group">

            <label for="category">Category</label>

            <select name="category" id="category" class="form-control">
                
            @foreach ($categories as $category)

                <option value="{{ $category->id }}"

                @if(isset($post))       

                    @if ($category->id == $post->category_id)

                    selected

                    @endif

                @endif

                >

                    {{ $category->name }}

                </option>

            @endforeach

            </select>

        </div>

        <div class="form-group">

            <button type="submit" class="btn btn-success">

                {{ isset($post) ? 'Update Post' : 'Create Post' }}

            </button>

        </div>


        </form>

    </div>

</div>

@endsection


@section('scripts')

<!-- Text editor for content field | Trix-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>

<!-- Date picker | Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

    flatpickr('#published_at', {
        enableTime: true,
        altInput: true,
        altFormat: "F j, Y H:i",
        dateFormat: "Y-m-d",
    });

</script>



@endsection


@section('css')

<!-- Text editor for content field | Trix-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css"> 

<!-- Date picker | Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


@endsection