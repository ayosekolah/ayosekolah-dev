<form action="{{ url('business/clas/'.$id) }}" method="post">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <a href="{{route('busines.personala.all', $id)}}" class="btn btn-xs btn-outline-info" title="Show Personal (Teacher Or Student)"><i class="fa fa-align-justify"></i></a>
    <a href="{{route('business.clas.edit', $id)}}" class="btn btn-xs btn-outline-success" title="Edit Clas"><i class="fa fa-edit"></i></a>
    <button type="submit" class="btn btn-xs btn-outline-danger" onclick="return confirm('Are you sure?')" title="Delete Clas"><i class="fa fa-trash"></i></button>
</form> 