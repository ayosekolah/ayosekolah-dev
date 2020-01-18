<div class="card card-body">
        <form action="{{ url('personal/my_quiz/general/update/'.$quiz->id) }}" method="POST"  enctype="multipart/form-data" data-parsley-validate>
            @csrf
            <input name="_method" type="hidden" value="PATCH">
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                        <div class="image-upload">
                                <label for="quiz-profile-img">
                                    <img  id="quiz-profile-img-tag" src="{{ Storage::url($quiz->image) }}" width="500px" class="img-thumbnail"/>
                                </label>
                                <input type="hidden" name="file_name" value="{{ $quiz->image }}">
                                <input id="quiz-profile-img" onchange="previewImageQuiz()" type="file" name="image" class="form-control" title="Click For Change Image"/>
                                <figcaption class="pos-absolute b-0 l-0 wd-100p pd-25 d-flex justify-content-center">
                                    <div class="btn btn-sm btn-light">Click Image Area to Change</div>
                                </figcaption>
                        </div>
                        
                </div>
            </div>
        </div>
        <input type="hidden" id="idquiz" value="{{$quiz->id }}">
        <div class="form-group">
            <label for="formGroupExampleInput" class="d-block">Title</label>
            <input name="title"  type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Enter Quiz Title"  value="{{ $quiz->title }}" required>
            @if ($errors->has('title'))
            <ul class="parsley-errors-list filled" id="parsley-id-5">
                <li class="parsley-required">{{ $errors->first('title') }}.</li>
            </ul>
            @endif
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput" class="d-block">Status   </label>
            <div class="custom-control custom-switch">
                    <input type="checkbox" value="1" class="po custom-control-input" id="customSwitch3" name="is_active" {{ $quiz->is_active == 1 ? 'checked' :'' }}>
                    <label class="custom-control-label label_status" for="customSwitch3">{{ $quiz->is_active == 1 ? 'Publish' :'Draft' }}</label>
            </div>
        </div>
        <div class="form-group">
                <label for="formGroupExampleInput" class="d-block">Code</label>
                <input name="code" id="codeQuiz" onkeyup="getCode(this.value)" type="text" class="form-control" value="{{ $quiz->code }}" required>
                @if ($errors->has('code'))
                <ul class="parsley-errors-list filled" id="parsley-id-5">
                    <li class="parsley-required">{{ $errors->first('code') }}.</li>
                </ul>
                @endif
        </div>
        <a href="{{ url('personal/dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        <button type="submit" class="btn  btn-info">Save</button>
        </form>
</div>