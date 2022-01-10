@extends('layouts.master')

{{-- set page title --}}
@section('title', 'Create Category')

{{-- set breadcrumbName --}}
@section('breadcrumbName', 'Category Management')

{{-- set breadcrumbMenu --}}
@section('breadcrumbMenu', 'Create Category')

{{-- import file css (private) --}}
@push('css')
    <link rel="stylesheet" href="/css/categories/category-create.css">
@endpush

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">List Category</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
  </nav>
  <br>
    <h3 style="text-align: center">Tạo sản phẩm</h3>
  <br>


    
    <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="">Nhập/thêm danh sách sản phẩm:</label>
            <input class="form-control" type="text" name="category_name" placeholder="category name" style="width:450px"><br>
  <input class="form-control" type="text" name="paren_id" placeholder="category name" style="width:450px" value="1"><br>

            <label for="">Ảnh:</label><br>
            <input  type="file" name="thumbnail" placeholder="category name">
        </div>

       

        <div class="form-group">
            <a href="{{ route('category.index') }}" class="btn btn-secondary">List Category</a>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
@endsection