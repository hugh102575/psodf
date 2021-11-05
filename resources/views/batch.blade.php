@extends('home')


@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<style>
</style>
@endsection

@section('stage')
<form action="{{ route('batch.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal fade" id="BatchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                    <label for="Batch_Name" class="font-weight-bold my_nav_text enlarge_text">新梯次名稱</label>
                    <input class="form-control" type="text" name="Batch_Name" placeholder="請輸入梯次名稱，例如平日班、暑期班等" required="required" value="" maxlength="30">
                </div>
                <div class="form-group">
                    <label for="Batch_memo" class="font-weight-bold my_nav_text enlarge_text">備註</label>
                    <textarea  name="Batch_memo" class="form-control" rows="6" placeholder="(選填) 請輸入備註"></textarea>
                </div>
                <div class="form-group">
                <div class="float-right">
                <a href="#" class="btn btn-secondary" id="batch_store_cancel">取消</a>
                <button type="submit" class="btn text-light my_nav_color">儲存</button>
                </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
</form>

<form action="{{ route('batch.update') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal fade" id="BatchModal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
            <div class="container-fluid">
                <div class="form-group">
                    <label for="Batch_Name" class="font-weight-bold my_nav_text enlarge_text">梯次名稱</label>

                    <input class="form-control" id="Batch_Name_edit" type="text" name="Batch_Name" placeholder="請輸入梯次名稱，例如平日班、暑期班等" required="required" value="" maxlength="30">
                </div>

                <div class="form-group">
                    <label for="Batch_memo" class="font-weight-bold my_nav_text enlarge_text">備註</label>
                    <textarea  id="Batch_memo_edit" name="Batch_memo" class="form-control" rows="6" placeholder="(選填) 請輸入備註"></textarea>
                </div>


                <div class="form-group ">
                <button type="button" class="btn btn-link text-danger shadow-none" id="batch_edit_delete"><u>刪除</u></button>
                <div class="float-right">
                <input class="hidden_object" id="batch_update_id" name="batch_update_id" value="" >
                <a href="#" class="btn btn-secondary" id="batch_edit_cancel">取消</a>
                <button type="submit" class="btn text-light my_nav_color" id="batch_edit_submit">儲存</button>
                </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
</form>

<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex flex-row">
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">梯次</h5>
                        <div class="d-flex  float-right  ml-auto" >
                        @if(count($school_batch)==0)
                            <span class="text-success font-weight-bold">按這裡新增梯次 <i class="fas fa-arrow-right"></i></span>
                            @endif
                        <button type="button"   class="btn text-light btn-icon-split  my_nav_color  ml-3 mb-1 " data-target="#BatchModal" data-toggle="modal"><i class="fas fa-plus"></i> 新增梯次</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  table-hover text-center text-middle" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr class="my_nav_color text-light">
                                    <th>梯次名稱</th>
                                    <th>班級</th>
                                    <th>備註</th>
                                    <th>設定</th>
                                    <th class="hidden_object"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($school_batch as $batch)
                                @php
                                //$batch_ar=array();;
                                $batch_a='';
                                foreach($school_classs as $classs){
                                    if($classs->Batch_id==$batch->id){
                                        $batch_a=$batch_a.$classs->Classs_Name.', ';
                                        //array_push($batch_ar,$classs->Classs_Name);
                                    }
                                }
                                if($batch_a!=''){
                                    $batch_a=rtrim($batch_a, ", ");
                                }
                                @endphp
                                <tr>
                                    <td>{{ $batch->Batch_Name }}</td>

                                    <td><pre>{{$batch_a}}</pre></td>
                                    {{--<td>
                                    @foreach($batch_ar as $ba)
                                    <p class="mb-1">{{$ba}}</p>
                                    @endforeach
                                    </td>--}}
                                    <td><pre>{{ $batch->Batch_memo }}</pre></td>
                                    <td class="batch_edit_btn"><a href="#"><i class="fas fa-cogs my_nav_text" data-target="#BatchModal_edit" data-toggle="modal"></i></a></td>
                                    <td class="batch_edit_id hidden_object">{{ $batch->id }}</td>
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
document.getElementById('nav_title').innerHTML="<small>梯次</small>";
$('#batch_store_cancel').click(function() {
    $('#BatchModal').modal('hide');
});
$('#batch_edit_cancel').click(function() {
    $('#BatchModal_edit').modal('hide');
});

var school_batch={!! json_encode($school_batch) !!};
var batch_edit_btn=document.querySelectorAll('.batch_edit_btn');
var batch_edit_id=document.querySelectorAll('.batch_edit_id');
var c_id=null;
batch_edit_btn.forEach(function(item,index){
    item.addEventListener('click', function(){
        document.getElementById('Batch_Name_edit').value='';
        document.getElementById('Batch_memo_edit').value='';
        c_id=batch_edit_id[index].innerHTML;
        console.log('c_id',c_id)
        var where=school_batch.findIndex(x => x.id==c_id);
        if(where!=-1){
            document.getElementById('batch_update_id').value=school_batch[where].id;
            document.getElementById('Batch_Name_edit').value=school_batch[where].Batch_Name;
            if(school_batch[where].Batch_memo!=null){
                document.getElementById('Batch_memo_edit').value=school_batch[where].Batch_memo;
            }
        }
    })
})

$('#batch_edit_delete').click(function(){
    if (confirm('確定要刪除這個梯次嗎')) {
        $.ajax({
                    type:'POST',
                    url:'/batch/delete',
                    dataType:'json',
                    data:{
                    'id':c_id,
                    _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        console.log(data)
                        var result=data.result;
                            if(result=='success'){
                                window.location.href = "/batch"+"?success_msg="+data.msg;
                            }else{
                                window.location.href = "/batch"+"?error_msg="+data.msg;
                            }

                    },
                    error:function(e){
                        alert('Error: ' + e);
                    }
        });

       } else {
           return false;
       }

});
</script>
@endsection
