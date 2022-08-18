@extends('admin.layouts.main');

@section('content')
    @include('admin.partials.content-header', ['name' => 'Danh sách', 'key' => 'Tất cả danh sách'])


    <style>
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        ul li {
            font-size: 17px;
            padding: 5px 0;
        }
    </style>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if (session('alert'))
                        <div class="alert alert-success">
                            {{ session('alert') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-warning">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="d-flex justify-content-between ">
                        <a href="{{ route('api.users.add') }}" class="btn btn-info btn-md mb-2">+ Thêm mới</a>
                    </div>

                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-tools w-100">
                                {{-- <form action="{{ route('admin.user.index') }}" method="GET">
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

                                            <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                <select name="fill_action" class="form-control">
                                                    <option value="">-- Trạng thái --</option>
                                                    <option value="active" {{ $fill_action == 'active'? 'selected':'' }}>Đang làm</option>
                                                    <option value="no_active" {{ $fill_action =='no_active'? 'selected':'' }}>Nghỉ việc</option>
                                                </select>
                                            </div>
                                      </div>
                                  </div>

                                  <div class="col-md-1 mb-0">
                                      <button type="submit" class="btn btn-success w-100">Tìm</button>
                                  </div>
                                  <div class="col-md-1 mb-0">
                                      <a  class="btn btn-danger w-100" href="{{ route('admin.user.index') }}">Làm mới</a>
                                  </div>
                              </div>
                          </form> --}}
                            </div>
                        </div>
                        <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                            <div class="count">
                                Tổng số bản
                                <strong>{{ $meta['per_page'] }}</strong> / {{ $meta['total'] }}
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0 lb-list-category">
                            <table class="table table-head-fixed" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Họ và tên</th>
                                        <th>Điện thoại</th>
                                        <th>Email</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->index }}</td>
                                            <td>{{ $item['full_name'] }}</td>
                                            <td>{{ $item['phone'] }}</td>
                                            <td>{{ $item['email'] }}</td>
                                            <td>
                                                <a href="{{route('api.users.edit',['id'=>$item['id']])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                <a data-url="{{route('api.users.delete',['id'=>$item['id']])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 leading-5">
                                    Hiển thị từ
                                    <span class="font-medium">{{$currentPage ?? 1}}</span>
                                    đến
                                    <span class="font-medium">{{$meta['per_page']}}</span>
                                    của
                                    <span class="font-medium">{{$meta['total']}}</span>
                                    bản ghi
                                </p>
                            </div>

                            <div>
                                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                    <a href="http://127.0.0.1:8000/api/api-call?page={{$currentPage - 1}}"
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                        aria-label="Go to page 2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>

                                    @for ($i = 1; $i <= $meta['last_page']; $i++)
                                        @if($previouPage <= $i && $i <= $nextPage)
                                            <a href="http://127.0.0.1:8000/api/api-call?page={{ $i }}"
                                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                                aria-label="Go to page 2">
                                                {{ $i }}
                                            </a>
                                        @elseif($i < $meta['last_page'])

                                        @else
                                            <a class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                                aria-label="Go to page 2">
                                                ...
                                            </a>
                                            <a href="http://127.0.0.1:8000/api/api-call?page={{ $i }}"
                                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                                aria-label="Go to page 2">
                                                {{ $i }}
                                            </a>
                                        @endif
                                    @endfor

                                    <a href="http://127.0.0.1:8000/api/api-call?page={{$currentPage +1 }}"
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                        aria-label="Go to page 2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
