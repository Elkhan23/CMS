@extends('layouts.app')


@section('content')

    <div class="card card-default">
        <div class="card-header">
            {{ isset($tag) ? 'Edit Tag' : 'Create Tag' }}
        </div>
        <div class="card-body">
            @if($errors->any())
            <div class="aler aler-danger">
                <ul class="list-group">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item text-danger">
                            {{$error}}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">{{session()->get('error')}}</div>
            @endif
            <form action="{{ isset($tag) ? route('tags.update', $tag->id):route('tags.store') }}" method="POST">
                @csrf
                @if(isset($tag))
                @method('PUT')
                @endif
                <div class="form-group">
                    <label for="name"></label>
                    <input type="text" id="name" class="form-control" name="name" value="{{ isset($tag) ? $tag->name : '' }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ isset($tag) ? 'Edit Tag' : 'Add Tag' }}</button>
                </div>
            </form>
        </div>
    </div>


@endsection
