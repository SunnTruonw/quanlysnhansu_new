<a  class="btn btn-sm {{$data->active==1?'btn-success':'btn-warning'}} @if($authCheck->role == 'admin') lb-active @elseif($authCheck->id == $data->id)  lb-active-ckeck @else no-quyen @endif" data-value="{{$data->active}}" data-type="{{$type?$type:''}}">{{$data->active==1?'Đang làm':'Nghỉ việc'}}</a>
