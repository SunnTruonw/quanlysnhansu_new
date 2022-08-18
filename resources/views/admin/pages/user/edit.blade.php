@extends('admin.layouts.main');

@section('content')

@include('admin.partials.content-header',['name'=>"Nhân viên","key"=>"Sửa nhân viên"])
@php
    try {
        $data->email = \Crypt::decrypt($data->email);
        $data->phone = \Crypt::decrypt($data->phone);
    } catch(\RuntimeException $e) {
        $data->email;
        $data->phone;
    }
@endphp
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
                <div class="log"></div>
                <form class="form-horizontal" action="{{route('admin.user.update',[$data->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header">
                                @foreach ($errors->all() as $message)
                                <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                @endforeach
                             </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-tool p-3 text-right">
                                <button type="submit" @if($authCheck->id == $data->id || $authCheck->role == 'admin')  @else disabled  @endif class="btn btn-primary btn-sm">Chấp nhận</button>
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
                                                                <input type="text" class="form-control nameChangeSlug
                                                                @error('name') is-invalid @enderror" id="name" value="{{ old('name') ?? $data->name }}" name="name" placeholder="Nhập tên nhân viên">
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
                                                                <input type="number" class="form-control
                                                                @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone') ?? $data->phone }}" name="phone" placeholder="Nhập sô điện thoại">
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
                                                                {{-- {!! $cities !!} --}}
                                                                @foreach ($dataCity as $city)
                                                                    <option {{$data->city_id == $city->id ? 'selected' : ''}} value="{{$city->id}}">{{$city->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('city_id')
                                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-2">Quận/huyện <strong>*</strong></label>
                                                        <div class="col-sm-10">
                                                            <select name="district_id" id="district" class="form-control    @error('district_id') is-invalid   @enderror" >
                                                                <option value="">Chọn quận/huyện</option>
                                                                <option value="{{$data->district_id}}" selected>{{$data->district->name ?? ''}}</option>
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
                                                                @error('address') is-invalid @enderror" id="address" value="{{ old('address') ?? $data->address }}" name="address" placeholder="Nhập địa chỉ">
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
                                                                @error('description') is-invalid @enderror" id="description" value="" placeholder="Nhập mô tả" name="description">{{ old('description') ?? $data->description }}</textarea>
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
                                                                @error('content') is-invalid @enderror" id="content" value="" placeholder="Nhập nội dung" name="content">{{ old('content') ?? $data->content }}</textarea>
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
                                                        @if($data->avatar_path)
                                                            <img class="img-load border p-1 w-100" src="{{asset($data->avatar_path)}}" style="height: 200px;object-fit:cover; max-width: 260px;">
                                                        @else
                                                            <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 200px;object-fit:cover; max-width: 260px;">
                                                        @endif
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
                                                        @if($data->image_path)
                                                            <img class="img-load border p-1 w-100" src="{{asset($data->image_path)}}" style="height: 200px;object-fit:cover; max-width: 260px;">
                                                        @else
                                                            <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 200px;object-fit:cover; max-width: 260px;">
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                        <!-- START Hình Ảnh -->
                                        <div id="hinh_anh" class="container tab-pane fade"><br>
                                            <div class="wrap-load-images mb-3">
                                                <div class="form-group">
                                                    <label for="">File tài liệu</label>
                                                    <input value="{{ $data->file }}" type="file" class="form-control-file img-load-input border @error('file')
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
                                                        <option value="{{ $attr->id }}"
                                                            @if (old('category'))
                                                                @if ($attr->id==old('category')[$key])
                                                                    selected
                                                                @else
                                                                    {{ $data->categories()->get()->pluck('id')->contains($attr->id)?'selected':"" }}
                                                                @endif
                                                            @else
                                                            {{ $data->categories()->get()->pluck('id')->contains($attr->id)?'selected':"" }}
                                                            @endif
                                                        >
                                                            {{ $attr->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category.'.$key)
                                                <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
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
                                                    <option {{ $data->room_id == $room->id ? 'selected':"" }} value="{{$room->id}}">{{$room->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('room_id')
                                        <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3">Giới tính</label>

                                        <select class="form-control" name="sex" id="sex">
                                            <option value="">--Giới tính--</option>
                                            <option value="1" {{$data->sex == 1 ? 'selected' : ''}}>Nam</option>
                                            <option value="0" {{$data->sex == 0 ? 'selected' : ''}}>Nữ</option>
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
                                                @error('date_working') is-invalid @enderror" id="date_working" value="{{ old('date_working') ?? $data->date_working }}" name="date_working" placeholder="Nhập tên nhân viên">
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
                                                @error('date_off') is-invalid @enderror" id="date_off" value="{{ old('date_off') ?? $data->date_off }}" name="date_off" placeholder="Nhập tên nhân viên">
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
                                                @error('wage') is-invalid @enderror" id="wage" value="{{ old('wage') ?? $data->wage }}" name="wage" placeholder="Nhập mức lương">
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
                                                <label for="" class="col-sm-2">Use Email</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control
                                                    @error('email') is-invalid @enderror" id="email" value="{{ old('email') ?? $data->email }}" name="email" placeholder="Nhập email">
                                                    @error('email')
                                                        <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <div class="text-right w-100">
                                            <button type="button" class="btn btn-info mb-2 btnChangePassword" data-id="{{ $data->id }}" data-target="#changePassword"
                                                data-text="url"
                                                data-action="{{ route('admin.changePassword.update', ['id' => $data->id]) }}" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fas fa-exchange-alt"></i> Đổi mật khẩu
                                            </button>
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


<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST" id="changePasswordAction" class="form-submit">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteItemText">Thay đổi Mật khẩu</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <div class="row">
                                <label for="old_password" class="col-md-3">Mật khẩu cũ</label>
                                <div class="col-md-9">
                                    <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" placeholder="Nhập mật khẩu cũ">
                                    @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-err" id="errorOldPassword" style="display: none;">
                                        <div class="alert-danger-cus alert-des ">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                            <span class="text-old_password-error">Mật khẩu > 8 ký tự</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="new_password" class="col-md-3">Mật khẩu</label>
                                <div class="col-md-9">
                                    <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="Nhập mật khẩu">
                                    @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-err" id="errorNewPassword" style="display: none;">
                                        <div class="alert-danger-cus alert-des ">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                            <span class="text-new_password-error">Mật khẩu > 8 ký tự</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label for="confirm_password" class="col-md-3">Nhập lại mật khẩu</label>
                                <div class="col-md-9">
                                    <input id="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="Nhập lại mật khẩu">
                                    @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-err" id="errorConfirmPassword" style="display: none;">
                                        <div class="alert-danger-cus alert-des ">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                            <span class="text-confirm_password-error">Mật khẩu > 8 ký tự</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center col-12">
                            <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                            <button class="btn btn-danger btn-sm btn-submit" type="submit">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
<script>
    $('.btnChangePassword').click(function(e) {
        $('#changePasswordAction').attr('action', $(this).attr('data-action'));
    });

    $(document).on('keyup', '#new_password', function(){
        if($(this).val().length > 0){
            if($(this).val().length < 8){
                $('.text-new_password-error').text('Mật khẩu > 8 ký tự');
                $('#errorNewPassword').show();
                $('#errorNewPassword').parent().children().addClass('is-invalid');
            }else{
                $('#errorNewPassword').hide();
                $('#errorNewPassword').parent().children().removeClass('is-invalid');
            }
        }else{
            $('.text-new_password-error').text('Thông tin bắt buộc');
            $('#errorNewPassword').show();
            $('#errorNewPassword').parent().children().addClass('is-invalid');
        }
    });

    $(document).on('keyup', '#confirm_password', function(){
        if($(this).val().length > 0){
            if($(this).val().length < 8){

                $('.text-confirm_password-error').text('Mật khẩu > 8 ký tự');
                $('#errorConfirmPassword').show();
                $('#errorConfirmPassword').parent().children().addClass('is-invalid');
            }else{
                $('#errorConfirmPassword').hide();
                $('#errorConfirmPassword').parent().children().removeClass('is-invalid');
            }
        }else{
            $('.text-confirm_password-error').text('Thông tin bắt buộc');
            $('#errorConfirmPassword').show();
            $('#errorConfirmPassword').parent().children().addClass('is-invalid');
        }
    });

    $(document).on('keyup', '#old_password', function(){
        if($(this).val().length > 0){

            if($(this).val().length < 8){
                $('.text-old_password-error').text('Mật khẩu > 8 ký tự');
                $('#errorOldPassword').show();
                $('#errorOldPassword').parent().children().addClass('is-invalid');
            }else{
                $('#errorOldPassword').hide();
                $('#errorOldPassword').parent().children().removeClass('is-invalid');
            }
        }else{
            $('.text-old_password-error').text('Thông tin bắt buộc');
            $('#errorOldPassword').show();
            $('#errorOldPassword').parent().children().addClass('is-invalid');
        }
    });

    function validateCreateRegister (new_password,confirmPassword,old_password)
	{

        if(old_password == '' || old_password.length < 8){
            $('#errorOldPassword').show();
            var errorOldPassword = false;
        }else{
            if(old_password.length < 8){
                $('.text-old_password-error').text('Mật khẩu > 8 ký tự');
                $('#errorOldPassword').show();
                var errorOldPassword = false;
            }
            else{
                $('#errorOldPassword').hide();
            }
        }


		if(new_password == '' || new_password.length < 8){
            $('#errorNewPassword').show();
            var errorNewPassword = false;
        }else{
            if(new_password.length < 8){
                $('.text-new_password-error').text('Mật khẩu > 8 ký tự');
                $('#errorNewPassword').show();
                var errorNewPassword = false;
            }
            else if(new_password != confirmPassword){
                var errorNewPassword = false;
            }
            else{
                $('#errorNewPassword').hide();
            }
        }



		if(confirmPassword == '' || confirmPassword.length < 8){

            $('#errorConfirmPassword').show();
            $('.text-confirm_password-error').text('Mật khẩu > 8 ký tự');
            var errorConfirmPassword = false;
        }else if(new_password != confirmPassword){
            $('#errorConfirmPassword').show();
            $('.text-confirm_password-error').text('Mật khẩu không khớp với mật khẩu trên');
            var errorConfirmPassword = false;
            }
        else{
            $('#errorConfirmPassword').hide();
        }

		if(errorNewPassword == false || errorConfirmPassword ==  false || errorOldPassword == false){
			return false;
		}
	}


    $("#changePasswordAction").on("submit", function () {

        let new_password = $('#new_password').val();
        let confirmPassword = $('#confirm_password').val();
        let old_password = $('#old_password').val();

        // console.log(new_password,confirmPassword,old_password);
        var validate = validateCreateRegister(new_password, confirmPassword, old_password);

        if(validate == false){
            return false;
        }


    });

</script>
@endsection
