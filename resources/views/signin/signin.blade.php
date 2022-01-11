@extends('home')

@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
<style>
.enlarge_text{
  font-size: x-large !important;
}

</style>
@endsection

@section('stage')
<div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card shadow-sm mb-5">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">A. 以班級查詢</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6 mx-auto">
                            <div class="py-3">
                                <div class="form-group mb-0">
                                    <label  class="font-weight-bold my_nav_text ">選擇班級</label>
                                </div>
                                <select id="query_classs"  class="form-select form-control"  aria-label="Default select example" required="required">


                                @foreach($school_classs as $classs)

                                    <option  value="{{$classs->id}}">{{$classs->Classs_Name}}</option>
                                @endforeach
                                <option  value="all_classs">不分班級</option>



                                </select>
                            </div>


                            <div class="py-3">
                                <div class="form-group mb-0">
                                    <label  class="font-weight-bold my_nav_text ">選擇查詢日期</label>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control datepicker" id="query_date"  placeholder="請選擇查詢日期" value="{{$today}}">
                                    <div class="input-group-append">
                                        <button class="input-group-text text-light my_nav_color" id="query_signin">查詢</button>
                                    </div>
                                </div>
                            </div>


                        </div>
                        {{--<div class="table-responsive">
                            <table class="table  table-hover text-center text-middle" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr class="my_nav_color text-light">
                                    <th>簽到退時間</th>
                                    <th>學生姓名</th>
                                    <th>學號</th>
                                    <th>簽到退影像</th>
                                    <th class="hidden_object"></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>--}}
                    </div>

                </div>

                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">B. 以個人查詢</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6 mx-auto">
                            <div class="py-3">
                                <label  class="font-weight-bold my_nav_text ">查詢方式</label>
                                <div class="form-group col-md-6">
                                    <form name="radio_form">
                                    <div class="form-check" >
                                    <input class="form-check-input" type="radio" name="query_b_mode" id="flexRadioDefault1" value="mode_1" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        姓名
                                    </label>
                                    </div>
                                    <div class="form-check" >
                                    <input class="form-check-input" type="radio" name="query_b_mode" id="flexRadioDefault2" value="mode_2" >
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        學號
                                    </label>
                                    </div>
                                    </form>
                                </div>

                                <div class="form-group mb-0" id="mode_1_div">
                                    <label  class="font-weight-bold my_nav_text ">姓名</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="query_stName"  placeholder="請輸入姓名" value="">
                                        <div class="input-group-append">
                                            <button class="input-group-text text-light my_nav_color" id="query_signin3">查詢</button>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group mb-0 hidden_object" id="mode_2_div">
                                    <label  class="font-weight-bold my_nav_text ">學號</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="query_stid"  placeholder="請輸入學號" value="">
                                        <div class="input-group-append">
                                            <button class="input-group-text text-light my_nav_color" id="query_signin2">查詢</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>





            </div>
        </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.zh-CN.min.js"></script>

<script>
document.getElementById('nav_title').innerHTML="<small>簽到退查詢</small>";
$('.datepicker').datepicker({
	    format: 'yyyy-mm-dd',
	    language: 'zh-CN',
      todayHighlight: true
	});

var query_signin=document.getElementById('query_signin');
query_signin.addEventListener("click", function() {
    var query_date=document.getElementById('query_date').value;
    var query_classs=document.getElementById('query_classs').value;
    if(query_classs.length==0){
        alert("請選擇查詢班級")
    }else{
        if(query_date.length==0){
            alert("請選擇查詢日期")
        }else{
            window.location.href = "/signin"+"/c/"+query_classs+"/"+query_date+"/result";
        }
    }
});
var query_signin2=document.getElementById('query_signin2');
query_signin2.addEventListener("click", function() {
    var query_date=document.getElementById('query_date').value;
    var query_stid=document.getElementById('query_stid').value;
    if(query_stid.length==0){
        alert("請輸入學號")
    }else{
        window.location.href = "/signin"+"/s2/"+query_stid+"/"+"all"+"/result";
    }

});

var query_signin3=document.getElementById('query_signin3');
query_signin3.addEventListener("click", function() {
    var query_date=document.getElementById('query_date').value;
    var query_stName=document.getElementById('query_stName').value;
    if(query_stName.length==0){
        alert("請輸入姓名")
    }else{
        window.location.href = "/signin"+"/s1/"+query_stName+"/"+"all"+"/result";
    }

});

var rad = document.radio_form.query_b_mode;
var prev = null;
for (var i = 0; i < rad.length; i++) {
    rad[i].addEventListener('change', function() {
        (prev) ? console.log(prev.value): null;
        if (this !== prev) {
            prev = this;
        }
        console.log(this.value)
        document.getElementById('query_stName').value='';
        document.getElementById('query_stid').value='';
        switch (this.value) {
        case "mode_1":
            $('#mode_1_div').show('normal')
            $('#mode_2_div').hide('normal')
            break;
        case "mode_2":
            $('#mode_2_div').show('normal')
            $('#mode_1_div').hide('normal')
            break;
        default:
        }
    });
}

</script>
@endsection
