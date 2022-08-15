<section style="background-color: #eee;">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center" style="display: flex;
                    align-items: center;justify-content: center;
                    flex-direction: column;">
                        <img src="{{$data->avatar_path?asset($data->avatar_path): $shareFrontend['noImage']}}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;" />
                        <h5 class="my-3">{{$data->name}}</h5>
                        {!!$data->description!!}
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Mã nhân viên</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$data->user_code}}</p>
                            </div>
                        </div>
                        <hr />
                        <div class="row">

                            <div class="col-sm-3">
                                <p class="mb-0">Họ và tên</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$data->name}}</p>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$data->email}}</p>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Số điện thoại</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{$data->phone}}</p>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Địa chỉ</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $data->address }} ,{{ $data->district->name }}, {{ $data->city->name }}</p>
                            </div>
                        </div>

                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Mức lương</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ number_format($data->wage) }} VNĐ</p>
                            </div>
                        </div>

                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Chức danh</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $data->role }}</p>
                            </div>
                        </div>

                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Phòng ban</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $data->room->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
