<div class="dropdown">
<button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Invite
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="{{ url('business/invite?type=teacher&id='.$id) }}">Teacher</a>
    <a class="dropdown-item" href="{{ url('business/invite?type=student&id='.$id) }}">Student</a>
</div>
</div>