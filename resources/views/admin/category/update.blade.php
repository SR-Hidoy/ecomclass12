@extends('layouts.dashboard_master')
@section('category')
  active
@endsection
@section('content')

  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">

      <a class="breadcrumb-item" href="{{ url('home')}}">Dashboard</a>
      <a class="breadcrumb-item" href="{{url('add/category')}}">Add Category</a>
      <span class="breadcrumb-item active">Update Category</span>

    </nav>

    <div class="sl-pagebody">

      <div class="row row-sm">
        <div class="col-md-4 m-auto">


          <div class="card">
            <div class="card-header">
              <h1>Update Category</h1>
            </div>
            <div class="card-body">

              {{-- @if (session('success_message'))
                <div class="alert alert-success">
                  {{session('success_message')}}
                </div>
              @endif --}}

              {{-- {{ print_r($errors->all()) }} --}}

              <form action="{{url('update/category/post')}}" method="post"  enctype="multipart/form-data">
                @csrf
                        <div class="form-group">
                          <label>Category Name</label>
                          <input type="hidden" name="category_id" value="{{$category_id}}">
                          <input type="text" class="form-control" name="category_name" value="{{ $category_name }}">
                        </div>

                          <div class="form-group">
                            <label> Current Category Photo</label>
                            <img class="form-control" src="{{ asset('uploads/category_photos')}}/{{ $category_photo }}" alt="">
                          </div>

                          <div class="form-group">
                            <label>New Category Photo</label>
                            <input type="file" class="form-control" name="new_category_photo" >
                          </div>

                          <div>
                          {{-- @error ('category_name')
                            <span class="text-danger">
                              {{$message}}
                            </span>
                          @enderror --}}
                        </div>


                        <button type="submit" class="btn btn-info">Update Category</button>
                      </form>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>




@endsection
