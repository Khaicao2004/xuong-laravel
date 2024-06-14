@extends('admin.layouts.master')

@section('title')
    Câp nhật danh mục sản phẩm: {{ $model->name }}
@endsection

@section('content')
<form action="{{route('admin.catalogues.update', $model->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Name :</label>
                <input type="text" class="form-control" id="name" 
                        value="{{$model->name}}"
                        placeholder="Enter name" name="name">
              </div> 
              <div class="mb-3">
                <label for="cover" class="form-label">File :</label>
                <input type="file" class="form-control" id="cover" name="cover">
                <img src="{{\Storage::url($model->cover)}}" alt="" width="50px">
              </div>
             
        </div>
        <div class="col-md-6">
            <div class="mb-3 form-check">
                <label class="form-check-label" for="is_active">
                    <input type="checkbox" class="form-check-input" value="1"  id="is_active" 
                        @if ($model->is_active) checked @endif
                         name="is_active">Is Active        
                </label>
              </div>
        </div>
    </div>
    
    
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection