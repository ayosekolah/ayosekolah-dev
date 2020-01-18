@if($teacher_id == Auth::guard('personal')->user()->id)
<a href="{{route('personal.curriculum.edit', $id)}}" class="btn btn-xs btn-outline-success"><i class="fa fa-edit"></i></a>
<a href="{{route('personal.curriculum.delete', $id)}}" class="btn btn-xs btn-outline-danger"><i class="fa fa-trash"></i></a>
@else
<button href="{{route('personal.curriculum.delete', $id)}}" class="btn btn-xs btn-outline-danger" disabled>Cant't Permission</button>
@endif
