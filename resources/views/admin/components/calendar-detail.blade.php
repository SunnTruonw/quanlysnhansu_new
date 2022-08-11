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
                        <div class="col-md-12">
                            <div class="card-header">
                                @foreach ($errors->all() as $message)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @endforeach
                             </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Chấm công</h3>
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


                                        <div class="row" style="float: right;">
                                            <button type="submit" class="btn btn-primary btn-sm">Chấp nhận</button>
                                            <button type="reset" class="btn btn-danger btn-sm">Làm lại</button>
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
@if(isset($data) && $data)
<table class="table table-bordered">
    <thead>
       <tr>
          <th style="width: 10px">#</th>
          <th>Mã</th>
          <th>Họ tên</th>
          <th>Email</th>
          <th>Chấm công</th>
       </tr>
    </thead>
    <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        {{$item->user_code}}
                    </td>
                    <td>
                        {{$item->name}}
                    </td>
                    <td>
                        {{$item->email}}
                    </td>
                    <td class="wrap-load-calendar" data-url="{{ route('admin.user.load.calendar',['id'=>$item->id]) }}">
                        @include('admin.components.load-change-calendar',['data'=>$item,'type'=>'nhân viên'])
                    </td>
                </tr>
            @endforeach
    </tbody>
 </table>
@endif
