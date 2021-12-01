@extends('layouts.master')
@section('content')

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
    <table class="table table-light table-hover table-borderless w">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $key => $category)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $category->name}}</td>
                <td>{{ $category->paren_id}}</td>
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
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p class="text-center"> 
        {{ $categories->links() }}
    </p>
  
@endsection



@push('js')

@endpush
