@extends('admin.layouts.main')
@section('title',"danh sach danh mục sản phẩm")
@section('css')
    <style>
         .card-header  {
            color: #4c4d5a;
            border-color: #dcdcdc;
            background: #f6f6f6;
            text-shadow: 0 -1px 0 rgb(50 50 50 / 0%);
        }
        .title-card-recusive{
            font-size: 13px;
            background: #ECF0F5;
        }
        .lb_list_category{
            font-size: 13px;
            margin-bottom: 0;
        }
        .fa-check-circle{
            color: #169F85;
            font-size: 18px;
        }
        .fa-check-circle{
            color: #169F85;
            font-size: 18px;
        }
        .fa-times-circle{
            color: #f23b3b;
           font-size: 18px;
        }
    </style>
@endsection
@section('content')
    @include('admin.partials.content-header',['name'=>"Danh mục nhân sự","key"=>"Danh sách danh mục"])

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
                <div class="d-flex justify-content-end">
                   <div class="text-right w-100">
                    <a href="{{route('admin.category.add',['parent_id'=>request()->parent_id??0])}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                   </div>
                </div>

                <div class="card card-outline card-info">
                    <div class="card-header pt-2 pb-2">
                        <div class="cart-title">
                            <i class="fas fa-list"></i> Danh mục
                        </div>
                    </div>
                </div>
                @if (isset($parentBr)&&$parentBr)
                <ol class="breadcrumb">
                  <li><a href="{{ route('admin.category.index',['parent_id'=>0]) }}">Root</a></li>

                  @foreach ($parentBr->breadcrumb as $item)
                   <li><a href="{{ route('admin.category.index',['parent_id'=>$item['id']]) }}">{{ $item['name'] }}</a></li>
                  @endforeach
                  <li><a href="{{ route('admin.category.index',['parent_id'=>$parentBr->id]) }}">{{ $parentBr->name }}</a></li>
                </ol>
                @endif

                <div class="card card-outline card-primary">
                    <div class="card-body table-responsive lb-list-category" style="padding: 0; font-size:13px;">
                        @include('admin.components.category', [
                            'data' => $data,
                            'routeNameEdit'=>'admin.category.edit',
                            'routeNameAdd'=>'admin.category.add',
                            'routeNameDelete'=>'admin.category.delete',
                            'table'=>'category',
                        ])
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {{$data->appends(request()->all())->links()}}
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

@endsection

@section('js')

@endsection
