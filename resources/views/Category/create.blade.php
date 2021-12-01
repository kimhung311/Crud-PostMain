@section('content')
@extends('layouts.master')
      <form action="{{ route('category.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Category Name</label>
            <input type="text" name="name" class="form-control" class="@error('name') is-invalid @enderror" placeholder="category name">  
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for=""> Parent_id</label>
            <input type="text" name="paren_id" class="form-control" placeholder="category name">
            @error('paren_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
@endsection

