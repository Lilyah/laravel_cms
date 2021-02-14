@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('categories.create') }}" class="btn btn-success">Add Category</a> <!-- the href is the NAME of the route for creating cats from php artisan route:list -->
</div>

<div class="card card-default">
    <div class="card-header">Categories</div>  

    <div class="card-body">

    @if($categories->count() > 0)

        <table class="table">

            <thead>

                <th>Name</th>

                <th>Posts count</th>

                <th></th>

                <th></th>


            </thead>

            <tbody>

                @foreach($categories as $category)

                <tr>

                    <td>
                    
                        {{ $category->name }}
                    
                    </td>

                    <td>

                      {{ $category->posts->count() }} <!--'posts' NOT 'posts()'!!! it's comming from the method post() in Post.php -->

                    </td>

                    <td>

                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info float-right btn-sm">Edit</a>

                    </td>

                    <td>

                        <button class="btn btn-danger float-right btn-sm" onclick="handleDelete({{ $category->id }})">Delete</button>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    @else

    <h3 class="text-center">No Categories yet</h3>

    @endif

        <!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">

  <form action="" method="POST" id="deleteCategoryForm">  

  @csrf
  
  @method('DELETE')

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-center text-bold">
          Are you sure you want to dlete this category?
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Go back</button>
        <button type="submit" class="btn btn-danger">Yes, Delete</button>
      </div>
    </div>

  </form>
  </div>
</div>

    </div>
</div>

@endsection


@section('scripts')

<script>
function handleDelete(id) {
    var form = document.getElementById('deleteCategoryForm')
    form.action = '/categories/' + id
    $('#deleteModal').modal('show')
}
</script>


@endsection