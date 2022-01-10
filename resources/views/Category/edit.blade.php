@extends('layouts.master')



{{-- import file css (private) --}}
@push('css')
    <link rel="stylesheet" href="/css/categories/category-edit.css">
@endpush

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Chỉnh sửa sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
    <h4>Edit Category</h4>
    <form action="{{ route('admin.category.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="">Tên  danh mục sản phẩm</label><br>
            <input type="text" name="category_name" value="{{ $category->name }}" class="form-control" style="width:450px">
            @error('category_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror <br>

            <label for="">Ảnh</label> <br>
            <img src="/{{$category->thumbnail }}" width=150px alt=""><br>
            <input type="file" name="thumbnail" value="{{($category->thumbnail) }}">
                @error('thumbnail')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
        </div>

        


        <div class="form-group">
            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">List Category</a>
            <input type="submit" name="submit" value="Update" class="btn btn-primary">
        </div>
    </form>
@endsection