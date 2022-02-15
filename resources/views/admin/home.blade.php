@extends('layouts.app_admin')

@section('app_css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
<style>
.pre-scrollable {
    max-height: 10px;
    overflow-y: scroll;
}
.hr-style {
  
}
</style>
@endsection

@section('content')
<form action="{{ route('admin.update_plan') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal fade" id="planModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title  font-weight-bold my_nav_text">變更方案</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="form-group hidden_object">
                    <input  id="p_school_id" class="form-control"  name="school_id">
                </div>
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">安親班</label>
                    <input  id="p_school_name" class="form-control"  disabled readonly>
                </div>
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">平台序號</label>
                    <input  id="p_school_pid" class="form-control"  disabled readonly>
                </div>
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">方案</label>
                    <select class="form-select form-control" id="p_school_plan" name="plan" aria-label="Default select example" required="required">

                            <option  value="none" selected>無</option>
                            <option  value="month">月繳</option>
                            <option  value="season">季繳</option>
                            <option  value="year">年繳</option>
                    </select>
                </div>
                
            </div>
        </div>
        <div class="modal-footer">
        <div class="form-group">
                    <div class="float-right">
                    <a href="#" class="btn btn-secondary" id="plan_modal_cancel">取消</a>
                    <button type="submit" class="btn text-light my_nav_color">變更方案</button>
                    </div>
                </div>
        </div>
      </div>
  </div>
</div>
</form>

<form action="{{ route('admin.store_subscribe') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title  font-weight-bold my_nav_text">新增訂單</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="form-group hidden_object">
                    <input  id="s_school_id" class="form-control"  name="school_id">
                </div>
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">安親班</label>
                    <input  id="s_school_name" class="form-control"  disabled readonly>
                </div>
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">平台序號</label>
                    <input  id="s_school_pid" class="form-control"  disabled readonly>
                </div>

                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">開始日期</label>
                    <input  id="s_school_started_date" name="started_date" class="form-control datepicker auto_ended_date"  placeholder="請選擇日期" required="required">
                </div>

                <div class="row justify-content-center">

                <div class="col-md-6">
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">方案</label>
                    <select class="form-select form-control auto_ended_date" id="s_school_plan" name="plan" aria-label="Default select example" required="required">
                            <option  value="none" selected>無</option>
                            <option  value="month">月繳</option>
                            <option  value="season">季繳</option>
                            <option  value="year">年繳</option>
                    </select>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">結束日期</label>
                    <input  id="s_school_ended_date" name="ended_date" class="form-control datepicker"  placeholder="請選擇或是自動產生" required="required">
                </div>
                </div>

                </div>

                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">款項 (選填)</label>
                    <input  id="s_school_price" name="price" class="form-control"  placeholder="請輸入款項" type="number" min="0" >
                </div>

                {{--<div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">收款狀態</label>
                    <select class="form-select form-control" id="s_school_payed" name="payed" aria-label="Default select example" required="required">
                            <option  value="0" >未收款</option>
                            <option  value="1" selected>已收款</option>
                    </select>
                </div>

                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">收款日期</label>
                    <input  id="s_school_payed_date" name="payed_date" class="form-control datepicker"  placeholder="請選擇日期" required="required">
                </div>

                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">款項 (選填)</label>
                    <input  id="s_school_price" name="price" class="form-control"  placeholder="請輸入款項" type="number" min="0" >
                </div>--}}
                
            </div>
        </div>
        <div class="modal-footer">
        <div class="form-group">
                    <div class="float-right">
                    <a href="#" class="btn btn-secondary" id="subscribe_modal_cancel">取消</a>
                    <button type="submit" class="btn text-light my_nav_color">新增訂單</button>
                    </div>
                </div>
        </div>
      </div>
  </div>
</div>
</form>



<form action="{{ route('admin.update_subscribe') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal fade" id="subscribeEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title  font-weight-bold my_nav_text">更新訂單</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="form-group hidden_object">
                    <input  id="e_subscribe_id" class="form-control"  name="subscribe_id">
                </div>
                <div class="form-group hidden_object">
                    <input  id="e_school_id" class="form-control" >
                </div>
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">安親班</label>
                    <input  id="e_school_name" class="form-control"  disabled readonly>
                </div>
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">平台序號</label>
                    <input  id="e_school_pid" class="form-control"  disabled readonly>
                </div>
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">訂單編號</label>
                    <input  id="e_order_id" class="form-control"  disabled readonly>
                </div>

                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">開始日期</label>
                    <input  id="e_school_started_date" name="started_date" class="form-control datepicker_costom auto_ended_date2"  placeholder="請選擇日期" required="required">
                </div>

                <div class="row justify-content-center">

                <div class="col-md-6">
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">方案</label>
                    <select class="form-select form-control auto_ended_date2" id="e_school_plan" name="plan" aria-label="Default select example" required="required">
                            <option  value="none" selected>無</option>
                            <option  value="month">月繳</option>
                            <option  value="season">季繳</option>
                            <option  value="year">年繳</option>
                    </select>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">結束日期</label>
                    <input  id="e_school_ended_date" name="ended_date" class="form-control datepicker_costom"  placeholder="請選擇或是自動產生" required="required">
                </div>
                </div>

                </div>

                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">款項 (選填)</label>
                    <input  id="e_school_price" name="price" class="form-control"  placeholder="請輸入款項" type="number" min="0" >
                </div>

                <div class="mt-5">
                <hr class="bg-primary hr-style">
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">收款狀態</label>
                    <div class="row justify-content-center">

                    <div class="col-md-6">
                    <select class="form-select form-control" id="e_school_payed" name="payed" aria-label="Default select example" required="required">
                            <option  value="0" >未收款</option>
                            <option  value="1" >已收款</option>
                    </select>
                    </div>

                    </div>
                </div>
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">收款日期</label>
                    <div class="row justify-content-center">

                    <div class="col-md-6">
                        <input  id="e_school_payed_date"  class="form-control datepicker_costom" name="payed_date" placeholder="請選擇日期"  >
                    </div>

                    </div>
                </div>
                </div>
                {{--<div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">收款狀態</label>
                    <select class="form-select form-control" id="e_school_payed" name="payed" aria-label="Default select example" required="required">
                            <option  value="0" >未收款</option>
                            <option  value="1" selected>已收款</option>
                    </select>
                </div>

                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">收款日期</label>
                    <input  id="e_school_payed_date"  class="form-control datepicker_costom" name="payed_date" placeholder="請選擇日期" required="required" >
                </div>

                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">款項 (選填)</label>
                    <input  id="e_school_price" name="price" class="form-control"  placeholder="請輸入款項" type="number" min="0" >
                </div>--}}
               
                
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit " class="mr-auto btn btn-link text-danger  astext " name="delete" onclick="return confirm('確定刪除這筆訂單嗎?');">刪除</button>

            <div class="form-group">

                <div class="float-right">
                <a href="#" class="btn btn-secondary" id="subscribeEdit_modal_cancel">取消</a>
                <button type="submit" class="btn text-light my_nav_color" name="update">更新訂單</button>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
</form>




<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6">
            @if(session()->has('success_msg'))
                <div class="alert alert-success mb-3" name="alert_msg">
                    {{ session()->get('success_msg') }}
                </div>
            @endif
            @if(session()->has('error_msg'))
                <div class="alert alert-danger mb-3" name="alert_msg">
                    {{ session()->get('error_msg') }}
                </div>
            @endif
            @if(session()->has('normal_msg'))
                <div class="alert alert-info mb-3" name="alert_msg">
                    {{ session()->get('normal_msg') }}
                </div>
            @endif
           
        </div>

        <div class="col-md-12">

            <div class="card shadow-sm">
                <div class="card-header d-flex flex-row" >
                    <h5 class="font-weight-bold text-success mr-5 my_nav_text">查詢應收款的訂單</h5>
                    
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <!--<div class="row justify-content-center">

                        <div class="col-md-8">-->
                        <input  id="query_date"  class="hidden_object datepicker"  placeholder="請選擇日期" value="{{$today}}" required="required">
                        <!--從今天<input  id="query_date"  class=" datepicker"  placeholder="請選擇日期" value="{{$today}}" required="required">
                        開始，-->在<input  id="query_weeks" class=""  type="number" min="1"  value="2"  placeholder="請輸入週數" required="required"><span class="text-danger">週</span>之內，應收款的訂單
                        <button id="query_btn" type="button" class="btn btn-primary "><i class="fas fa-search"></i> 查詢訂單</button><br><span class="text-primary">(說明: 結束日期在此區間的訂單)</span>
                        <!--</div>-->
                        <!--<div class="col-md-2">-->
                        <!--<button id="query_btn" type="button" class="btn btn-primary "><i class="fas fa-search"></i> 查詢訂單</button>-->
                        <!--</div>-->

                        <!--</div>-->
                    </div>
                    <div id="query_info"></div>
                    <div class="table-responsive">
                        <table id="query_table" class="hidden_object table  dataTable table-hover text-center text-middle table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="my_nav_color text-light">
                                    <th>訂單編號</th>
                                    <th>安親班</th>
                                    <th>方案</th>
                                    <th>開始日期</th>
                                    <th>結束日期</th>
                                    <th>訂單建立時間</th>
                                    <th>收款狀態</th>
                                    <th>收款日期</th>
                                </tr>
                            </thead>

                            <tbody id="query_table_inner">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 my-5">

            <div class="card shadow-sm">
                <div class="card-header d-flex flex-row" >
                    <h5 class="font-weight-bold text-success mr-5 my_nav_text">安親班總覽</h5>
                    {{--<div class="d-flex  float-right  ml-auto" >
                       
                        <a href="{{ route('account.create') }}" >
                            <button type="button"   class="btn text-light btn-icon-split  my_nav_color  ml-3 mb-1 "><i class="fas fa-plus"></i> 新增帳號</button>
                        </a>
                    </div>--}}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table  dataTable table-hover text-center text-middle table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="my_nav_color text-light">
                                    {{--<th>ID</th>--}}
                                    <th>安親班</th>
                                    <th>平台序號</th>
                                    <th>聯絡方式</th>
                                    <!--<th>負責人</th>
                                    <th>電話</th>-->
                                    <th>學生總數</th>
                                    <th>簽到退總數</th>
                                    <th >訂單管理</th>
                                    <!--<th>方案</th>-->
                                    <th>操作</th>
                                    <th>停用/啟用</th>
                                    <th class="hidden_object"></th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($schools as $school)
                                <tr>
                                    {{--<td>{{ $school->id }}</td>--}}
                                    <td>{{ $school->School_Name }}</td>
                                    <td>{{ $school->PID }}</td>
                                    <td>{{ $school->admin }}<br><i class="fa fa-phone-square text-success"></i> {{ $school->phone }}</td>
                                    <!--<td>{{ $school->admin }}</td>
                                    <td>{{ $school->phone }}</td>-->
                                    <td>
                                        @php
                                        $students=$school->student;
                                        @endphp
                                        {{ count($students) }}人
                                    </td>
                                    <td>
                                        @php
                                        $signs=$school->signin;
                                        @endphp
                                        {{ count($signs) }}次
                                    </td>
                                    <td class="">
                                        {{--@if($school->id==1)
                                        2022/2/7 已繳費<br>
                                        2022/3/7 已繳費<br>
                                        2022/4/7 已繳費
                                        @endif--}}
                                        {{--@php
                                        $my_subscribe_count=0;
                                        $my_subscribe_count2=0;
                                        foreach($subscribes as $subscribe){
                                            if($subscribe->School_id==$school->id){
                                                $my_subscribe_count++;
                                            }
                                        }
                                        @endphp
                                        
                                        @foreach($subscribes as $subscribe)
                                            @if($subscribe->School_id==$school->id)
                                                @php
                                                $my_subscribe_count2++;
                                                @endphp
                                                <div class="">
                                                    {{$subscribe->payed_date}}
                                                    @if($subscribe->payed)
                                                    <span class="text-success font-weight-bold">(已收款)</span>
                                                    @else
                                                    <span class="text-danger font-weight-bold">(未收款)</span>
                                                    @endif
                                                    @php
                                                    $value_array=array($school->id, $subscribe->id, $subscribe->payed, $subscribe->payed_date, $subscribe->price);
                                                    $value_array_encode=json_encode($value_array);
                                                    @endphp
                                                    <button type="button" class="subscribe_edit_btn" value="{{$value_array_encode}}"   data-target="#subscribeEditModal" data-toggle="modal"><small>編輯</small></button>       
                                                    @if($my_subscribe_count2!=$my_subscribe_count)
                                                    <hr>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                        --}}
                                        @php
                                        $my_subscribe_count=0;
                                        $my_subscribe_count2=0;
                                        foreach($subscribes as $subscribe){
                                            if($subscribe->School_id==$school->id){
                                                $my_subscribe_count++;
                                            }
                                        }
                                        @endphp

                                        @if($my_subscribe_count>0)
                                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="{{'#collapseExample'.$school->id}}" aria-expanded="false" aria-controls="collapseExample">
                                            <small>顯示訂單( {{$my_subscribe_count}} )</small>
                                        </button>
                                        @else
                                        <span>無</span>
                                        @endif
                                        <div class="collapse" id="{{'collapseExample'.$school->id}}">
                                        @foreach($subscribes as $subscribe)
                                            @if($subscribe->School_id==$school->id)
                                            @php
                                                $my_subscribe_count2++;
                                                $value_array=array($school->id, $subscribe->id);
                                                $value_array_encode=json_encode($value_array);
                                            @endphp
                                            
                                            <div>
                                                @if($my_subscribe_count2==1)
                                                <hr>
                                                @endif
                                                <button class="subscribe_edit_btn btn btn-link text-primary atext" value="{{$value_array_encode}}" data-target="#subscribeEditModal" data-toggle="modal"><u>{{$subscribe->order_id}}</u><br>
                                                    @if($subscribe->payed)
                                                    <span class="text-success"><small>(已收款)</small></span>
                                                    @else
                                                    <span class="text-danger"><small>(未收款)</small></span>
                                                    @endif
                                                </button>
                                                @if($my_subscribe_count!=$my_subscribe_count2)
                                                <hr>
                                                @endif
                                            </div>
                                            @endif
                                        @endforeach
                                        </div>
                                        
                                    </td>
                                    <!--<td>-->
                                        {{--@if($school->id==1)
                                        月繳
                                        @endif--}}
                                        {{--@switch($school->plan)
                                            @case("month")
                                                @php
                                                    $plan="月繳";
                                                @endphp
                                                @break
                                            @case("season")
                                                @php
                                                    $plan="季繳";
                                                @endphp
                                                @break
                                            @case("year")
                                                @php
                                                    $plan="年繳";
                                                @endphp
                                                @break
                                                  
                                            @default
                                                @php
                                                    $plan="無";
                                                @endphp
                                        @endswitch
                                        @if($plan!="無")
                                        <span class="bg-warning ">{{$plan}}</span>
                                        @endif--}}
                                    <!--</td>-->
                                    <td>
                                    <button class="subscribe_create_btn btn btn-link atext" data-target="#subscribeModal" data-toggle="modal"><i class="fas fa-plus"></i> 新增訂單</button>
                                    {{--<a href="#" class="subscribe_create_btn" data-target="#subscribeModal" data-toggle="modal"><i class="fas fa-plus"></i> 新增訂單</a>--}}
                                       {{--<a href="#" class="subscribe_create_btn" data-target="#subscribeModal" data-toggle="modal">新增收款</a><br>
                                       <a href="#" class="plan_edit_btn" data-target="#planModal" data-toggle="modal">變更方案</a>
                                       --}}
                                    </td>
                                    <td>
                                        <form  action="{{ route('admin.change_active',$school->id) }}" method="POST" class="change_active_form" enctype="multipart/form-data"  >
                                        @csrf
                                        @if($school->Active)
                                            <input class="hidden_object change_active_value" name="current_status" value="{{$school->Active}}">
                                            <button type="button" class="btn btn-link text-success astext change_active_btn" ><i class="fas fa-power-off"></i> 已啟用</button>
                                        @else
                                            <input class="hidden_object change_active_value" name="current_status" value="{{$school->Active}}">
                                            <button type="button" class="btn btn-link text-danger astext change_active_btn" ><i class="fas fa-power-off"></i> 已停用</button>
                                        @endif
                                        </form>
                                    </td>
                                    <td class="school_edit_id hidden_object">{{$school->id}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>

        </div>

        

    </div>
</div>
@endsection

@section('app_js')
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script>
$("document").ready(function(){
    /*setTimeout(function(){
        $("[name='alert_msg']").hide();
    }, 5000 );*/
});
$('.datepicker').datepicker({
	    format: 'yyyy-mm-dd',
	    language: 'zh-CN',
      todayHighlight: true
	});
$('.datepicker_costom').datepicker({
	    format: 'yyyy-mm-dd',
	    language: 'zh-CN',
      todayHighlight: true
	});

var schools={!! json_encode($schools) !!};
var subscribes={!! json_encode($subscribes) !!};

var school_edit_id=document.querySelectorAll('.school_edit_id');

var plan_edit_btn=document.querySelectorAll('.plan_edit_btn');
var s_id=null;
plan_edit_btn.forEach(function(item,index){
    item.addEventListener('click', function(){
        s_id=school_edit_id[index].innerHTML;
        var where=schools.findIndex(x => x.id==s_id);
        if(where!=-1){
            document.getElementById('p_school_id').value=schools[where].id;
            document.getElementById('p_school_name').value=schools[where].School_Name;
            document.getElementById('p_school_pid').value=schools[where].PID;
            var plan =schools[where].plan;
            if(plan==null){
                document.getElementById('p_school_plan').value="none";
            }else{
                document.getElementById('p_school_plan').value=plan;
            }
        }else{
            alert('發生錯誤!')
        }
    });
});

var subscribe_create_btn=document.querySelectorAll('.subscribe_create_btn');
var s2_id=null;
subscribe_create_btn.forEach(function(item,index){
    item.addEventListener('click', function(){
        s2_id=school_edit_id[index].innerHTML;
        var where=schools.findIndex(x => x.id==s2_id);
        if(where!=-1){
            document.getElementById('s_school_id').value=schools[where].id;
            document.getElementById('s_school_name').value=schools[where].School_Name;
            document.getElementById('s_school_pid').value=schools[where].PID;
            //document.getElementById('s_school_payed').value=1;
            //document.getElementById('s_school_payed_date').value="";
            document.getElementById('s_school_started_date').value="";
            document.getElementById('s_school_plan').value="none";
            document.getElementById('s_school_ended_date').value="";
            document.getElementById('s_school_price').value="";
        }else{
            alert('發生錯誤!')
        }
    });
});

function convert_date(date){
    return date.toISOString().split('T')[0];
}
function addDays(date, days) {
  var result = new Date(date);
  result.setDate(result.getDate() + days);
  return convert_date(result);
}
function addMonths(date, months) {
    var date = new Date(date);
    var d = date.getDate();
    date.setMonth(date.getMonth() + +months);
    if (date.getDate() != d) {
      date.setDate(0);
    }
    return convert_date(date);
}


var auto_ended_date=document.querySelectorAll('.auto_ended_date');
auto_ended_date.forEach(function(item,index){
    item.addEventListener('change', function(){
        var test_value_1=document.getElementById('s_school_started_date').value;
        var test_value_2=document.getElementById('s_school_plan').value;
        if(test_value_1.length!=0 && test_value_2!='none'){
            var m=0;
            switch(test_value_2){
                case 'month':
                    m=1;
                    break;
                case 'season':
                    m=3;
                    break;
                case 'year':
                    m=12;
                    break;
                default:
                    break;
            }
            if(m!=0){
                var ed_date=addMonths(test_value_1,m);
                if(ed_date!=null){
                    document.getElementById('s_school_ended_date').value=ed_date.toString();
                }
            }
        }
    });
});
var auto_ended_date2=document.querySelectorAll('.auto_ended_date2');
auto_ended_date2.forEach(function(item,index){
    item.addEventListener('change', function(){
        var test_value_1=document.getElementById('e_school_started_date').value;
        var test_value_2=document.getElementById('e_school_plan').value;
        if(test_value_1.length!=0 && test_value_2!='none'){
            var m=0;
            switch(test_value_2){
                case 'month':
                    m=1;
                    break;
                case 'season':
                    m=3;
                    break;
                case 'year':
                    m=12;
                    break;
                default:
                    break;
            }
            if(m!=0){
                var ed_date=addMonths(test_value_1,m);
                if(ed_date!=null){
                    document.getElementById('e_school_ended_date').value=ed_date.toString();
                }
            }
        }
    });
});

function edit_modal_event(){
var subscribe_edit_btn=document.querySelectorAll('.subscribe_edit_btn');
subscribe_edit_btn.forEach(function(item,index){
    item.addEventListener('click', function(){
        console.log("button",this)
        var s3_value=JSON.parse(item.value);
        var s3_id=s3_value[0];
        var s3_subscribe_id=s3_value[1];
        var where=schools.findIndex(x => x.id==s3_id);
        var where2=subscribes.findIndex(x => x.id==s3_subscribe_id);
        if(where!=-1 && where2!=-1){
            document.getElementById('e_subscribe_id').value=s3_subscribe_id;
            document.getElementById('e_school_id').value=schools[where].id;
            document.getElementById('e_school_name').value=schools[where].School_Name;
            document.getElementById('e_school_pid').value=schools[where].PID;

            document.getElementById('e_order_id').value=subscribes[where2].order_id;
            document.getElementById('e_school_started_date').value=subscribes[where2].started_date;
            document.getElementById('e_school_plan').value=subscribes[where2].plan;
            document.getElementById('e_school_ended_date').value=subscribes[where2].ended_date;
            if(subscribes[where2].price==null){
                document.getElementById('e_school_price').value="";
            }else{
                document.getElementById('e_school_price').value=subscribes[where2].price;
            }

            document.getElementById('e_school_payed').value=subscribes[where2].payed;
            if(subscribes[where2].payed_date==null){
                document.getElementById('e_school_payed_date').value="";
            }else{
                document.getElementById('e_school_payed_date').value=subscribes[where2].payed_date;
            }


        }else{
            alert('發生錯誤!')
        }
        /*var s3_value=JSON.parse(item.value);
        var s3_id=s3_value[0];
        var s3_subscribe_id=s3_value[1];
        var s3_payed=s3_value[2];
        var s3_payed_date=s3_value[3];
        var s3_price=s3_value[4];
        var where=schools.findIndex(x => x.id==s3_id);
        if(where!=-1){
            document.getElementById('e_subscribe_id').value=s3_subscribe_id;
            document.getElementById('e_school_id').value=schools[where].id;
            document.getElementById('e_school_name').value=schools[where].School_Name;
            document.getElementById('e_school_pid').value=schools[where].PID;
            document.getElementById('e_school_payed').value=s3_payed;
            document.getElementById('e_school_payed_date').value=s3_payed_date;
            if(s3_price==null){
                document.getElementById('e_school_price').value="";
            }else{
                document.getElementById('e_school_price').value=s3_price;
            }
        }else{
            alert('發生錯誤!')
        }*/
    });
});
}
edit_modal_event();


var datepicker_costom=document.querySelectorAll('.datepicker_costom');
datepicker_costom.forEach(function(item,index){
    item.addEventListener('click', function(){
        if(item.value!=null){
            $(this).datepicker('setDate',item.value);
        }
    });
});

var e_school_payed=document.getElementById('e_school_payed');
e_school_payed.addEventListener("change",function(){
    if(this.value==0){
        document.getElementById('e_school_payed_date').value=""
    }
})

var change_active_form=document.querySelectorAll('.change_active_form');
var change_active_value=document.querySelectorAll('.change_active_value');
var change_active_btn=document.querySelectorAll('.change_active_btn');
change_active_btn.forEach(function(item,index){
    item.addEventListener('click', function(){
        var result=false
        var match_form=change_active_form[index]
        var current_active=change_active_value[index].value
        var ac_id=school_edit_id[index].innerHTML;
        var where=schools.findIndex(x => x.id==ac_id);
        if(where!=-1){
            if(current_active==1){
                if ( confirm("確定要將「"+schools[where].School_Name+"」停用嗎?") == false ) {
                    result=false;
                } else {
                    result=true;
                }
            }else{
                result=true;
            }
            if(result){
                match_form.submit()
            }
        }else{
            alert('發生錯誤!')
        }
    });
});

$('#plan_modal_cancel').click(function() {
    $('#planModal').modal('hide');
});
$('#subscribe_modal_cancel').click(function() {
    $('#subscribeModal').modal('hide');
});
$('#subscribeEdit_modal_cancel').click(function() {
    $('#subscribeEditModal').modal('hide');
});


$("#s_school_started_date").on("change.datetimepicker", ({date}) => {
    var test_value_1=document.getElementById('s_school_started_date').value;
    var test_value_2=document.getElementById('s_school_plan').value;
    if(test_value_1.length!=0 && test_value_2!='none'){
            var m=0;
            switch(test_value_2){
                case 'month':
                    m=1;
                    break;
                case 'season':
                    m=3;
                    break;
                case 'year':
                    m=12;
                    break;
                default:
                    break;
            }
            if(m!=0){
                var ed_date=addMonths(test_value_1,m);
                if(ed_date!=null){
                    document.getElementById('s_school_ended_date').value=ed_date.toString();
                }
            }
    }
})
$("#e_school_started_date").on("change.datetimepicker", ({date}) => {
    var test_value_1=document.getElementById('e_school_started_date').value;
    var test_value_2=document.getElementById('e_school_plan').value;
    if(test_value_1.length!=0 && test_value_2!='none'){
            var m=0;
            switch(test_value_2){
                case 'month':
                    m=1;
                    break;
                case 'season':
                    m=3;
                    break;
                case 'year':
                    m=12;
                    break;
                default:
                    break;
            }
            if(m!=0){
                var ed_date=addMonths(test_value_1,m);
                if(ed_date!=null){
                    document.getElementById('e_school_ended_date').value=ed_date.toString();
                }
            }
    }
})

var query_btn=document.getElementById('query_btn');
query_btn.addEventListener("click", function() {
    $('#query_table').hide()  
    var query_date=document.getElementById('query_date').value;
    var query_weeks=document.getElementById('query_weeks').value;
    if(query_date.length!=0 && query_weeks.length!=0){
        document.getElementById('query_info').innerHTML=""
        document.getElementById('query_table_inner').innerHTML=""
        $.ajax({
                    type:'POST',
                    url:'/management/query_due',
                    dataType:'json',
                    data:{
                    'query_date':query_date,
                    'query_weeks':query_weeks,
                    _token: '{{csrf_token()}}'
                    },
                    success:function(total_data){
                        console.log(total_data)
                        var data=total_data[0]
                        var st=total_data[1]
                        var due=total_data[2]
                        var q_info = document.createElement("span")
                        q_info.setAttribute("class", "text-danger");
                        q_info.innerHTML="查詢範圍: "+st+" 至 "+due;
                        document.getElementById('query_info').appendChild(q_info);
                        for (var i = 0; i < data.length; i++) {
                            /*
                            $value_array=array($school->id, $subscribe->id);
                            $value_array_encode=json_encode($value_array);
                            <button class="subscribe_edit_btn btn btn-link text-primary atext" value="{{$value_array_encode}}" data-target="#subscribeEditModal" data-toggle="modal"><u>{{$subscribe->order_id}}</u><br>

                            */
                            var tr = document.createElement("tr");
                            var td1 = document.createElement("td");
                                var td1_id=data[i].id
                                var td1_school_id=data[i].School_id
                                var value_array = [td1_school_id, td1_id];
                                var value_array_encode=JSON.stringify(value_array)
                                //td1.innerHTML=data[i].order_id
                                var button = document.createElement("button");
                                button.innerHTML="<u>"+data[i].order_id+"</u>"
                                button.setAttribute("value",value_array_encode);
                                button.setAttribute("class","subscribe_edit_btn btn btn-link text-primary atext");
                                button.setAttribute("data-target", "#subscribeEditModal");
                                button.setAttribute("data-toggle", "modal");
                                console.log("button",button)
                                td1.appendChild(button);
                                tr.appendChild(td1);
                            var td2 = document.createElement("td");
                                var where=schools.findIndex(x => x.id==data[i].School_id);
                                if(where!=-1){
                                    td2.innerHTML=schools[where].School_Name
                                }
                                tr.appendChild(td2);
                            var td3 = document.createElement("td");
                                switch(data[i].plan){
                                    case 'month':
                                        var plan="月繳"
                                        break;
                                    case 'season':
                                        var plan="季繳"
                                        break;
                                    case 'year':
                                        var plan="年繳"
                                        break;
                                    default:
                                        var plan="無"
                                }
                                td3.innerHTML=plan
                                tr.appendChild(td3);
                            var td4 = document.createElement("td");
                                td4.innerHTML=data[i].started_date
                                tr.appendChild(td4);
                            var td5 = document.createElement("td");
                                td5.innerHTML=data[i].ended_date
                                //td5.innerHTML="<span class='text-danger'>"+data[i].ended_date+"</span>"
                                tr.appendChild(td5);
                            var td6 = document.createElement("td");
                                td6.innerHTML=data[i].created_at
                                tr.appendChild(td6);
                            var td7 = document.createElement("td");
                                if(data[i].payed==1){
                                    td7.innerHTML="<span class='text-success'>已收款</span>"
                                }else{
                                    td7.innerHTML="<span class='text-danger'>未收款</span>"
                                }
                                tr.appendChild(td7);
                            var td8 = document.createElement("td");
                                if(data[i].payed_date!=null){
                                    td8.innerHTML="<span class='text-success'>"+data[i].payed_date+"</span>"
                                }else{
                                }
                                tr.appendChild(td8);
                            document.getElementById('query_table_inner').appendChild(tr);
                                
                            
                            //var option = document.createElement("option");
                            //option.value = array_1[i];
                            //option.text = array_2[i];
                            //select2.appendChild(option);
                        }
                        if(data.length==0){
                            document.getElementById('query_table_inner').innerHTML="<tr>查無結果</tr>"
                        }
                        $('#query_table').show()
                        edit_modal_event();
                       
                        /*var result=data.result;
                            if(result=='success'){
                                window.location.href = "/batch"+"?success_msg="+data.msg;
                            }else{
                                window.location.href = "/batch"+"?error_msg="+data.msg;
                            }*/

                    },
                    error:function(e){
                        alert('Error: ' + e);
                    }
        });
    }else{
        //alert('請輸入日期和週數')
        alert('請輸入週數')
    }
});
query_btn.click();

</script>
@endsection
