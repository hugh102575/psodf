@extends('home')

@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<style>
.inline-block {
  display: inline-block;
  text-align: left;
}
</style>
@endsection

@section('stage')
<form action="{{ route('message.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="MessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="Message_Name" class="font-weight-bold my_nav_text enlarge_text">新範本</label>
                        <input class="form-control" type="text" name="Message_Name" placeholder="請輸入範本名稱" required="required" value="" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="Message_Data" class="font-weight-bold my_nav_text enlarge_text">格式</label>
                        <textarea  name="Message_Data" class="form-control" rows="6" placeholder="請輸入格式" ></textarea>
                    </div>
                    <div class="form-group">
                    <div class="float-right">
                    <a href="#" class="btn btn-secondary" id="message_store_cancel">取消</a>
                    <button type="submit" class="btn text-light my_nav_color">儲存</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

<form action="{{ route('message.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="MessageModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="Message_Name" class="font-weight-bold my_nav_text enlarge_text">範本名稱</label>

                        <input class="form-control" id="Message_Name_edit" type="text" name="Message_Name" placeholder="請輸入欲更改範本名稱" required="required" value="" maxlength="30">
                    </div>

                    <div class="form-group">
                        <label for="Message_Data" class="font-weight-bold my_nav_text enlarge_text">格式</label>
                        <textarea  id="Message_Data_edit" name="Message_Data" class="form-control" rows="6" placeholder="請輸入欲更改格式"></textarea>
                    </div>


                    <div class="form-group ">
                    <button type="button" class="btn btn-link text-danger astext" id="message_edit_delete" ><i class="fas fa-trash-alt"></i> 刪除</button>
                    <div class="float-right">
                    <input class="hidden_object" id="message_update_id" name="message_update_id" value="" >
                    <a href="#" class="btn btn-secondary" id="message_edit_cancel">取消</a>
                    <button type="submit" class="btn text-light my_nav_color" id="message_edit_submit">儲存</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

<form action="{{ route('message.delete') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="Confirm_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                    <div class="form-group mb-5">
                    <h4 class=" text-danger">確定要刪除以下範本嗎？</h4>
                    <h3 class="text-primary enlarge_text" id="confirm_delete_classs"></h3>
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

<form name="message_send_form" action="{{ route('message.send') }}" method="POST" enctype="multipart/form-data" >
@csrf
    <div class="modal fade" id="MessageModal_send" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group row">
                        <div class="col">
                            <label for="Message_Name" class="font-weight-bold my_nav_text enlarge_text">範本名稱</label>
                            <input class="form-control" id="Message_Name_send" type="text" name="Message_Name"  required="required" value="" maxlength="30" style="width: 300px;" readonly>
                        </div>
                        <div class="col">
                            <label for="Message_Data" class="font-weight-bold my_nav_text enlarge_text">訊息格式</label>
                            <textarea  id="Message_Data_send" name="Message_Data" class="form-control" rows="6"  style="width: 300px;" ></textarea>
                        </div>
                    </div>
              
                    <div>
                        <p class="mb-3  " style="font-size:15px;color:#ff0000";>*家長若未加入，則無法勾選</p>

                    </div>
                    <div class="form-group ">
                        <div id="accordion">
                            @foreach($school_classs as $key => $value)
                            @if(count($value->student)!=0)
                            <div class="card ">
                                <div class="card-header" id='heading<?php echo $key; ?>'>
                                <h5 class="mb-0 collapsed">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $key; ?>" aria-expanded="false" aria-controls="collapse<?php echo $key; ?>">
                                    {{$value->Classs_Name}}
                                    </button>
                                </h5>
                                </div>
                                <div id="collapse<?php echo $key; ?>" class="collapse" aria-labelledby="heading<?php echo $key; ?>" data-parent="#accordion">
                                <div class="card-body">
                                    <p>
                                    <input type="checkbox" id="all_<?php echo $key; ?>" name="all" value="all<?php echo $key; ?>" onclick="check_all('all_<?php echo $key; ?>','checknum_<?php echo $key; ?>')" >
                                    <label for="all_<?php echo $key; ?>">全選</label>
                                    </p>
                                    <div id="checkboxs">
                                    @foreach($all_student as $j => $i)
                                        @if($i->Classs_id == $value->id)
                                            @if(is_null($i->parent_line_multi_notify))
                                            <p>
                                            <input class="checknum_<?php echo $key; ?>" type="checkbox" id="student_<?php echo $i->STU_id;?>" name="student_<?php echo $i->STU_id; ?>"  value="{{$i->parent_line_multi_notify}}" onclick="setAll('all_<?php echo $key; ?>',<?php echo $key; ?>)" disabled='disabled'>
                                            <label for="student_<?php echo $i->STU_id;?>" >{{$i->name}}</label>
                                            </p>
                                            @else
                                            <p>
                                            <input class="checknum_<?php echo $key; ?>" type="checkbox" id="student_<?php echo $i->STU_id;?>" name="student_<?php echo $i->STU_id; ?>"  value="{{$i->parent_line_multi_notify}}" onclick="setAll('all_<?php echo $key; ?>',<?php echo $key; ?>)">
                                            <label for="student_<?php echo $i->STU_id;?>" >{{$i->name}}</label>
                                            </p>
                                            @endif
                                            {{--@if(is_null($i->parent_line_multi))
                                            <p>
                                            <input class="checknum_<?php echo $key; ?>" type="checkbox" id="student_<?php echo $i->STU_id;?>" name="student_<?php echo $i->STU_id; ?>"  value="{{$i->parent_line_multi}}" onclick="setAll('all_<?php echo $key; ?>',<?php echo $key; ?>)" disabled='disabled'>
                                            <label for="student_<?php echo $i->STU_id;?>" >{{$i->name}}</label>
                                            </p>
                                            @else
                                            <p>
                                            <input class="checknum_<?php echo $key; ?>" type="checkbox" id="student_<?php echo $i->STU_id;?>" name="student_<?php echo $i->STU_id; ?>"  value="{{$i->parent_line_multi}}" onclick="setAll('all_<?php echo $key; ?>',<?php echo $key; ?>)">
                                            <label for="student_<?php echo $i->STU_id;?>" >{{$i->name}}</label>
                                            </p>
                                            @endif--}}

                                        {{--@if(Auth::user()->school->line_mode=="official")
                                        
                                            @if(is_null($i->parent_line_multi))
                                            <p>
                                            <input class="checknum_<?php echo $key; ?>" type="checkbox" id="student_<?php echo $i->STU_id;?>" name="student_<?php echo $i->STU_id; ?>"  value="{{$i->parent_line_multi}}" onclick="setAll('all_<?php echo $key; ?>',<?php echo $key; ?>)" disabled='disabled'>
                                            <label for="student_<?php echo $i->STU_id;?>" >{{$i->name}}</label>
                                            </p>
                                            @else
                                            <p>
                                            <input class="checknum_<?php echo $key; ?>" type="checkbox" id="student_<?php echo $i->STU_id;?>" name="student_<?php echo $i->STU_id; ?>"  value="{{$i->parent_line_multi}}" onclick="setAll('all_<?php echo $key; ?>',<?php echo $key; ?>)">
                                            <label for="student_<?php echo $i->STU_id;?>" >{{$i->name}}</label>
                                            </p>
                                            @endif

                                        @elseif(Auth::user()->school->line_mode=="notify")
                                            @if(is_null($i->parent_line_multi_notify))
                                            <p>
                                            <input class="checknum_<?php echo $key; ?>" type="checkbox" id="student_<?php echo $i->STU_id;?>" name="student_<?php echo $i->STU_id; ?>"  value="{{$i->parent_line_multi_notify}}" onclick="setAll('all_<?php echo $key; ?>',<?php echo $key; ?>)" disabled='disabled'>
                                            <label for="student_<?php echo $i->STU_id;?>" >{{$i->name}}</label>
                                            </p>
                                            @else
                                            <p>
                                            <input class="checknum_<?php echo $key; ?>" type="checkbox" id="student_<?php echo $i->STU_id;?>" name="student_<?php echo $i->STU_id; ?>"  value="{{$i->parent_line_multi_notify}}" onclick="setAll('all_<?php echo $key; ?>',<?php echo $key; ?>)">
                                            <label for="student_<?php echo $i->STU_id;?>" >{{$i->name}}</label>
                                            </p>
                                            @endif
                                        @else
                                            <p>
                                            <input class="checknum_<?php echo $key; ?>" type="checkbox" id="student_<?php echo $i->STU_id;?>" name="student_<?php echo $i->STU_id; ?>"  value="{{$i->parent_line_multi}}" onclick="setAll('all_<?php echo $key; ?>',<?php echo $key; ?>)" disabled='disabled'>
                                            <label for="student_<?php echo $i->STU_id;?>" >{{$i->name}}</label><small class="text-danger"> (請先設定LINE串接)</small>
                                            </p>
                                        @endif--}}


                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group ">
                    <div class="float-right">
                    <input class="hidden_object" id="message_update_id" name="message_update_id" value="" >
                    <a href="#" class="btn btn-secondary" id="message_send_cancel">取消</a>
                    <button type="submit" class="btn text-light my_nav_color" id="message_send_submit" onclick="return false">發送</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex flex-row" >
                    <h5 class="font-weight-bold text-success mr-5 my_nav_text">訊息</h5>
                    <div class="d-flex  float-right  ml-auto" >
                            @if(count($all_message)==0)
                            <span class="text-success font-weight-bold">按這裡新增訊息範本 <i class="fas fa-arrow-right"></i></span>
                            @endif
                        <button type="button"   class="btn text-light btn-icon-split  my_nav_color ml-3 mb-1" data-target="#MessageModal" data-toggle="modal"><i class="fas fa-plus"></i> 新增訊息格式</button>
                    </div>
                </div>

                <div class="card-body">
                <small class="mb-3 text-secondary">「@Name」等關鍵字將自動轉換，其他關鍵字請<a id="keyword_hint" href="#">點這裡</a>查看</small>
                    {{--<div class="mb-3">
                        <span class="small">快速搜尋:</span>
                        @foreach($all_message as $bt)
                        <button class="btn btn-link show_btns shadow-none" id="show_btns_{{$loop->index+1}}" type="button"><small>{{$bt->name}}</small></button>
                        <label class="hidden_object" id="show_btns_value_{{$loop->index+1}}">{{$bt->name}}</label>
                        @endforeach
                        <button class="btn btn-link  shadow-none" type="button" id="show_all_btn"><small>全部</small></button>
                    </div>--}}
                    <div class="table-responsive">
                        <table id="message_table" class="table dataTable table-hover text-center text-middle table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class="my_nav_color text-light">
                                <th>範本名稱</th>
                                <th>內容</th>
                                <th class="no-sort">修改</th>
                                <th class="no-sort">套用</th>
                                <th class="hidden_object"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($all_message as $message)
                            <tr>
                                <td>{{ $message->name }}</td>{{--  {{route('classs.student',$classs->id)}}  --}}
                                <td>
                                <div class="inline-block">
                                    <pre>{{ $message->data }}</pre>
                                </div>
                                </td>
                                <td class="message_edit_btn"><a class="my_nav_text"  href="#" data-target="#MessageModal_edit" data-toggle="modal"><i class="fas fa-pencil-alt" ></i> 編輯</a></td>
                                <td class="message_send_btn"><a class="my_nav_text" href="#" data-target="#MessageModal_send" data-toggle="modal"><i class="fas fa-paper-plane my_nav_text"></i> 發送</a></td>
                                <td class="message_edit_id hidden_object">{{$message->id}}</td>
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
<script>
document.getElementById('nav_title').innerHTML="<small>訊息發送</small>";
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


});
$('#message_store_cancel').click(function() {
    $('#MessageModal').modal('hide');
});
$('#message_edit_cancel').click(function() {
    $('#MessageModal_edit').modal('hide');
});
$('#confirm_delete_cancel').click(function() {
    $('#Confirm_delete').modal('hide');
});
$('#message_send_cancel').click(function() {
    $('#MessageModal_send').modal('hide');
});
$('#message_send_submit').click(function(){
        var Checkboxes = $("input[type='checkbox']:checked").length;
        console.log(Checkboxes);
        if(Checkboxes==0){
            alert("請選擇發送對象");
        }
        else{
            document.message_send_form.submit();
        }
    });

$('#search_result_div').hide();
$('#search_student_btn').click(function() {
    //document.getElementById('student_name').value='';
    $('#search_result_div').hide();
});

function check_all(id,classs_id)
{
    //var checkboxs = document.getElementsByName(cName);
    //for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
    var allcheck=document.getElementById(id);
        var choice=document.getElementsByClassName(classs_id);
        for(var i=0;i<choice.length;i++){
            console.log(choice[i].disable);
            if(choice[i].disabled!=true){
                choice[i].checked=allcheck.checked;
            }
        }
}
function setAll(id,key){
        if(!$('.checknum'+key).checked){
            $('#'+id).prop("checked",false); // 子複選框某個不選擇，全選也被取消
        }
        var choicelength=$("input[type='checkbox'][class='checknum_"+key+"']").length;
        var choiceselect=$("input[type='checkbox'][class='checknum_"+key+"']:checked").length;
        if(choicelength==choiceselect){
            $('#'+id).prop("checked",true);   // 子複選框全部部被選擇，全選也被選擇；1.對於HTML元素我們自己自定義的DOM屬性，在處理時，使用attr方法；2.對於HTML元素本身就帶有的固有屬性，在處理時，使用prop方法。
        }

}

var all_message={!! json_encode($all_message) !!};
console.log('all_message',all_message)
var message_send_btn=document.querySelectorAll('.message_send_btn');
var message_send_id=document.querySelectorAll('.message_edit_id');
//var message_checkbox=document.querySelectorAll('#checkboxs');
var m_id=null;
message_send_btn.forEach(function(item,index){
    item.addEventListener('click', function(){
        document.getElementById('Message_Name_send').value='';
        document.getElementById('Message_Data_send').value='';
        m_id=message_send_id[index].innerHTML;
        console.log('m_id',m_id)
        var where=all_message.findIndex(x => x.id==m_id);
        if(where!=-1){
            console.log(where)
            document.getElementById('message_update_id').value=all_message[where].id;
            document.getElementById('Message_Name_send').value=all_message[where].name;
            if(all_message[where].data!=null){
                document.getElementById('Message_Data_send').value=all_message[where].data;
            }
        }


    })
})

var all_message={!! json_encode($all_message) !!};
var message_edit_btn=document.querySelectorAll('.message_edit_btn');
var message_edit_id=document.querySelectorAll('.message_edit_id');
var m_id=null;
message_edit_btn.forEach(function(item,index){
    item.addEventListener('click', function(){
        document.getElementById('Message_Name_edit').value='';
        document.getElementById('Message_Data_edit').value='';
        m_id=message_edit_id[index].innerHTML;
        console.log('m_id',m_id)
        var where=all_message.findIndex(x => x.id==m_id);
        if(where!=-1){
            document.getElementById('message_update_id').value=all_message[where].id;
            document.getElementById('Message_Name_edit').value=all_message[where].name;
            if(all_message[where].data!=null){
                document.getElementById('Message_Data_edit').value=all_message[where].data;
            }
        }
    })
})

$('#message_edit_delete').click(function(){
    /*document.getElementById('confirm_delete_id').value=c_id;
    var where=school_classs.findIndex(x => x.id==c_id);
        if(where!=-1){
    document.getElementById('confirm_delete_classs').innerHTML="「"+school_classs[where].Classs_Name+"」";
        }*/
        if (confirm('確定要刪除這個訊息範本嗎')) {
            $.ajax({
                    type:'POST',
                    url:'/message/delete',
                    dataType:'json',
                    data:{
                    'id':m_id,
                    _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        console.log(data)
                        var result=data.result;
                            if(result=='success'){
                                window.location.href = "/message"+"?success_msg="+data.msg;
                            }else{
                                window.location.href = "/message"+"?error_msg="+data.msg;
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

/*
var show_all_btn=document.getElementById('show_all_btn');
show_all_btn.addEventListener("click", function() {
    $('#message_table').DataTable({
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
var show_btns=document.querySelectorAll(".show_btns")
show_btns.forEach(function(item,index){
        var btn=document.getElementById(item.id);
        var btn_id=(item.id).replace("show_btns_", "");
        var btn_value=document.getElementById('show_btns_value_'+btn_id).innerHTML;
        btn.addEventListener("click", function() {
            $('#message_table').DataTable({
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
                "oSearch": {"sSearch": btn_value}
            } );
        });
    });*/

    $('#keyword_hint').click(function(){
    var msg="@Name  學生姓名\n@School  安親班名稱\n@Phone  安親班電話";
    alert(msg);
});
</script>
@endsection
