<!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
 </head>
 <body>
  <div style="position: absolute;top:50px;font-size: 78px;left:40px" class="text-danger" id="grade">
    0
  </div>
  	<div class="container pt-4">
      <div class="alert alert-success" id="success" style="display: none">
          <strong>Correct Answer!!</strong> Keep Tempo.
      </div>

      <div class="alert alert-danger" id="danger" style="display: none">
        <strong>Incorrect Answer!</strong> TryAgain.
      </div>
      @foreach ($questions as $element)
        <div id="to_close{{$element->qid}}">
        
          <div>
            {{$element->question}}
          </div>
          <div class="d-flex">
            @foreach (App\Answer::where("question_id",$element->qid)->get() as $ans)
                <div class="form-check mr-4" id="div{{ $ans->uid}}"  >
                  <input class="form-check-input" type="radio" name="exampleRadios" id="{{ $ans->uid}}" value="{{$ans->uid}}" data="to_close{{$element->qid}}">
                  <label class="form-check-label" for="{{ $ans->uid}}" id="lable{{$ans->uid}}" data="to_close{{$element->qid}}">
                    {{ $ans->answer }}
                  </label>
                </div>
            
            @endforeach
          </div>
        </div>
      @endforeach
      <button class="btn-primary btn w-100 mt-4" id="finish" onclick="end()">finish</button>
      <div class="form-group" id="typename" style="display: none">
        <input type="text" name="name" placeholder="name" class="form-control mt-2" id="name">
        <button class="btn-primary btn w-100 mt-2" onclick="saverecord()">Finish And Save Record</button>
      </div>
      
  		
  	</div>
  	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  	<script type="text/javascript">
  		let id=1;
      var grades=10;
  		function sendans(id) {
  			$.ajax({
           type:'post',
           url:'{{ route('send') }}',
           data:{
            "id":id,
            "_token":"{{csrf_token()}}"
          },
           success:function(data) {
            data=JSON.parse(data)
              if(data["msg"]=="correct"){
                grades=grades+2;
                $("#success").show()
              }
              else{
                $("#danger").show()

              }
                console.log(data["msg"])
              
              upgrade_grade()
           }
        });
  		}
  	$(document).ready(function(){

  	});
    function end(){
      location.reload(true);
    }
    function saverecord() {
      $.ajax({
         type:'post',
         url:'{{ route('save') }}',
         data:{
          "grade":grades,
          "name":$("#name").val(),
          "_token":"{{csrf_token()}}"
        },
        success:function(data) {
          if (data==1){
              end()
            }
            console.log(data)
          }
        });
      
      }
    
    function upgrade_grade() {
      $("#grade").html(grades)
      if(grades>=10){
        $("#typename").show()
        $("#finish").hide();
        $("#grade").removeClass("text-danger")
        $("#grade").addClass("text-success")
      }
    }
    function prepare_to_send(x,y) {
      $("#"+x).toggle()
      sendans(y)
    }
    $(".form-check-input").click(function(){
      $("#success").hide();
      $("#danger").hide();
      prepare_to_send($(this).attr("data"),$(this).attr("value"));
    });
    
  	</script>
 </body>
 </html>