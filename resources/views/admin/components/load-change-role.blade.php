<a  class="btn btn-sm {{$data->role == 'admin' ? 'btn-success':'btn-warning'}} lb-role" data-value="{{$data->role}}" data-type="{{$type?$type:''}}" >{{$data->role== 'admin' ?'Admin':'User'}}</a>
