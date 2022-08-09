@php
    $folder .="<i class='fas fa-long-arrow-alt-right'></i>";
@endphp
<li class=" lb_item_delete  border-bottom">
    <div class="d-flex flex-wrap ">
        <div class="box-left lb_list_content_recusive">
            <div class="d-flex">
                <div class="col-sm-1 pt-2 pb-2 white-space-nowrap folder">
                      {!! $folder !!}
                      @if ($childValue->childs->count())
                             <i class="fas fa-folder"></i>
                      @else
                            <i class="fas fa-file-alt"></i>
                      @endif
                </div>
                <div class="col-sm-6 pt-2 pb-2 name">
                    <a href="{{ route(Route::currentRouteName(),['parent_id'=>$childValue->id]) }}">{{ $childValue->name }}</a>
                </div>
                <div class="col-sm-3 pt-2 pb-2 slug text-center">
                    {{$childValue->order}}
                    {{-- <input data-url="@if (isset($routeNameOrder)) {{ route($routeNameOrder,['table'=>$table,'id'=>$childValue->id]) }} @endif" class="lb-order text-center"  type="number" min="0" value="{{ $childValue->order?$childValue->order:0 }}" style="width:50px" /> --}}
                </div>
                <div class="col-sm-2 pt-2 pb-2 parent text-center">
                    {{-- @include('admin.components.breadcrumbs',['breadcrumbs'=>$childValue->breadcrumb]) --}}
                    <a  data-url="" class="loadActiveCategory text-center">{!!   $childValue->active==1?"<i class='fas fa-check-circle'></i>":"<i class='fas fa-times-circle'></i>" !!}</a>
                </div>
            </div>
        </div>
        <div class="pt-1 pb-1 lb_list_action_recusive" >
            <a href="{{route($routeNameEdit,['id'=>$childValue->id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
            <a href="{{route($routeNameAdd,['parent_id'=>$childValue->id])}}" class="btn btn-sm btn-info">+ Thêm</a>
            <a data-url="{{route($routeNameDelete,['id'=>$childValue->id])}}" class="btn btn-sm btn-danger lb_delete_recusive"><i class="far fa-trash-alt"></i></a>
            @if ($childValue->childs->count())
            <button type="button" class="btn btn-sm btn-primary lb-toggle">
                <i class="fas fa-plus"></i>
            </button>
            @endif
        </div>
    </div>
    @if ($childValue->childs->count())
        <ul class="" style="display: none;">
            @foreach ($childValue->childs as $childValue2)
                @include('admin.components.category-child', ['childValue' => $childValue2])
            @endforeach
        </ul>
    @endif
</li>

