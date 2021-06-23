@extends('layouts.app')


@section('content')
    <div class="d-flex justify-content-end">
        <a href="{{route('categories.create')}}" class="btn btn-success float-right mb-2">Add Category</a>
    </div>
    <div class="card card-default">
        <div class="card-header">Categories</div>
        <div class="card-body">
         @if ($categories->count()>0)
         <table class="table">
            <thead>
                <th>Name</th>
                <th>Posts count</th>
                <th></th>
            </thead>
            @if (session()->has('success'))
                <div class="alert alert-success">{{session()->get('success')}}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">{{session()->get('error')}}</div>
            @endif
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>
                            {{ $category->posts->count() }}
                        </td>
                        <td>
                            <a href="{{route('categories.edit', $category->id)}}" class="btn btn-info btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm"  onclick="handleDelete({{$category->id}})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteMadalLabel" aria-hidden="true" role="dialog">
            <div class="modal-dialog" role="document">
                <form action="" method="POST" id="deleteCategoryForm">
                    @csrf
                    @method('DELETE')
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteMadalLabel">Delete Category</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Are you shure yo want to delete category?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No, goback</button>
                  <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
              </div>
            </form>
            </div>
          </div>
    </div>
         @else
             <h3 class="text-center">No categories yet</h3>
         @endif
    </div>
@endsection
@section('scripts')
    <script>
        function handleDelete(id){
            var form = document.getElementById('deleteCategoryForm')
            form.action = '/categories/' + id
            $('#deleteModal').modal('show')
        }
    </script>
@endsection
