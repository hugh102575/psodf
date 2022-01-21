@extends('home')

@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<style>
.zoom_img {
    cursor: pointer;
}
</style>
@endsection

@section('stage')
<div class="modal fade" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
            <div class="container-fluid">
            <button type="button" class="close mb-3" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
                <div class="form-group text-center">
                    <img class="img-fluid mb-3"id="zoom_result"/>
                    <div class="enlarge_text" id="zoom_result_name"></div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>

<form action="{{ route('classs.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal fade" id="ClasssModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <!--<div class="modal-header">
        <h5 class="modal-title">新增類別</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>-->
        <div class="modal-body">
            <div class="container-fluid">
                <div class="form-group">
                    <label for="Classs_Name" class="font-weight-bold my_nav_text enlarge_text">新班級名稱</label>
                    <input class="form-control" type="text" name="Classs_Name" placeholder="請輸入班級名稱" required="required" value="" maxlength="30">
                </div>

                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">梯次</label>
                    <select class="form-select form-control" name="Batch_id" aria-label="Default select example" required="required">

                        <option value=""  selected disabled hidden>請選擇梯次</option>
                        @foreach($school_batch as $batch)

                            <option  value="{{$batch->id}}">{{$batch->Batch_Name}}</option>
                        @endforeach



                    </select>
                </div>


                <div class="form-group">
                    <label for="Classs_memo" class="font-weight-bold my_nav_text enlarge_text">備註</label>
                    <textarea  name="Classs_memo" class="form-control" rows="6" placeholder="(選填) 請輸入備註"></textarea>
                </div>
                <div class="form-group">
                <div class="float-right">
                <a href="#" class="btn btn-secondary" id="classs_store_cancel">取消</a>
                <button type="submit" class="btn text-light my_nav_color">儲存</button>
                </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
</form>

<form action="{{ route('classs.update') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal fade" id="ClasssModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <!--<div class="modal-header">
        <h5 class="modal-title">新增類別</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>-->
        <div class="modal-body">
            <div class="container-fluid">
                <div class="form-group">
                    <label for="Classs_Name" class="font-weight-bold my_nav_text enlarge_text">班級名稱</label>

                    <input class="form-control" id="Classs_Name_edit" type="text" name="Classs_Name" placeholder="請輸入類別名稱" required="required" value="" maxlength="30">
                </div>

                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">梯次</label>
                    <select id="Batch_id" name="Batch_id" class="form-select form-control" name="Batch_id" aria-label="Default select example" required="required">

                        <option value=""  selected disabled hidden>請選擇梯次</option>
                        @foreach($school_batch as $batch)

                            <option  value="{{$batch->id}}">{{$batch->Batch_Name}}</option>
                        @endforeach



                    </select>
                </div>



                <div class="form-group">
                    <label for="Classs_memo" class="font-weight-bold my_nav_text enlarge_text">備註</label>
                    <textarea  id="Classs_memo_edit" name="Classs_memo" class="form-control" rows="6" placeholder="(選填) 請輸入備註"></textarea>
                </div>


                <div class="form-group ">
                <button type="button" class="btn btn-link text-danger  astext" id="classs_edit_delete" ><i class="fas fa-trash-alt"></i> 刪除</button>
                <div class="float-right">
                <input class="hidden_object" id="classs_update_id" name="classs_update_id" value="" >
                <a href="#" class="btn btn-secondary" id="classs_edit_cancel">取消</a>
                <button type="submit" class="btn text-light my_nav_color" id="classs_edit_submit">儲存</button>
                </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
</form>


<div class="modal fade" id="Student_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
            <div class="container-fluid">

                <div class="form-group">
                    <label for="student_name" class="font-weight-bold my_nav_text enlarge_text">查詢學生班級</label>
                    <input class="form-control"  type="text"  id="student_name" placeholder="請輸入學生姓名" required="required" value="" >
                </div>

                <div id="search_result_div" class="form-group hidden_object">
                    <label class="font-weight-bold my_nav_text enlarge_text">查詢結果</label>
                    <div id="search_result">
                    </div>
                </div>






                <div class="form-group ">
                <div class="float-right">
                <a href="#" class="btn btn-secondary" id="student_search_cancel">取消</a>
                <button type="button" class="btn text-light my_nav_color" id="student_search_submit">查詢</button>
                </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>



<div class="modal fade" id="Student_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
            <div class="container-fluid">
                <div class="form-group">
                    <label  class="font-weight-bold my_nav_text enlarge_text">學生資料</label>
                </div>
                <div class="form-group">
                    <table class="table table-bordered">

                    <tbody>
                        <tr class="hidden_object">
                            <td >id</td>
                            <td>
                            <input class="form-control"  type="text" id="st_id"    required="required" value="" >
                            </td>
                        </tr>
                        <tr>
                            <td>姓名 (必填)<span class="text-danger">*</span></td>
                            <td>
                            <input class="form-control"  type="text" id="st_name" name="name"  placeholder="請輸入姓名" required="required" value="" >
                            </td>
                        </tr>
                        <tr>
                            <td>學號</td>
                            <td>
                            <p id="st_STU_id"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>班級 (必填)<span class="text-danger">*</span><p><small class="text-info">可在此設定轉班</small></p></td>
                            <td>
                            <select id="st_Classs_id" name="Classs_id" class="form-select form-control"  aria-label="Default select example" required="required">

                            @foreach($school_classs as $classs)

                                <option  value="{{$classs->id}}">{{$classs->Classs_Name}}</option>
                            @endforeach



                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>性別</td>
                            <td>
                            <select class="form-select form-control" id="st_gender" name="gender" aria-label="Default select example" required="required">


                            <option  value="null"></option>
                            <option  value="男">男</option>
                            <option  value="女">女</option>


                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>學校</td>
                            <td>
                            <input class="form-control"  type="text" id="st_school" name="school"  placeholder="請輸入學校" required="required" value="" >
                            </td>
                        </tr>
                        <tr>
                            <td>年級</td>
                            <td id="st_gender">
                            <select class="form-select form-control" id="st_grade" name="grade" aria-label="Default select example" required="required">


                            <option  value="null"></option>
                            <option  value="小一">小一</option>
                            <option  value="小二">小二</option>
                            <option  value="小三">小三</option>
                            <option  value="小四">小四</option>
                            <option  value="小五">小五</option>
                            <option  value="小六">小六</option>
                            <option  value="國一">國一</option>
                            <option  value="國二">國二</option>
                            <option  value="國三">國三</option>



                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>家長姓名</td>
                            <td>
                            <input class="form-control"  type="text" id="st_parent_name" name="parent_name"  placeholder="請輸入家長姓名" required="required" value="" >
                            </td>
                        </tr>
                        <tr>
                            <td>家長電話</td>
                            <td>
                            <input class="form-control"  type="text" id="st_parent_phone" name="parent_phone"  placeholder="請輸入家長電話" required="required" value="" >
                            </td>
                        </tr>
                        <tr>
                            <td>家長的LINE</td>
                            <td>
                            <p id="st_parent_line"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>相片建檔</td>
                            <td id="st_profile">

                            </td>
                        </tr>
                        <tr>
                            <td>附註</td>
                            <td>
                            <textarea  id="st_memo" name="memo" class="form-control" rows="6" placeholder="(選填) 請輸入備註"></textarea>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>








                <div class="form-group ">
                <button type="button" class="btn btn-link text-danger  astext" id="student_update_delete" ><i class="fas fa-trash-alt"></i> 刪除</button>

                <div class="float-right">
                <a href="#" class="btn btn-secondary" id="student_update_cancel">取消</a>
                <button type="button" id="student_update_submit" class="btn text-light my_nav_color" >更新</button>
                </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>


<form action="{{ route('classs.delete') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal fade" id="Confirm_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <!--<div class="modal-header">
        <h5 class="modal-title">新增類別</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>-->
        <div class="modal-body">
            <div class="container-fluid">
            <div class="form-group mb-5">
            <h4 class=" text-danger">確定要刪除以下班級嗎?(包含學生資料)</h4>
            <h3 class="text-primary enlarge_text" id="confirm_delete_classs"></h3>
            </div>
                <div class="form-group">
                    <label for="password" class="font-weight-bold my_nav_text enlarge_text">密碼</label>
                    <input class="hidden_object" name="confirm_delete_id" id="confirm_delete_id" value="" >
                    <input class="form-control"  type="password" name="password" placeholder="請輸入密碼" required="required" value="" >
                </div>




                <div class="form-group ">
                <div class="float-right">
                <a href="#" class="btn btn-secondary" id="confirm_delete_cancel">取消</a>
                <button type="submit" class="btn btn-danger" >刪除</button>
                </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
</form>
@if(count($school_batch)==0)
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">班級資料</h5>
                    </div>
                    <div class="card-body">
                    您尚未新增梯次喔，<a  class="" href="{{route('batch')}}">點我前往</a>
                    </div>
                </div>




            </div>
        </div>
</div>

@else
<div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">班級資料</h5>
                        <div class="d-flex  float-right  ml-auto" >
                        {{--<button type="button" id="search_student_btn"  class="btn text-light btn-icon-split  my_nav_color ml-3 mb-1" data-target="#Student_search" data-toggle="modal" ><i class="fas fa-search"></i> 查詢班級</button>
                            --}}
                            @if(count($school_classs)==0)
                            <span class="text-success font-weight-bold">按這裡新增班級 <i class="fas fa-arrow-right"></i></span>
                            @endif
                        <button type="button"   class="btn text-light btn-icon-split  my_nav_color ml-3 mb-1" data-target="#ClasssModal" data-toggle="modal"><i class="fas fa-plus"></i> 新增班級</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <span class="small">搜尋梯次:</span>
                        @foreach($school_batch as $bt)
                        <button class="btn btn-link show_btns shadow-none" id="show_btns_{{$loop->index+1}}" type="button"><small>{{$bt->Batch_Name}}</small></button>
                        <label class="hidden_object" id="show_btns_value_{{$loop->index+1}}">{{$bt->Batch_Name}}</label>
                        @endforeach
                        <button class="btn btn-link  shadow-none" type="button" id="show_all_btn"><small>全部梯次</small></button>
                        </div>
                        <div class="table-responsive">
                            <table id="classs_table" class="table dataTable table-hover text-center text-middle table-bordered"  width="100%" cellspacing="0">
                                <thead>
                                <tr class="my_nav_color text-light">
                                    <th>班級名稱</th>
                                    <th>梯次</th>
                                    <th>學生數</th>
                                    <th>備註</th>
                                    <th class="no-sort">學生名單</th>
                                    <th  class="no-sort">設定</th>
                                    <th class="hidden_object"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($school_classs as $classs)
                                <tr>
                                    <td>{{ $classs->Classs_Name }}</td>{{--  {{route('classs.student',$classs->id)}}  --}}
                                    <td>{{$classs->batch->Batch_Name}}</td>
                                    <td>{{count($classs->student) }}</td>
                                    <td><pre>{{ $classs->Classs_memo }}</pre></td>
                                    {{--<td class="classs_edit_btn"><a href="#"><img alt="edit" src="{{asset('img/setting_icon.png')}}"  data-target="#ClasssModal_edit" data-toggle="modal"></a></td>--}}
                                    <td>
                                    @if(count($classs->student)==0)
                                    <span class="text-success font-weight-bold mr-3">按這裡新增學生 <i class="fas fa-arrow-right"></i></span>
                                    @endif
                                        <a href="{{route('classs.student',$classs->id)}}" class="my_nav_text"><i class="fas fa-user-edit"></i> 編輯</a>
                                    </td>
                                    <td class="classs_edit_btn"><a href="#"><i class="fas fa-cogs my_nav_text" data-target="#ClasssModal_edit" data-toggle="modal"></i></a></td>
                                    <td class="classs_edit_id hidden_object">{{ $classs->id }}</td>
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


        <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">學生一覽</h5>
                        {{--<div class="d-flex  float-right  ml-auto" >
                        <button type="button" id="search_student_btn"  class="btn text-light btn-icon-split  my_nav_color ml-3 mb-1" data-target="#Student_search" data-toggle="modal" ><i class="fas fa-search"></i> 查詢班級</button>

                        <button type="button"   class="btn text-light btn-icon-split  my_nav_color ml-3 mb-1" data-target="#ClasssModal" data-toggle="modal"><i class="fas fa-plus"></i> 新增班級</button>
                        </div>--}}
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                        <span class="small">搜尋班級:</span>
                        @foreach($school_classs as $sc)
                        <button class="btn btn-link show_btns2 shadow-none" id="show_btns2_{{$loop->index+1}}" type="button"><small>{{$sc->Classs_Name}}</small></button>
                        <label class="hidden_object" id="show_btns_value2_{{$loop->index+1}}">{{$sc->Classs_Name}}</label>
                        @endforeach
                        <button class="btn btn-link  shadow-none" type="button" id="show_all_btn2"><small>全部班級</small></button>
                        </div>
                        <div class="table-responsive">
                            <table id="student_table" class="table dataTable table-hover text-center text-middle table-bordered"  width="100%" cellspacing="0">
                                <thead>
                                <tr class="my_nav_color text-light">
                                    <th>學生姓名</th>
                                    <th>學號</th>
                                    <th>學生班級</th>
                                    <th>家長的LINE</th>
                                    <th class="no-sort">相片建檔</th>
                                    <th>備註</th>

                                    <th class="no-sort">設定</th>
                                    <th class="hidden_object"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($all_student as $student)

                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->STU_id }}</td>
                                    <td>{{$student->classs->Classs_Name}}</td>
                                    <td>
                                        @if($student->parent_line_multi==null)
                                        <span class="text-danger">尚未加入</span>
                                        @else
                                        @php
                                        $parent_count=count(json_decode($student->parent_line_multi));
                                        @endphp
                                        <span class="text-success">已加入 {{$parent_count}}位</span>
                                        @endif
                                    </td>
                                    <td>
                                    @if($student->profile!=null)
                                    <img class="zoom_img" style="height: 5rem; width: 5rem;" alt="{{$student->name}}" src="{{$student->profile}}" />
                                    @else
                                    <span class="text-danger">尚未建檔</span>
                                    @endif
                                    </td>
                                    <td><pre>{{$student->memo }}</pre></td>

                                    <td class="student_edit_btn"><a href="#"><i class="fas fa-cogs my_nav_text" data-target="#Student_update" data-toggle="modal"></i></a></td>
                                    <td class="student_edit_id hidden_object">{{ $student->id }}</td>
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


@endif
@endsection

@section('js')
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>

<script>
document.getElementById('nav_title').innerHTML="<small>班級資料</small>";
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
$('#classs_store_cancel').click(function() {
    $('#ClasssModal').modal('hide');
});
$('#classs_edit_cancel').click(function() {
    $('#ClasssModal_edit').modal('hide');
});
$('#confirm_delete_cancel').click(function() {
    $('#Confirm_delete').modal('hide');
});
$('#student_search_cancel').click(function() {
    $('#Student_search').modal('hide');
});
$('#student_update_cancel').click(function() {
    $('#Student_update').modal('hide');
});



$('#search_result_div').hide();
$('#search_student_btn').click(function() {
    //document.getElementById('student_name').value='';
    $('#search_result_div').hide();
});



var school_classs={!! json_encode($school_classs) !!};
var all_student={!! json_encode($all_student) !!};



console.log('school_classs',school_classs)
var classs_edit_btn=document.querySelectorAll('.classs_edit_btn');
var classs_edit_id=document.querySelectorAll('.classs_edit_id');
var c_id=null;
classs_edit_btn.forEach(function(item,index){
    item.addEventListener('click', function(){
        document.getElementById('Classs_Name_edit').value='';
        document.getElementById('Classs_memo_edit').value='';
        c_id=classs_edit_id[index].innerHTML;
        console.log('c_id',c_id)
        var where=school_classs.findIndex(x => x.id==c_id);
        if(where!=-1){
            document.getElementById('classs_update_id').value=school_classs[where].id;
            document.getElementById('Classs_Name_edit').value=school_classs[where].Classs_Name;
            if(school_classs[where].Batch_id!=null){
                document.getElementById('Batch_id').value=school_classs[where].Batch_id;
            }
            if(school_classs[where].Classs_memo!=null){
                document.getElementById('Classs_memo_edit').value=school_classs[where].Classs_memo;
            }
        }
    })
})

var student_edit_btn=document.querySelectorAll('.student_edit_btn');
var student_edit_id=document.querySelectorAll('.student_edit_id');
var s_id=null;
student_edit_btn.forEach(function(item,index){
    item.addEventListener('click', function(){
        document.getElementById('st_name').value='';
        document.getElementById('st_school').value='';
        document.getElementById('st_parent_name').value='';
        document.getElementById('st_parent_phone').value='';
        document.getElementById('st_memo').value='';
        document.getElementById('st_STU_id').value='';
        document.getElementById('st_parent_line').value="";
        document.getElementById('st_profile').innerHTML="";
        //document.getElementById('Classs_memo_edit').value='';
        s_id=student_edit_id[index].innerHTML;
        console.log('s_id',s_id)
        var where=all_student.findIndex(x => x.id==s_id);
        console.log('where',where)
        if(where!=-1){
            document.getElementById('st_id').value=all_student[where].id;
            document.getElementById('st_name').value=all_student[where].name;
            document.getElementById('st_Classs_id').value=all_student[where].Classs_id;
            document.getElementById('st_STU_id').innerHTML=all_student[where].STU_id;
            if(all_student[where].school!=null){
                document.getElementById('st_school').value=all_student[where].school;
            }
            if(all_student[where].parent_name!=null){
                document.getElementById('st_parent_name').value=all_student[where].parent_name;
            }
            if(all_student[where].parent_phone!=null){
                document.getElementById('st_parent_phone').value=all_student[where].parent_phone;
            }
            if(all_student[where].memo!=null){
                document.getElementById('st_memo').value=all_student[where].memo;
            }
            if(all_student[where].gender!=null){
                document.getElementById('st_gender').value=all_student[where].gender;
            }
            if(all_student[where].grade!=null){
                document.getElementById('st_grade').value=all_student[where].grade;
            }
            if(all_student[where].parent_line_multi!=null){
                var parent_count=JSON.parse(all_student[where].parent_line_multi);
                document.getElementById('st_parent_line').innerHTML="<span class='text-success'>"+"已加入 "+parent_count.length+"位"+"</span>";
            }else{
                document.getElementById('st_parent_line').innerHTML="<span class='text-danger'>"+"尚未加入"+"</span>";
            }
            if(all_student[where].profile!=null){
                document.getElementById('st_profile').innerHTML="<img style='height: 10rem; width: 10rem;' src="+all_student[where].profile+" />";
            }else{
                document.getElementById('st_profile').innerHTML="<span class='text-danger'>"+"尚未建檔"+"</span>";
            }


        }
    })
})
$('#student_update_submit').click(function(){
    var st = new Object();
    if(document.getElementById('st_name').value.length==0){
        alert("請填寫姓名")
    }else{
    var update_id = document.getElementById('st_id').value;
    st.name = document.getElementById('st_name').value;
    st.Classs_id = document.getElementById('st_Classs_id').value;
    st.school = document.getElementById('st_school').value;
    st.parent_name = document.getElementById('st_parent_name').value;
    st.parent_phone = document.getElementById('st_parent_phone').value;
    st.memo = document.getElementById('st_memo').value;
    st.gender = document.getElementById('st_gender').value;
    st.grade = document.getElementById('st_grade').value;
    var format = /[!@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?]+/;
    var fine_name = false
    if(format.test(st.name)){
        fine_name=false
    } else {
        fine_name=true
    }
    if(fine_name){
        $.ajax({
                        type:'POST',
                        url:'/student/'+update_id+'/update',
                        dataType:'json',
                        data:{
                        'student':st,
                        _token: '{{csrf_token()}}'
                        },
                        success:function(data){
                            console.log(data)
                            var result=data.result;
                            if(result=='success'){
                                //window.location.href = "/classs"+"?success_msg="+data.msg;
                                window.location.href = "/classs"+"?success_msg="+data.msg;
                            }else{
                                //window.location.href = "/classs"+"?error_msg="+data.msg;
                                window.location.href = "/classs"+"?error_msg="+data.msg;
                            }


                        },
                        error:function(e){
                            alert('Error: ' + e);
                        }
            });
    }else{
        alert("姓名不可包含特殊符號")
    }
    }

});
$('#student_update_delete').click(function(){
    var update_id = document.getElementById('st_id').value;
    if (confirm('確定要刪除這個學生嗎')) {
        $.ajax({
                    type:'POST',
                    url:'/student/'+update_id+'/delete',
                    dataType:'json',
                    data:{
                    _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        var result=data.result;
                        if(result=='success'){
                            //window.location.href = "/classs"+"?success_msg="+data.msg;
                            window.location.href = "/classs"+"?success_msg="+data.msg;
                        }else{
                            //window.location.href = "/classs"+"?error_msg="+data.msg;
                            window.location.href = "/classs"+"?error_msg="+data.msg;
                        }


                    },
                    error:function(e){
                        alert('Error: ' + e);
                    }
        });
    }else{
        return false;
    }
})



$('#classs_edit_delete').click(function(){
    /*document.getElementById('confirm_delete_id').value=c_id;
    var where=school_classs.findIndex(x => x.id==c_id);
        if(where!=-1){
    document.getElementById('confirm_delete_classs').innerHTML="「"+school_classs[where].Classs_Name+"」";
        }*/
        if (confirm('確定要刪除這個班級嗎')) {
            $.ajax({
                    type:'POST',
                    url:'/classs/delete',
                    dataType:'json',
                    data:{
                    'id':c_id,
                    _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        console.log(data)
                        var result=data.result;
                            if(result=='success'){
                                window.location.href = "/classs"+"?success_msg="+data.msg;
                            }else{
                                window.location.href = "/classs"+"?error_msg="+data.msg;
                            }

                    },
                    error:function(e){
                        alert('Error: ' + e);
                    }
            });
       } else {
           return false;
       }
})

$('#student_search_submit').click(function(){
    var student_name=document.getElementById('student_name').value;
    if(student_name.length==0){
        alert('請輸入要查詢的學生')
    }else{
        $.ajax({
                    type:'POST',
                    url:'/classs/student/search',
                    dataType:'json',
                    data:{
                    'student_name':student_name,
                    _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        var data=JSON.parse(data)
                        console.log('search_result',data);
                        if(data.classs.length!=0){
                            $('#search_result_div').show();
                            var result_classs=data.classs;
                            var result_student=data.student;
                            document.getElementById('search_result').innerHTML=result_classs;
                        }else{
                            $('#search_result_div').show();
                            document.getElementById('search_result').innerHTML='查無資料';
                        }


                    },
                    error:function(e){
                        alert('Error: ' + e);
                    }
        });
    }
});

var show_all_btn=document.getElementById('show_all_btn');
show_all_btn.addEventListener("click", function() {
    $('#classs_table').DataTable({
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
        "oSearch": {"sSearch": ""},
        "columnDefs": [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
    } );
});
var show_all_btn2=document.getElementById('show_all_btn2');
show_all_btn2.addEventListener("click", function() {
    $('#student_table').DataTable({
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
        "oSearch": {"sSearch": ""},
        "columnDefs": [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
    } );
});



var show_btns=document.querySelectorAll(".show_btns")
show_btns.forEach(function(item,index){
        var btn=document.getElementById(item.id);
        var btn_id=(item.id).replace("show_btns_", "");
        var btn_value=document.getElementById('show_btns_value_'+btn_id).innerHTML;
        btn.addEventListener("click", function() {
            $('#classs_table').DataTable({
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
                "oSearch": {"sSearch": btn_value},
        "columnDefs": [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
            } );
        });
    });


var show_btns2=document.querySelectorAll(".show_btns2")
show_btns2.forEach(function(item,index){
        var btn=document.getElementById(item.id);
        var btn_id=(item.id).replace("show_btns2_", "");
        var btn_value=document.getElementById('show_btns_value2_'+btn_id).innerHTML;
        btn.addEventListener("click", function() {
            $('#student_table').DataTable({
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
                "oSearch": {"sSearch": btn_value},
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
        document.getElementById("zoom_result_name").innerHTML=this.alt;
        $('#zoomModal').modal('show');
    });
});
</script>
@endsection
