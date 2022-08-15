@extends('admin.layouts.main');

@section('content')

@include('admin.partials.content-header',['name'=>"Danh mục","key"=>"Thêm danh mục"])

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
                <form class="form-horizontal" action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
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
                                   <h3 class="card-title">Thông tin nhân viên</h3>
                                </div>
                                <div class="card-body table-responsive p-3">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                          <a class="nav-link active" data-toggle="tab" href="#tong_quan">Tổng quan</a>
                                        </li>
                                        <li class="nav-item">
                                          <a class="nav-link" data-toggle="tab" href="#hinh_anh">Hình ảnh</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <!-- START Tổng Quan -->
                                        <div id="tong_quan" class="container tab-pane active "><br>

                                            <div class="tab-content">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="" class="col-sm-2">Tên danh mục</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control nameChangeSlug
                                                            @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" name="name" placeholder="Nhập tên danh mục">
                                                            @error('name')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="" class="col-sm-2">Đường dẫn</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control resultSlug
                                                            @error('slug') is-invalid @enderror" id="slug" value="{{ old('slug') }}" name="slug" placeholder="Nhập đường dẫn">
                                                            @error('slug')
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
                                                            @error('description') is-invalid @enderror" id="description" value="" placeholder="Nhập mô tả" name="description">{{ old('description') }}</textarea>
                                                            @error('description')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="" class="col-sm-2">Nội dung</label>
                                                        <div class="col-sm-10">
                                                            <textarea type="text" rows="4" class="form-control
                                                            @error('content') is-invalid @enderror" id="content" value="" placeholder="Nhập nội dung" name="content">{{ old('content') }}</textarea>
                                                            @error('content')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- END Tổng Quan -->

                                        <!-- START Hình Ảnh -->
                                        <div id="hinh_anh" class="container tab-pane fade"><br>
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
                                                <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 200px;object-fit:cover; max-width: 260px;">
                                            </div>
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

                                    <div class="form-group">
                                        <select class="form-control custom-select select-2-init @error('parent_id')
                                        is-invalid
                                        @enderror" name="parent_id">
                                            <option value="0">--- Chọn danh mục cha ---</option>

                                            @if (old('parent_id'))
                                                {!! \App\Models\Category::getHtmlOptionAddWithParent(old('parent_id')) !!}
                                            @else
                                                {!!$option!!}
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="">Số thứ tự</label>

                                        <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order') }}" name="order" placeholder="Nhập số thứ tự">

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
