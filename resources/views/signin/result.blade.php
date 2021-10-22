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

            @if(count($signin)==0)
            <div class="alert alert-danger">
                日期: {{$date}}<br>班級: {{$classs_name}}<br><br>查無簽到退記錄
            </div>
            @else
            <div class="alert alert-success">
                日期: {{$date}}<br>班級: {{$classs_name}}<br><br>查詢結果如下
            </div>
            @endif
                <div class="card">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">簽到退查詢</h5>
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
                                   <div>尚未簽到</div>
                                   @endif
                                   @if($in_count>0)
                                   <div class="enlarge_text text-success font-weight-bold">已簽到</div>
                                   @endif
                                   @if($out_count>0)
                                   <div class="enlarge_text text-success font-weight-bold">已簽退</div>
                                   @endif
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
</script>
@endsection
