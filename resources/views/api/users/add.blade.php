@extends('admin.layouts.main');

@section('content')

@include('admin.partials.content-header',['name'=>"User Api","key"=>"Thêm user"])

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
                <form class="form-horizontal" action="{{route('api.users.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header">
                                @if (isset($errors) && $errors)
                                    @foreach ($errors->all() as $message)
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @endforeach
                                @endif
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

                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                   <h3 class="card-title">Thông tin</h3>
                                </div>
                                <div class="card-body table-responsive p-3">
                                    <div class="tab-content">
                                        <!-- START Tổng Quan -->
                                        <div id="tong_quan" class="container tab-pane active "><br>
                                            <div class="tab-content">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="" class="col-sm-2">Họ và tên</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control
                                                            @error('full_name') is-invalid @enderror" id="full_name" value="{{ old('full_name') }}" name="full_name" placeholder="Nhập họ và tên">
                                                            @error('full_name')
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
                                                            @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone') }}" name="phone" placeholder="Nhập sô điện thoại">
                                                            @error('phone')
                                                                <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="" class="col-sm-2">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control
                                                            @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" name="email" placeholder="Nhập email">
                                                            @error('email')
                                                                <div class="invalid-feedback d-block"><strong>{{ $message }}</strong></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- END Tổng Quan -->
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
