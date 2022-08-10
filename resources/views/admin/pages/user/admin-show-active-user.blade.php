@extends('admin.layouts.main');

@section('content')
@include('admin.partials.content-header',['name'=>"Danh sách tài khoản","key"=>"Tất cả danh sách"])

<style>
    ul{
        list-style: none;
        margin: 0;
        padding: 0;
    }
    ul li{
        font-size: 17px;
        padding: 5px 0;
    }
</style>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              @if(session("alert"))
              <div class="alert alert-success">
                  {{session("alert")}}
              </div>
              @elseif(session('error'))
              <div class="alert alert-warning">
                  {{session("error")}}
              </div>
              @endif
              <div class="d-flex justify-content-between ">
                <a href="{{route('admin.user.add')}}" class="btn btn-info btn-md mb-2">+ Thêm mới</a>
              </div>

               <div class="card card-outline card-primary">
                  <div class="card-header">
                      <div class="card-tools w-100">
                          <form action="{{ route('admin.active-user.index') }}" method="GET">
                              <div class="row">
                                  <div class="col-md-10">
                                      <div class="row">
                                          <div class="form-group col-md-2 mb-0">
                                              <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="Từ khóa">
                                          </div>

                                            <div class="form-group col-md-2 mb-0">
                                                <input value="{{ $start_date }}" name="start_date" type="date" class="form-control">
                                            </div>

                                            <div class="form-group col-md-2 mb-0">
                                                <input value="{{ $end_date }}" name="end_date" type="date" class="form-control">
                                            </div>

                                            <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                <select name="city_id" id="city" class="form-control @error('city_id') is-invalid   @enderror" data-url="{{ route('ajax.address.districts') }}" >
                                                    <option value="">Chọn tỉnh/Thành phố</option>
                                                    @foreach ($dataCity as $city)
                                                        <option {{$city_id == $city->id ? 'selected' : ''}} value="{{$city->id}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                <select name="district_id" id="district" class="form-control  @error('district_id') is-invalid   @enderror"   >
                                                    <option value="">Chọn quận/huyện</option>
                                                    @if (isset($nameDistrict) && $nameDistrict)
                                                    <option selected>{{$nameDistrict}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                      </div>
                                  </div>

                                  <div class="col-md-1 mb-0">
                                      <button type="submit" class="btn btn-success w-100">Tìm</button>
                                  </div>
                                  <div class="col-md-1 mb-0">
                                      <a  class="btn btn-danger w-100" href="{{ route('admin.active-user.index') }}">Làm mới</a>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
                  <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                      <div class="count">
                          Tổng số bản ghi
                           <strong>{{  $data->count() }}</strong> / {{ $totalCategory }}
                       </div>
                    </div>
                  <div class="card-body table-responsive p-0 lb-list-category">
                      <table class="table table-head-fixed" style="font-size: 13px;">
                          <thead>
                              <tr>
                                  <th>STT</th>
                                  <th>Tài khoản</th>
                                  <th>Tên user</th>
                                  <th>Phone</th>
                                  <th>Chức vụ</th>
                                  <th class="white-space-nowrap">Active</th>
                                  {{-- <th class="white-space-nowrap">Danh mục</th> --}}
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($data as $item)
                                  {{-- {{dd($item->category)}} --}}
                              <tr>
                                  <td>{{$loop->index}}</td>
                                  <td>{{$item->email}}</td>
                                  <td>{{$item->name}}</td>
                                  <td>{{$item->phone}}</td>
                                  <td>{{$item->role}}</td>
                                  <td class="wrap-load-role" data-url="{{ route('admin.user.load.role',['id'=>$item->id]) }}">
                                        @include('admin.components.load-change-role',['data'=>$item,'type'=>'nhân viên'])
                                    </td>
                                    <td class="wrap-load-active" data-url="{{ route('admin.user.load.active',['id'=>$item->id]) }}">
                                        @include('admin.components.load-change-active',['data'=>$item,'type'=>'nhân viên'])
                                    </td>
                                    <td>
                                        <a href="{{route('admin.user.edit',['id'=>$item->id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                        <a data-url="{{route('admin.user.delete',['id'=>$item->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                    </td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <div class="col-md-12">
              {{$data->appends(request()->input())->links()}}
          </div>
      </div>
    </div>
  </div>
  


@endsection

@section('js')

@endsection