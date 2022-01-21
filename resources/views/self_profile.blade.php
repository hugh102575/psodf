@extends('home')

@section('css')
<style>
.enlarge_text{
  font-size: x-large !important;
}
</style>
@endsection

@section('stage')
<form action="{{ route('self_profile.update') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal fade" id="profileNameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
            <div class="container-fluid">

                <div class="form-group">
                    <label for="profileName" class="font-weight-bold my_nav_text enlarge_text">姓名更改</label>
                    <input class="form-control" type="text" id="profileName" name="profileName" placeholder="請輸入欲更改的姓名" required="required" value="{{Auth::user()->name}}"  maxlength="30">
                </div>
                <div class="form-group">
                <div class="float-right">
                <a href="#" class="btn btn-secondary" id="profileName_cancel">取消</a>
                <button type="submit" name="button" value="m1" class="btn text-light my_nav_color">儲存</button>
                </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
</form>


<form action="{{ route('self_profile.update') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal fade" id="profilePWModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
            <div class="container-fluid">

                <div class="form-group">
                    <label for="profilePW_old" class="font-weight-bold my_nav_text enlarge_text">密碼</label>
                    <input class="form-control" type="password" id="profilePW_old" name="profilePW_old" placeholder="請輸入密碼" required="required" value=""  maxlength="30">
                </div>

                <div class="form-group">
                    <label for="profilePW_new" class="font-weight-bold my_nav_text enlarge_text">新密碼</label>
                    <input class="form-control" type="password" id="profilePW_new" name="profilePW_new" placeholder="請輸入新密碼" required="required" value=""  maxlength="30">
                </div>

                <div class="form-group">
                    <label for="profilePW_new2" class="font-weight-bold my_nav_text enlarge_text">新密碼確認</label>
                    <input class="form-control" type="password" id="profilePW_new2" name="profilePW_new2" placeholder="請再輸入一次新密碼" required="required" value=""  maxlength="30">
                </div>



                <div class="form-group">
                <div class="float-right">
                <a href="#" class="btn btn-secondary" id="profilePW_cancel">取消</a>
                <button type="submit" name="button" value="m2" class="btn text-light my_nav_color">儲存</button>
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
            <div class="col-md-8">
              <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">個人資料更改</h5>
                    </div>
                    <div class="card-body">
                        <div class="card p-3 px-5">
                          <div class="form-group row ">
                            <div class="mx-auto col-sm-6" >
                            <button type="button" class="form-control btn my_nav_color text-light" data-target="#profileNameModal" data-toggle="modal">姓名更改</button>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="mx-auto col-sm-6" >
                            <button type="button" class="form-control btn my_nav_color text-light" data-target="#profilePWModal" data-toggle="modal">密碼更改</button>
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
<script>
document.getElementById('nav_title').innerHTML="<small>個人資料更改</small>";

$('#profileName_cancel').click(function() {
    $('#profileNameModal').modal('hide');
});

$('#profilePW_cancel').click(function() {
    $('#profilePWModal').modal('hide');
});


</script>
@endsection
