@extends('layouts.master')
{{-- @extends('layouts.css') --}}


{{-- set page title --}}
@section('title', 'List Category')

{{-- set breadcrumbName --}}
@section('breadcrumbName', 'Category Management')

{{-- set breadcrumbMenu --}}
@section('breadcrumbMenu', 'List Category')

{{-- import file css (private) --}}
@push('css')
    <link rel="stylesheet" href="/css/categories/category-list.css">
@endpush

@section('content')
<br>
<br>
<br>
<br>
    <nav aria-label="breadcrumb"style=" text-align:center">
        <ol class="breadcrumb" >
            <li class="breadcrumb-item active" aria-current="page"><h1 >List Category</h1></li>
        </ol>
   </nav>
   {{-- show message --}}
 @if(session()->get('flash_success'))
    <div class="alert alert-success mb-0 rounded-0" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        @if(is_array(json_decode(session()->get('flash_success'), true)))
            {!! implode('', session()->get('flash_success')->all(':message<br/>')) !!}
        @else
            {!! session()->get('flash_success') !!}
        @endif
    </div>
    @endif
{{-- show error message --}}
@if(Session::has('error'))
    <p class="text-danger">{{ Session::get('error') }}</p>
@endif


    <a href="{{ route('category.create') }}" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="top">ADD</a>


    {{-- display list category table --}}
    <table id="category-list" class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>Stt</th>
                <th>Category Name</th>
                <th>Image</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($categories))
                @foreach ($categories as $key => $category)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                          
                            <img src="{{asset('storage/thumbnail/'.$category->thumbnail) }}" alt="{{ $category->name }}" class="img-fluid" style="width: 240px; height: auto;">
                         <td>
                        <a class="btn btn-primary"href="{{ route('category.edit', $category->id) }}"><i class="fas fa-edit"></i></a>
                        </td>
                    <td>
                        <form action="{{ route('category.destroy', $category->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure DELETE PRODUCT?')"><i class="fas fa-trash"></i></button>
                        </form>
                   </td>
                   {{-- <td> {{ asset('storage/file.txt') }} </td> --}}
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $categories->links() }}
@endsection