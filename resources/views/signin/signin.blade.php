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
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">簽到退查詢</h5>
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





            </div>
        </div>
</div>
@endsection

@section('js')
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
    if(query_date.length==0){
        alert("請選擇查詢日期")
    }else{
        window.location.href = "/signin"+"/"+query_classs+"/"+query_date+"/result";
    }
});
</script>
@endsection
