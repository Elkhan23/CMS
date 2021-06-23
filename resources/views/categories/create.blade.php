@extends('layouts.app')


@section('content')

    <div class="card card-default">
        <div class="card-header">
            {{ isset($category) ? 'Edit Category' : 'Create Category' }}
        </div>
        <div class="card-body">
            @include('partials.errors')
            @if (session()->has('error'))
                <div class="alert alert-danger">{{session()->get('error')}}</div>
            @endif
            <form action="{{ isset($category) ? route('categories.update', $category->id):route('categories.store') }}" method="POST">
                @csrf
                @if(isset($category))
                @method('PUT')
                @endif
                <div class="form-group">
                    <label for="name"></label>
                    <input type="text" id="name" class="form-control" name="name" value="{{ isset($category) ? $category->name : '' }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</button>
                </div>
            </form>
        </div>
    </div>


@endsection
