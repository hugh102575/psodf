@extends('layouts.app_guest')

@section('app_css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<style>
.enlarge_text{
  font-size: x-large !important;
}
.zoom_img {
    cursor: pointer;
}
</style>
@endsection

@section('content')
<div class="modal fade" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
            <div class="container-fluid">
            <button type="button" class="close mb-3" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
                <div class="form-group text-center">
                    <img class="img-fluid mb-3" id="zoom_result"/>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <h1 class="my_nav_text text-center mb-5 font-weight-bold">{{$school->School_Name}}</h1>
        @foreach($student as $st)
                    @php
                    $belong_sign=0;
                    /*$belong_classs=null;
                    foreach($classs as $cls){
                        if($cls->id==$st->Classs_id){
                            $belong_classs=$cls;
                            break;
                        }
                    }*/
                    foreach($signin as $sn){
                        if($sn->Student_id==$st->id){
                            $belong_sign++;
                        }
                    }
                    @endphp
                <div class="alert alert-info mb-3">
                日期: 全部<br>學號: {{$st->STU_id}}<br>學生: {{$st->name}}
                {{--@if($belong_classs!=null)
                {{$belong_classs->Classs_Name}}
                @endif--}}
                <br><br>
                @if($belong_sign!=0)
                    @if(count($student)==1)
                    <span class="text-success">{{$belong_sign}}筆簽到/退資料</span>
                    @else
                    <span class="text-success">{{$belong_sign}}筆簽到/退資料</span>&nbsp;&nbsp;<button class="small query_s1_btn" id="st_{{$st->STU_id}}">查看</button>
                    @endif
                {{--<span class="text-success">{{$belong_sign}}筆簽到/退資料</span>&nbsp;&nbsp;<button class="small query_s1_btn" id="st_{{$st->STU_id}}">查看</button>--}}
                @else
                <span class="text-danger">{{$belong_sign}}筆簽到/退資料</span>
                @endif
                </div>
            @endforeach
            @if(count($student)==0)
              <div class="alert alert-danger mb-3">
               親愛的家長，您尚未綁定孩子資料喔。
                </div>
            @endif
          <div class="card shadow-sm">
            <div class="card-header d-flex flex-row" >
              <h5 class="font-weight-bold text-success mr-5 my_nav_text">家長查詢孩子簽到退</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table dataTable table-hover text-center text-middle" id="signin_table" width="100%" cellspacing="0">
                  <thead>
                    <tr class="my_nav_color text-light">
                      <th>日期</th>
                      <!--<th>時間</th>-->
                      <th class="no-sort">姓名</th>
                      <th class="hidden_object">學號</th>
                      <!--<th>簽到 / 簽退</th>-->
                      <th class="no-sort">簽到相片</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($signin as $sn)
                                    @php
                                    //$belong_classs=null;
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
                                    /*foreach($classs as $cls){
                                        if($cls->id==$st->Classs_id){
                                            $belong_classs=$cls;
                                            break;
                                        }
                                    }*/
                                    $dayofweek_ = date('w', strtotime($t1));
                                    $dayofweek ='('.'星期' . ['日', '一', '二', '三', '四', '五', '六'][$dayofweek_].')';
                                    @endphp
                                    <tr>
                                    <td class="small">{{$t1}}<br>{{$dayofweek}}<br>{{$t2}}</td>
                                    <!--<td>{{$t2}}</td>-->
                                    <td>
                                    <span class="">{{$me->name}}</span><br><span class="text-success">({{$s_type}})</span>
                                    </td>
                                    <td class="hidden_object">
                                    @if($me!=null)
                                    {{$me->STU_id}}
                                    @endif
                                    </td>
                                    {{--<td>
                                    @if($belong_classs!=null)
                                    {{$belong_classs->Classs_Name}}
                                    @endif
                                    </td>--}}
                                    <!--<td>{{$s_type}}</td>-->
                                    <td>
                                        <div>
                                        <img class="zoom_img" src="{{$sn->signin_img}}"  style="height: 5rem; width: 5rem;">
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
</div>
@endsection


@section('app_js')
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script>
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
        "oSearch": {"sSearch": ""},
        "columnDefs": [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
    } );
} );

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
        "oSearch": {"sSearch": st_id},
        "columnDefs": [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
    } );
    });
});

var zoom_img=document.querySelectorAll(".zoom_img")
zoom_img.forEach(function(item,index){
    item.addEventListener("click", function() {
        console.log(this.src)
        document.getElementById("zoom_result").src=this.src;
        $('#zoomModal').modal('show');
    });
});

</script>
@endsection

