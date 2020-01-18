
@if($approve == 0 || $approve ==1 )
<a href="{{ url('business/clas_personal/is_aprroved/'.$id) }}" class="btn btn-xs btn-outline-info">
    <i class="fa fa-edit tx-success"></i> 
</a>

<a href="{{ url('business/clas_personal/is_delete/'.$id) }}" title="Canceld Or Delete" class="btn btn-xs btn-outline-danger">
    <i class="fa fa-trash tx-danger"></i> 
</a>
@else
    <span class="text-warning">Can't Action</span>
@endif