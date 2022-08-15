@extends('admin.layouts.main');

@section('content')

@include('admin.partials.content-header',['name'=>"Nhân viên","key"=>"Thêm nhân viên"])

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
                <form class="form-horizontal" action="{{route('admin.user.store')}}" method="POST" enctype="multipart/form-data">
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
                                <button type="submit" class="btn btn-primary btn-sm">Chấp nhận</button>
                                <button type="reset" class="btn btn-danger btn-sm">Làm lại</button>
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
                                          <a class="nav-link" data-toggle="tab" href="#hinh_anh">File tài liệu</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <!-- START Tổng Quan -->
                                        <div id="tong_quan" class="container tab-pane active "><br>

                                            <div class="tab-content">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="" class="col-sm-2">Tên nhân viên</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control
                                                            @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" name="name" placeholder="Nhập tên nhân viên">
                                                            @error('name')
                                                                <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="" class="col-sm-2">Số điện thoại</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control
                                                            @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone') }}" name="phone" placeholder="Nhập sô điện thoại">
                                                            @error('phone')
                                                                <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2">Tỉnh/TP <strong>*</strong></label>
                                                    <div class="col-sm-10">
                                                        <select name="city_id" id="city" class="form-control @error('city_id') is-invalid   @enderror" data-url="{{ route('ajax.address.districts') }}">
                                                            <option value="">Chọn tỉnh/Thành phố</option>
                                                            {!! $cities !!}
                                                        </select>
                                                        @error('city_id')
                                                            <div class="invalid-feedback"><strong>{{ $message }}</strong>S</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-2">Quận/huyện <strong>*</strong></label>
                                                    <div class="col-sm-10">
                                                        <select name="district_id" id="district" class="form-control    @error('district_id') is-invalid   @enderror">
                                                            <option value="">Chọn quận/huyện</option>
                                                        </select>
                                                        @error('district_id')
                                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="" class="col-sm-2">Địa chỉ</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control
                                                            @error('address') is-invalid @enderror" id="address" value="{{ old('address') }}" name="address" placeholder="Nhập địa chỉ">
                                                            @error('address')
                                                                <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
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
                                                                <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
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
                                                                <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="wrap-load-image mb-3">
                                                    <div class="form-group">
                                                        <label for="">Ảnh đại diện</label>
                                                        <input type="file" class="form-control-file img-load-input border @error('avatar_path')
                                                        is-invalid
                                                        @enderror" id="" name="avatar_path">
                                                        @error('avatar_path')
                                                            <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                        @enderror
                                                    </div>
                                                    <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 100px;object-fit:cover; max-width: 100px;">
                                                </div>

                                                <div class="wrap-load-image mb-3">
                                                    <div class="form-group">
                                                        <label for="">Ảnh căn cước</label>
                                                        <input type="file" class="form-control-file img-load-input border @error('image_path')
                                                        is-invalid
                                                        @enderror" id="" name="image_path">
                                                        @error('image_path')
                                                        <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                        @enderror
                                                    </div>
                                                    <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 100px;object-fit:cover; max-width: 100px;">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- END Tổng Quan -->

                                        <!-- START Hình Ảnh -->
                                        <div id="hinh_anh" class="container tab-pane fade"><br>
                                            <div class="wrap-load-image mb-3">
                                                <div class="form-group">
                                                    <label for="">File tài liệu</label>
                                                    <input type="file" class="form-control-file img-load-input border @error('file')
                                                    is-invalid
                                                    @enderror" id="" name="file">
                                                    @error('file')
                                                    <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                    @enderror
                                                </div>
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

                                    @if(isset($categoriesM) && $categoriesM)
                                        @foreach ($categoriesM as $key=> $category)
                                            <div class="form-group">
                                                <label class="control-label" for="">{{ $category->name }}</label>
                                                <select class="form-control"  name="category[]" >
                                                    <option value="0">--Chọn--</option>
                                                    @foreach ($category->childs()->orderby('order')->get() as $k=> $attr)
                                                        <option value="{{ $attr->id }}" @if (old('category')) {{ $attr->id== old('category')[$key]?'selected':"" }} @endif>{{ $attr->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category.'.$key)
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="form-group">
                                        <label class="control-label" for="">Chọn phòng ban</label>
                                        <select class="form-control custom-select select-2-init" name="room_id">
                                            <option value="">--Chọn phòng ban--</option>
                                            @if(isset($rooms) && $rooms)
                                                @foreach ($rooms as $room)
                                                    <option @if (old('room_id')) {{ old('room_id')?'selected':"" }} @endif value="{{$room->id}}">{{$room->name}}</option>
                                                @endforeach
                                            @endif
                                                {!!$option!!}
                                        </select>
                                        @error('room_id')
                                            <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label" for="">Giới tính</label>
                                        <select class="form-control"   name="sex" id="sex">
                                            <option value="">--Giới tính--</option>
                                            <option @if (old('sex')) {{ old('sex')?'selected':"" }} @endif value="1">Nam</option>
                                            <option @if (old('sex')) {{ old('sex')?'selected':"" }} @endif value="0">Nữ</option>
                                        </select>
                                        @error('sex')
                                            <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-sm-3">Ngày vào làm</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control
                                                @error('date_working') is-invalid @enderror" id="date_working" value="{{ old('date_working') }}" name="date_working" placeholder="Nhập ngày vào làm">
                                                @error('date_working')
                                                    <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-sm-3">Ngày nghỉ việc</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control
                                                @error('date_off') is-invalid @enderror" id="date_off" value="{{ old('date_off') }}" name="date_off" placeholder="Nhập ngày nghỉ việc">
                                                @error('date_off')
                                                    <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label for="" class="col-sm-3">Lương</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control
                                                @error('wage') is-invalid @enderror" id="wage" value="{{ old('wage') }}" name="wage" placeholder="Nhập mức lương">
                                                @error('wage')
                                                    <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="">Trạng thái</label>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" value="1" name="active" @if(old('active')==='1' ||old('active')===null) {{'checked'}} @endif>Đang làm
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="0" @if(old('active')==="0" ){{'checked'}} @endif name="active">Nghỉ việc
                                            </label>
                                        </div>
                                        @error('active')
                                        <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>

                                    <hr>
                                 </div>


                            </div>

                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Tạo tài khoản</h3>
                                </div>
                                <div class="card-body table-responsive p-3">
                                    <div class="item-price-default">

                                        <div class="form-group">
                                            <div class="row">
                                                <label for="" class="col-sm-3">Use Email</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control
                                                    @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" name="email" placeholder="Nhập email">
                                                    @error('email')
                                                        <div class="invalid-feedback d-block"><strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label for="password" class="col-md-3">Mật khẩu</label>
                                                <div class="col-md-9">
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Nhập mật khẩu">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label for="confirm-password" class="col-md-3">Nhập lại mật khẩu</label>
                                                <div class="col-md-9">
                                                    <input id="confirm-password" type="password" class="form-control @error('confirm-password') is-invalid @enderror" name="confirm-password" placeholder="Nhập lại mật khẩu" >
                                                    @error('confirm-password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="">Chức vụ</label>
                                            <select class="form-control" name="role">
                                                <option value="user" selected>Nhân viên</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>

                                    </div>

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
