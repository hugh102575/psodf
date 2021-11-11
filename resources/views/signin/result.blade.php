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
        @if($q_type=="c")
        <div class="row justify-content-center">
            <div class="col-md-12">

            @if(count($signin)==0)
            <div class="alert alert-danger" >
                日期: {{$date}}<br>班級: {{$classs_name}}<br><br>查無簽到退記錄
            </div>
            @else
            <div class="alert alert-info">
                日期: {{$date}}<br>班級: {{$classs_name}}<br><br>查詢結果如下
            </div>
            @endif
                <div class="card">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">以班級查詢</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                        <span class="small">快速搜尋:</span>
                        <button class="btn btn-link  shadow-none" type="button" id="show_signed"><small>已簽</small></button>
                        <button class="btn btn-link  shadow-none" type="button" id="show_signed_in"><small>已簽到</small></button>
                        <button class="btn btn-link  shadow-none" type="button" id="show_signed_out"><small>已簽退</small></button>
                        <button class="btn btn-link  shadow-none" type="button" id="show_not_signed"><small>尚未簽到</small></button>
                        <button class="btn btn-link  shadow-none" type="button" id="show_all"><small>全部顯示</small></button>
                        </div>
                        <div class="table-responsive">
                            <table class="table dataTable table-hover text-center text-middle" id="signin_table" width="100%" cellspacing="0">
                                <thead>
                                <tr class="my_nav_color text-light">

                                    <th>學生姓名</th>
                                    <th>學號</th>
                                    @if($classs_name=="不分班級")
                                    <th>班級</th>
                                    @endif
                                    <th>狀態</th>
                                    <!--<th>簽到退影像</th>-->
                                    <th>簽到退時間</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($student as $st)
                                {{--@php
                                $Student_id=$st->id;
                                $created_at=null;
                                $signin_img=null;
                                foreach($signin as $in){
                                    if($in->Student_id == $Student_id){
                                        $created_at=$in->created_at;
                                        $signin_img=$in->signin_img;
                                        break;
                                    }
                                }
                                @endphp--}}
                                <tr>
                                   <td>{{$st->name}}</td>
                                   <td>{{$st->STU_id}}</td>
                                    @if($classs_name=="不分班級")
                                        @foreach($all_classs as $myc)
                                        @if($myc->id==$st->Classs_id)
                                        <td>{{$myc->Classs_Name}}</td>
                                        @break
                                        @endif
                                        @endforeach
                                    @endif
                                   {{--<td>@if($signin_img!=null)
                                       <img src="{{$signin_img}}"  style="height: 5rem; width: 5rem;">
                                       @endif
                                    </td>
                                   <td>{{$created_at}}</td>--}}
                                   {{--<td>
                                    @php
                                    $count_1=0;
                                    @endphp
                                   @foreach($signin as $in)
                                   @if($in->Student_id==$st->id)
                                   @php
                                   $count_1++;
                                   @endphp
                                   <div>({{$count_1}}) <img src="{{$in->signin_img}}"  style="height: 5rem; width: 5rem;"></div>
                                   @endif
                                   @endforeach
                                   </td>--}}
                                   <td id="sign_hint_<?php echo $st->id; ?>">
                                   </td>
                                   <td>
                                    @php
                                    $in_count=0;
                                    $out_count=0;
                                    $count_2=0;
                                    @endphp
                                   @foreach($signin as $in)
                                   @if($in->Student_id==$st->id)
                                        @php
                                        $count_2++;
                                        $created_at=substr($in->created_at, 11);
                                        if($in->sign=="in"){
                                            $sign="簽到";
                                            $in_count++;
                                        }elseif($in->sign=="out"){
                                            $sign="簽退";
                                            $out_count++;
                                        }
                                        @endphp
                                   <div>({{$count_2}}) <span class="enlarge_text">{{$sign}}</span> {{$created_at}}<br><img src="{{$in->signin_img}}"  style="height: 5rem; width: 5rem;"><br><br></div></div>
                                   @endif



                                   @endforeach
                                   @if($count_2==0)
                                   {{--<div>尚未簽到</div>--}}
                                   <script>
                                       var st_id={!! json_encode($st->id) !!};
                                        var sign_hint=document.getElementById('sign_hint_'+st_id);
                                        sign_hint.innerHTML="<div class=' text-danger '>尚未簽到</div>"
                                    </script>
                                   @endif
                                   @if($in_count>0 && $out_count>0)
                                   <script>
                                       var st_id={!! json_encode($st->id) !!};
                                        var sign_hint=document.getElementById('sign_hint_'+st_id);
                                        sign_hint.innerHTML="<div class=' text-success '>已簽到<br>已簽退</div>"
                                    </script>
                                   @else
                                        @if($in_count>0)
                                        {{--<div class="enlarge_text text-success font-weight-bold">已簽到</div>--}}
                                        <script>
                                        var st_id={!! json_encode($st->id) !!};
                                            var sign_hint=document.getElementById('sign_hint_'+st_id);
                                            sign_hint.innerHTML="<div class=' text-success '>已簽到</div>"
                                        </script>
                                        @endif
                                        @if($out_count>0)
                                        {{--<div class="enlarge_text text-success font-weight-bold">已簽退</div>--}}
                                        <script>
                                        var st_id={!! json_encode($st->id) !!};
                                            var sign_hint=document.getElementById('sign_hint_'+st_id);
                                            sign_hint.innerHTML="<div class=' text-success '>已簽退</div>"
                                        </script>
                                        @endif
                                    @endif
                                   </td>
                                </tr>

                                @endforeach
                                </tbody>
                            </table>
                            <div>
                        </div>
                    </div>

                </div>





            </div>
        </div>
        @endif
        @if($q_type=="s1")
        <div class="row justify-content-center">
            <div class="col-md-12">
            <span class="text-info enlarge_text">「{{$st_Name}}」搜尋結果，{{count($student)}}位符合的學生</span>
            @foreach($student as $st)
                    @php
                    $belong_sign=0;
                    $belong_classs=null;
                    foreach($classs as $cls){
                        if($cls->id==$st->Classs_id){
                            $belong_classs=$cls;
                            break;
                        }
                    }
                    foreach($signin as $sn){
                        if($sn->Student_id==$st->id){
                            $belong_sign++;
                        }
                    }
                    @endphp
                <div class="alert alert-info mb-3">
                日期: 全部<br>學號: {{$st->STU_id}}<br>學生: {{$st->name}}<br>班級:
                @if($belong_classs!=null)
                {{$belong_classs->Classs_Name}}
                @endif
                <br><br>
                @if($belong_sign!=0)
                <span class="text-success">{{$belong_sign}}筆簽到/退資料</span>&nbsp;&nbsp;<button class="small query_s1_btn" id="st_{{$st->STU_id}}">查看</button>
                @else
                <span class="text-danger">{{$belong_sign}}筆簽到/退資料</span>
                @endif
                </div>
            @endforeach

                <div class="card">
                        <div class="card-header d-flex flex-row" >
                            <h5 class="font-weight-bold text-success mr-5 my_nav_text">以個人查詢</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-hover text-center text-middle" id="signin_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="my_nav_color text-light">
                                            <th>日期</th>
                                            <th>時間</th>
                                            <th>學號</th>
                                            <th>班級</th>
                                            <th>簽到 / 簽退</th>
                                            <th>簽到相片</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($signin as $sn)
                                    @php
                                    $belong_classs=null;
                                    $me=null;
                                    $t1=date('Y-m-d', strtotime($sn->created_at));
                                    $t2=date('H:i:s', strtotime($sn->created_at));
                                    $s_type="";
                                    if($sn->sign=="in"){
                                        $s_type="簽到";
                                    }
                                    if($sn->sign=="out"){
                                        $s_type="簽退";
                                    }
                                    foreach($student as $st){
                                        if($sn->Student_id==$st->id){
                                            $me=$st;
                                            break;
                                        }
                                    }
                                    foreach($classs as $cls){
                                        if($cls->id==$st->Classs_id){
                                            $belong_classs=$cls;
                                            break;
                                        }
                                    }
                                    @endphp
                                    <tr>
                                    <td>{{$t1}}</td>
                                    <td>{{$t2}}</td>
                                    <td>
                                    @if($me!=null)
                                    {{$me->STU_id}}
                                    @endif
                                    </td>
                                    <td>
                                    @if($belong_classs!=null)
                                    {{$belong_classs->Classs_Name}}
                                    @endif
                                    </td>
                                    <td>{{$s_type}}</td>
                                    <td>
                                        <div>
                                        <img src="{{$sn->signin_img}}"  style="height: 5rem; width: 5rem;">
                                        </div>
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        @endif
        @if($q_type=="s2")
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if(count($signin)==0)
                <div class="alert alert-danger">
                    日期: 全部<br>學號: {{$st_id}}<br>學生: {{$student->name}}<br>班級: {{$classs->Classs_Name}}<br><br>查無簽到退記錄
                </div>
                @else
                <div class="alert alert-info">
                    日期: 全部<br>學號: {{$st_id}}<br>學生: {{$student->name}}<br>班級: {{$classs->Classs_Name}}<br><br>查詢結果如下
                </div>
                @endif

                <div class="card">
                        <div class="card-header d-flex flex-row" >
                            <h5 class="font-weight-bold text-success mr-5 my_nav_text">以個人查詢</h5>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table dataTable table-hover text-center text-middle" id="signin_table" width="100%" cellspacing="0">
                                    <thead>
                                    <tr class="my_nav_color text-light">
                                        <th>日期</th>
                                        <th>時間</th>
                                        <th>簽到 / 簽退</th>
                                        <th>簽到相片</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($signin as $sn)
                                    @php
                                    $t1=date('Y-m-d', strtotime($sn->created_at));
                                    $t2=date('H:i:s', strtotime($sn->created_at));
                                    $s_type="";
                                    if($sn->sign=="in"){
                                        $s_type="簽到";
                                    }
                                    if($sn->sign=="out"){
                                        $s_type="簽退";
                                    }
                                    @endphp
                                    <tr>
                                    <td>{{$t1}}</td>
                                    <td>{{$t2}}</td>
                                    <td>{{$s_type}}</td>
                                    <td>
                                        <div>
                                        <img src="{{$sn->signin_img}}"  style="height: 5rem; width: 5rem;">
                                        </div>
                                    </td>
                                    </tr>


                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
            </div>
        </div>
        @endif
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
$(document).ready(function() {
    $('table.dataTable').DataTable({
        pageLength: 10,
        order: [],
        responsive: true,
        oLanguage: {
            "sProcessing": "處理中...",
            "sLengthMenu": "顯示 _MENU_ 項結果",
            "sZeroRecords": "沒有匹配結果",
            "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(從 _MAX_ 項結果過濾)",
            "sSearch": "搜尋:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁",
                "sLast": "尾頁"
            }
        },
        destroy:true,
        "oSearch": {"sSearch": ""}
    } );
} );

var date={!! json_encode($date) !!};
var q_type={!! json_encode($q_type) !!};

if(q_type=="c"){
var show_signed=document.getElementById('show_signed');
show_signed.addEventListener("click", function() {
    $('#signin_table').DataTable({
    //$('#dataTable').dataTable( {
        pageLength: 10,
        order: [],
        responsive: true,
        oLanguage: {
            "sProcessing": "處理中...",
            "sLengthMenu": "顯示 _MENU_ 項結果",
            "sZeroRecords": "沒有匹配結果",
            "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(從 _MAX_ 項結果過濾)",
            "sSearch": "搜尋:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁",
                "sLast": "尾頁"
            }
        },
        destroy:true,
        "oSearch": {"sSearch": "已簽"}
    } );
});

var show_signed_in=document.getElementById('show_signed_in');
show_signed_in.addEventListener("click", function() {
    $('#signin_table').DataTable({
    //$('#dataTable').dataTable( {
        pageLength: 10,
        order: [],
        responsive: true,
        oLanguage: {
            "sProcessing": "處理中...",
            "sLengthMenu": "顯示 _MENU_ 項結果",
            "sZeroRecords": "沒有匹配結果",
            "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(從 _MAX_ 項結果過濾)",
            "sSearch": "搜尋:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁",
                "sLast": "尾頁"
            }
        },
        destroy:true,
        "oSearch": {"sSearch": "已簽到"}
    } );
});

var show_signed_out=document.getElementById('show_signed_out');
show_signed_out.addEventListener("click", function() {
    $('#signin_table').DataTable({
    //$('#dataTable').dataTable( {
        pageLength: 10,
        order: [],
        responsive: true,
        oLanguage: {
            "sProcessing": "處理中...",
            "sLengthMenu": "顯示 _MENU_ 項結果",
            "sZeroRecords": "沒有匹配結果",
            "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(從 _MAX_ 項結果過濾)",
            "sSearch": "搜尋:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁",
                "sLast": "尾頁"
            }
        },
        destroy:true,
        "oSearch": {"sSearch": "已簽退"}
    } );
});

var show_not_signed=document.getElementById('show_not_signed');
show_not_signed.addEventListener("click", function() {
    $('#signin_table').DataTable({
    //$('#dataTable').dataTable( {
        pageLength: 10,
        order: [],
        responsive: true,
        oLanguage: {
            "sProcessing": "處理中...",
            "sLengthMenu": "顯示 _MENU_ 項結果",
            "sZeroRecords": "沒有匹配結果",
            "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(從 _MAX_ 項結果過濾)",
            "sSearch": "搜尋:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁",
                "sLast": "尾頁"
            }
        },
        destroy:true,
        "oSearch": {"sSearch": "尚未簽到"}
    } );
});

var show_all=document.getElementById('show_all');
show_all.addEventListener("click", function() {
    $('#signin_table').DataTable({
    //$('#dataTable').dataTable( {
        pageLength: 10,
        order: [],
        responsive: true,
        oLanguage: {
            "sProcessing": "處理中...",
            "sLengthMenu": "顯示 _MENU_ 項結果",
            "sZeroRecords": "沒有匹配結果",
            "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(從 _MAX_ 項結果過濾)",
            "sSearch": "搜尋:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁",
                "sLast": "尾頁"
            }
        },
        destroy:true,
        "oSearch": {"sSearch": ""}
    } );
});
}

var query_s1_btn_c=document.querySelectorAll(".query_s1_btn")
query_s1_btn_c.forEach(function(item,index){
    var query_s1_btn=document.getElementById(item.id);
    query_s1_btn.addEventListener("click", function() {
        console.log(query_s1_btn.id)
        var st_id=(query_s1_btn.id).replace("st_", "");
        $('#signin_table').DataTable({
    //$('#dataTable').dataTable( {
        pageLength: 10,
        order: [],
        responsive: true,
        oLanguage: {
            "sProcessing": "處理中...",
            "sLengthMenu": "顯示 _MENU_ 項結果",
            "sZeroRecords": "沒有匹配結果",
            "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(從 _MAX_ 項結果過濾)",
            "sSearch": "搜尋:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁",
                "sLast": "尾頁"
            }
        },
        destroy:true,
        "oSearch": {"sSearch": st_id}
    } );
    });
});
</script>
@endsection
