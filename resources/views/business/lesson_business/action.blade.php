<form action="{{ url('business/lesson_business/'.$id) }}" method="post">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <a href="{{route('busines.lesson.all', $idLesson)}}" class="btn btn-xs btn-outline-info" title="Show Personal (Teacher Or Student)"><i class="fa fa-align-justify"></i></a>
    <a href="{{route('business.lesson_business.edit', $id)}}" class="btn btn-xs btn-outline-success"><i class="fa fa-edit"></i></a>
    <button type="submit" class="btn btn-xs btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
</form> 