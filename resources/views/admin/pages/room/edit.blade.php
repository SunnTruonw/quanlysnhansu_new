@extends('admin.layouts.main');

@section('content')

@include('admin.partials.content-header',['name'=>"Danh mục","key"=>"Sửa danh mục"])

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has("alert"))
                <div class="alert alert-success">
                    {{session()->get("alert")}}
                </div>
                @elseif(session()->has('error'))
                <div class="alert alert-warning">
                    {{session("error")}}
                </div>
                @endif
                <form class="form-horizontal" action="{{route('admin.room.update',[$data->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header">
                                @foreach ($errors->all() as $message)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @endforeach
                             </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-tool p-3 text-right">
                                <button type="submit" class="btn btn-primary btn-lg">Chấp nhận</button>
                                <button type="reset" class="btn btn-danger btn-lg">Làm lại</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-8">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                   <h3 class="card-title">Thông tin phòng ban</h3>
                                </div>
                                <div class="card-body table-responsive p-3">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                          <a class="nav-link active" data-toggle="tab" href="#tong_quan">Tổng quan</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                            <!-- START Tổng Quan -->
                                            <div id="tong_quan" class="container tab-pane active "><br>

                                                <div class="tab-content">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="" class="col-sm-2">Tên phòng ban</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control nameChangeSlug
                                                                @error('name') is-invalid @enderror" id="name" value="{{ old('name') ?? $data->name }}" name="name" placeholder="Nhập tên phòng ban">
                                                                @error('name')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="" class="col-sm-2">Mô tả</label>
                                                            <div class="col-sm-10">
                                                                <textarea type="text" rows="4" class="form-control
                                                                @error('description') is-invalid @enderror" id="description" value="" placeholder="Nhập mô tả" name="description">{{ old('description') ?? $data->description }}</textarea>
                                                                @error('description')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        <!-- START Hình Ảnh -->
                                        <div id="hinh_anh" class="container tab-pane fade"><br>
                                            
                                        </div>
                                        <!-- END Hình Ảnh -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Thông tin khác</h3>
                                 </div>
                                 <div class="card-body table-responsive p-3">

                                    <div class="wrap-load-image mb-3">
                                        <div class="form-group">
                                            <label for="">Ảnh đại diện</label>
                                            <input type="file" class="form-control-file img-load-input border @error('avatar_path')
                                            is-invalid
                                            @enderror" id="" name="avatar_path">
                                            @error('avatar_path')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if($data->avatar_path)
                                            <img class="img-load border p-1 w-100" src="{{asset($data->avatar_path)}}" style="height: 100px;object-fit:cover; max-width: 100px;">
                                        @else
                                            <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 100px;object-fit:cover; max-width: 100px;">
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="">Số thứ tự</label>

                                        <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order') ?? $data->order }}" name="order" placeholder="Nhập số thứ tự">

                                        @error('order')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="">Trạng thái</label>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" value="1" name="active" @if(old('active')==='1' ||old('active')===null) {{'checked'}} @endif>Hiện
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="0" @if(old('active')==="0" ){{'checked'}} @endif name="active">Ẩn
                                            </label>
                                        </div>
                                        @error('active')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <hr>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')

@endsection