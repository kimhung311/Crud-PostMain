@extends('layouts.master')
@section('content')
 
   <form action="{{ route('category.update',$category->id) }}" method="post">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="my-input">Name</label>
            <input id="my-input" class="form-control" type="text" name="name" value={{ $category->name }}>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="my-input">Paren_id</label>
            <input id="my-input" class="form-control" type="text" name="paren_id" value={{ $category->paren_id }}>
            @error('paren_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" value="Update">ADD</button>
   </form>

@endsection