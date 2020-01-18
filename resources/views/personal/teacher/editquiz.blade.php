@extends('personal.layout')
@section('header')
<link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet"> 
<link href="{!! asset('v1/lib/quill/quill.core.css') !!}" rel="stylesheet">
<link href="{!! asset('v1/lib/quill/quill.snow.css') !!}" rel="stylesheet">
<link href="{!! asset('v1/lib/quill/quill.bubble.css') !!}" rel="stylesheet">
<script src="{!! asset('v1/lib/ckeditor/ckeditor.js') !!}"></script>
<script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
<title>Edit Quiz by Clas | Ayo Sekolah</title>

<style>
.image-upload > input
{
display: none;
}
.image-upload img
{
/* width: 200px; */
cursor: pointer;
}
.question_image-upload > input {
display: none;
}
.question_image-upload img
{
width: 38px;
cursor: pointer;
}
.checkmark {
height: 25px;
width: 25px;
background-color: #eee;
border-radius: 50%; 
background: no-repeat 50% / 50% 50%;
}
.cke_textarea_inline {
    min-height: 38px;
    display: block;
    width: 100%;
    height: calc(1.5em + 0.9375rem + 2px);
    padding: 0.46875rem 0.625rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #596882;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c0ccda;
    border-radius: 0.25rem;
    max-height: 500px;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    overflow: hidden;
}
.remove_button,.remove_button_a{
    height: 37px;
}
[divPlaceholderContent]:before {
  content: attr(custom-placeholder);
  position: absolute;
  margin-left: 0px;
  color: #999;
  
}

</style>
@endsection
@section('contents')
<div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
<div>
<h4 class="mg-b-0 tx-spacing--1">Quizzes Editor : In Business {{ $quiz->busines->name }} </h4>
</div>
</div>
<div class="row row-xs">
<div class="col-md-12">
            @include('_partial.alert')
</div>
<div class="col-sm-12 col-lg-12">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <button type="button" class="btn  bg-purple  text-white" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-plus "></i> Create a New Question
            </button>
        </div>
        <div class="col-md-8">
                @if(count($questionsanswer))
                <?php 

                if(Request::get('page') > 1){
                    $i = 6 *  Request::get('page') - 5 ;
                }else{
                    $i = 1 ;
                }

                ?>
                @foreach ($questionsanswer as $item)
                    <div class="card mb-3 rounded shadow-sm">
                            <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                        Question {{ $i++ }}
                                </div>
                                <div class="col-md-6">
                                        <div style="float:right">
                                        <a href="{{route('personal.teacher.clas.question.edit',['quiz_id' => $quiz->id, 'question_id' => $item->id])}}" class="p-2  bg-pink  text-white rounded-5">Edit</a>
                                        <a href="{{ url('personal/teacher/quiz/class/delete/question/'.$item->id) }}" class="p-2  flex-1 bg-orange text-white rounded-5">Delete</a>
                                        </div>
                                </div>
                            </div>
                            </div>
                    <div class=" card-body">
                        <h5>{!! $item->image == NULL ?  $item->question :    "<img class='pt-2' width='60px'  src='". Storage::url($item->image) ."'</img>". $item->question !!}</h5>
                        <ol type="a">
                        @foreach ($item->quizQuestionAnswer as $itemAnswer)
                                <li class="{{ $itemAnswer->is_true == 1 ? 'text-success text-bold' : '' }}">  
                                {!! $itemAnswer->image == null ?  $itemAnswer->answer :   "<img class='pt-2' width='60px'  src='". Storage::url($itemAnswer->image) ."'</img>" !!}
                                </li>
                        @endforeach
                        </ol>
                    </div>
                    </div>
                @endforeach
                <div class="row">
                        <div class="col-lg-12">
                        {{ $questionsanswer->links() }}
                        </div>
                </div>

                @else
                <div style="text-align: center">
                    <img src="https://image.freepik.com/free-vector/student-raising-hand-flat-vector-illustration_82574-9686.jpg" width="50%" class="img-responsive">
                    <p class="text-info">Please make a new quiz</h3>
                </div>
                @endif
                <!-- Modal -->
                <div class="modal fade bd-example-modal-lg" id="exampleModal">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Question</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('personal/teacher/quiz/class/edit/question/'.$quiz->id) }}" method="POST" enctype="multipart/form-data" id="form_create">
                                @csrf
                                <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-8 ques">
                                                    <textarea name="question" id="question" class="form-control" cols="30" rows="1"   placeholder="Write your Question here"></textarea>
                                                </div>
                                                <div class="col-md-2">
                                                        <div class="question_image-upload">
                                                                <label for="upload_image_question">
                                                                    <img  id="upload_image_question_result" src="{{ url('v1/images/defaults/placeholder.jpg') }}" class="img-thumbnail" width="47px"/>
                                                                </label>
                                                                <input id="upload_image_question" type="file" onchange="previewImageSingle()" name="question_image" class="form-control" />
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <br>
                                <div class="row ">
                                    <div class="col-md-12 field_wrapper">
                                        @for ($i = 1; $i < 5; $i++)
                                                <div id="r_{{$i}}">
                                                <div class="form-group">
                                                    <div class="row ">
                                                        <div class="col-md-1 ">
                                                                <div class="pt-2 text-center is_true">
                                                                        <input type="radio"  name="is_true" class="checkmark" value="{{$i}}" required>
                                                                </div>
                                                        </div>
                                                        <div class="col-md-7 div_answer">
                                                                <div class="input-group mg-b-10 ans f_{{$i}}">
                                                                    <textarea name="answer[{{$i}}]"  cols="30" rows="1" class="form-control answer" id="answer_text_ass_{{$i}}" placeholder="Write your Question here"></textarea>
                                                                </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                                <a href="#" class="remove_button btn btn-md input-group-text" id="basic-addon2"  data-id="{{$i}}"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                        <div class="col-md-2 image_upload">
                                                                <div class="question_image-upload">
                                                                        <label for="answer-img-{{$i}}" data-id="answer_text_ass_{{$i}}">
                                                                            <img id="answer-img-tag-{{$i}}" src="{{ url('v1/images/defaults/placeholder.jpg') }}" width="47px" class="img-thumbnail"/ data-id="answer_text_ass_{{$i}}">
                                                                        </label>
                                                                        <input  type="file" onchange="preview_images({{$i}}) " id="answer-img-{{$i}}" name="image_answer[{{$i}}]" class="form-control" />
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="col-md-8 offset-1">
                                            <a href="javascript:void(0);" class="add_button btn bg-purple text-white" title="Add field"><i class="fas fa-plus"></i>  Add new Answer</a>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save " onclick="document.getElementById('form_create').submit();">
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-md-4">
            @include('personal.teacher.form_quiz')
        </div>
    </div>
</div><!-- col -->
</div><!-- row -->
</div><!-- container -->   
@endsection
@section('footer')
<script src="{!! asset('v1/lib/select2/js/select2.min.js') !!}"></script>
<script src="{!! asset('v1/lib/prismjs/prism.js') !!}"></script>
<script src="{!! asset('v1/lib/parsleyjs/parsley.min.js') !!}"></script>
<script src="{!! asset('v1/lib/quill/quill.min.js') !!}"></script>
<script>

$("textarea").each(function(){
    CKEDITOR.inline( this , { customConfig: '{{ url("v1/lib/ckeditor/config/c1.js") }}'});
});
    
$('#question').click(function (e) {
$(".tollbar_why").slideToggle();
});;

$('.select2').select2({
placeholder: 'Choose Lesson',
searchInputPlaceholder: 'Search options'
});
$('.clas_select').select2({
placeholder: 'Choose Class',
searchInputPlaceholder: 'Search options'
});


$.each(CKEDITOR.instances, function(i) {
    if(i != "question"){
        var editor = CKEDITOR.instances[i];
        editor.on('change', function() {
            var value = editor.getData();
            console.log(value == "");
            if(value == ""){
                $('#'+editor.name).closest('.div_answer').parent().find('.image_upload').slideDown('fast');
            }else{
                $('#'+editor.name).closest('.div_answer').parent().find('.image_upload').slideUp('fast');
            }
        });
    }
});

    var y = {{$i}}-1 
    var z = {{$i}}-1 
    var k = 4
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    
    var x = 1; 
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; 
            y++
            k++
            var fieldHTML = '<div class="x" id="d_'+y+'"><div class="form-group"> <div class="row ">'+
                            '<div class="col-md-1 "> <div class="pt-2 text-center is_true">' +
                            '<input type="radio" name="is_true" value="'+y+'"" class="checkmark" required>' +
                            '</div></div><div class="col-md-7 div_answer"> <div class="input-group mg-b-10 uns">' +
                            '<textarea name="answer[]" cols="30" rows="1" class="form-control" id="s'+y+'" placeholder="Write your Question here"></textarea>' + 
                            '</div></div><div class="col-md-1"> <a href="#" class="remove_button_a input-group-text" id="basic-addon2" data-id="">' +
                            '<i class="fas fa-trash"></i></a> </div><div class="col-md-2 image_upload"> <div class="question_image-upload">' +
                            '<label for="answer-img-'+y+'" data-id="s'+y+'"> <img id="answer-img-tag-'+y+'" src="{{ url('v1/images/defaults/placeholder.jpg') }}" width="50px" class="img-thumbnail" data-id="s'+y+'"/>' +
                            '</label> <input type="file" id="answer-img-'+y+'" onchange="preview_images('+y+');" name="image_answer[]" class="form-control"/>' +
                            '</div></div></div></div></div></div>';
            $(wrapper).append(fieldHTML); //Add field html
            $("#s" + y).each(function(){
                CKEDITOR.inline( this , { customConfig: '{{ url("v1/lib/ckeditor/config/c1.js") }}'});
            });

            $.each(CKEDITOR.instances, function(i) {
                if(i != "question"){
                    var editor = CKEDITOR.instances[i];
                    editor.on('change', function() {
                        var value = editor.getData();
                        console.log(value == "");
                        if(value == ""){
                            $('#'+editor.name).closest('.div_answer').parent().find('.image_upload').slideDown('fast');
                        }else{
                            $('#'+editor.name).closest('.div_answer').parent().find('.image_upload').slideUp('fast');
                        }
                    });
                }
            });

            $(".uns .cke_textarea_inline").attr("id", "f_" +k);
        }else{
            alert("Maximal Column is 10")
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        var z =  $(this).data("id")
        e.preventDefault();
        $('#r_' +z).remove(); //Remove field html
        x--; //Decrement field counter
    });
    $(wrapper).on('click', '.remove_button_a', function(e){
        e.preventDefault();
        $('#d_' +y).remove(); //Remove field html
        y--; //Decrement field counter
    });

// CKEDITOR.inline('question', { customConfig: '{{ url("v1/lib/ckeditor/config/c1.js") }}'});

function preview_images(i) 
{   
    var checkSize = checkZize("answer-img-"+i)
    if (checkSize == 0 ){
        alert("File too Big, please select a file less than 8 mb"); 
        return false
    }
    
    $('#form_'+i).attr('readonly', 'readonly');
    var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("answer-img-"+i).files[0]);

    oFReader.onload = function(oFREvent) {
        document.getElementById("answer-img-tag-"+i).src = oFREvent.target.result;
    };

    var id = $('#answer-img-tag-'+i).data('id');
    document.getElementById('f_'+i).contentEditable = false;
}

function previewImageSingle() 
{
    var checkSize = checkZize('upload_image_question')
    if (checkSize == 0 ){
        alert("File too Big, please select a file less than 8 mb"); 
        return false
    }
    var oFReader = new FileReader();
     oFReader.readAsDataURL(document.getElementById("upload_image_question").files[0]);
 
    oFReader.onload = function(oFREvent) {
      document.getElementById("upload_image_question_result").src = oFREvent.target.result;
    };
}
function previewImageQuiz() 
{
    var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("quiz-profile-img").files[0]);

    oFReader.onload = function(oFREvent) {
        document.getElementById("quiz-profile-img-tag").src = oFREvent.target.result;
    };
}

function checkZize(s){
        var fi = document.getElementById(s); 
        if (fi.files.length > 0) { 
            for (var i = 0; i <= fi.files.length - 1; i++) { 
                var fsize = fi.files.item(i).size; 
                var file = Math.round((fsize / 1024)); 
                if (file >= 8000) { 
                    return 0;
                }else{
                    return 1;
                }
            } 
        } else{
            return false
        }
}
$(".ques .cke_textarea_inline").attr("custom-placeholder", "Enter Question");
$(".ans .cke_textarea_inline").attr("custom-placeholder", "Enter Answer");

function checkplaceholder() {
    var c = 0 
    $(this).parent().find("[custom-placeholder]").each(function(index) {
      if ($(this).text().trim() != '') {
          $(this).removeAttr('divPlaceholderContent'); 
      } else {
        $(this).attr('divPlaceholderContent', 'true');
      }
    });
}

(function($) {
  $(document).on('input keyup blur', '[contenteditable]', checkplaceholder);
  $(document).on('input keyup blur', '[custom-placeholder]', checkplaceholder);
	$('[custom-placeholder]').each(function(index){
  	if ($(this).text().trim() == '') {
    	$(this).attr('divPlaceholderContent', 'true');
        $(this).attr('id', "f_" +index);
		}
  });
})(jQuery);

$(".po").on("click", function(){
        var id = $("#idquiz").val();
        if($(this).is(":checked")) {
            s = 1
        } else {
            s = 0;
        }
        $.ajax({
                type: "GET",
                url: "{{ url('personal/my_quiz/pub/') }}/" + id + "/" +s,
                success: function(data) {
                    sts = data.is_active
                    if(sts == 0 ){
                        $('.label_status').text("Draft")
                    }else{
                        $('.label_status').text("Publish")
                    }
                }
        });
});


$(".cke_textarea_inline").on("blur", function(){
    
});

function getCode(codes) {
     out  =  codes.replace(/^\s+|\s+$/gm,'');
     $("#codeQuiz").val(out)
}
</script>
@show