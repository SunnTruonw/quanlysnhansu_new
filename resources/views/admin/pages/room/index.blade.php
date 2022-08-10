@extends('admin.layouts.main');

@section('content')

@include('admin.partials.content-header',['name'=>"Danh sách nhân viên","key"=>"Tất cả danh sách"])

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
                <a href="{{route('admin.room.add')}}" class="btn btn-info btn-md mb-2">+ Thêm mới</a>
              </div>

               <div class="card card-outline card-primary">
                  <div class="card-header">
                      <div class="card-tools w-100">
                          <form action="{{ route('admin.room.index') }}" method="GET">
                              <div class="row">
                                  <div class="col-md-10">
                                      <div class="row">
                                          <div class="form-group col-md-3 mb-0">
                                              <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="Từ khóa">
                                              <div id="keyword_feedback" class="invalid-feedback">

                                              </div>
                                          </div>
                                          {{-- <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                              <select id="order" name="order_with" class="form-control">
                                                  <option value="">-- Sắp xếp theo --</option>
                                                  <option value="dateASC" {{ $order_with=='dateASC'? 'selected':'' }}>Ngày tạo tăng dần</option>
                                                  <option value="dateDESC" {{ $order_with=='dateDESC'? 'selected':'' }}>Ngày tạo giảm dần</option>
                                                  <option value="viewASC" {{ $order_with=='viewASC'? 'selected':'' }}>Lượt xem tăng dần</option>
                                                  <option value="viewDESC" {{ $order_with=='viewDESC'? 'selected':'' }}>Lượt xem giảm dần</option>
                                              </select>
                                          </div>
                                          <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                              <select id="" name="fill_action" class="form-control">
                                                  <option value="">-- Lọc --</option>
                                                  <option value="hot" {{ $fill_action=='hot'? 'selected':'' }}>Dịch vụ hot</option>
                                                  <option value="no_hot" {{ $fill_action=='no_hot'? 'selected':'' }}>Dịch vụ không hot</option>
                                                  <option value="active" {{ $fill_action=='active'? 'selected':'' }}>Dịch vụ hiển thị</option>
                                                  <option value="no_active" {{ $fill_action=='no_active'? 'selected':'' }}>Dịch vụ bị ẩn</option>
                                              </select>
                                          </div>
                                          <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                              <select id="categoryProduct" name="category" class="form-control">
                                                  <option value="">-- Tất cả danh mục --</option>
                                                  {!!$option!!}
                                              </select>
                                          </div> --}}
                                      </div>
                                  </div>

                                  <div class="col-md-1 mb-0">
                                      <button type="submit" class="btn btn-success w-100">Tìm</button>
                                  </div>
                                  <div class="col-md-1 mb-0">
                                      <a  class="btn btn-danger w-100" href="{{ route('admin.room.index') }}">Làm mới</a>
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
                                  <th>Tên phòng ban</th>
                                  <th class="white-space-nowrap">Hình ảnh</th>
                                  <th class="white-space-nowrap">Mô tả</th>
                                  <th class="white-space-nowrap">Active</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($data as $item)
                              <tr>
                                  <td>{{$loop->index}}</td>
                                  <td>{{$item->name}}</td>
                                    <td>
                                        <img src="{{$item->avatar_path?asset($item->avatar_path): $shareFrontend['noImage']}}"
                                        alt="{{$item->name}}" style="width:80px;">
                                    </td>
                                    <td>
                                        {{$item->description}}
                                    </td>

                                    <td class="wrap-load-active">
                                        <a  class="btn btn-sm {{$item->active==1?'btn-success':'btn-warning'}} lb-active" style="width:50px;">{{$item->active==1?'Hiện':'Ẩn'}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.room.edit',['id'=>$item->id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                        <a data-url="{{route('admin.room.delete',['id'=>$item->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
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