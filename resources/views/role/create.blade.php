@extends('home')

@section('css')
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
            <form action="{{ route('role.create_post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">新增角色</h5>
                    </div>
                    <div class="card-body">

                        <div class="card py-4 px-5">
                            <div class="form-group row">
                                <label for="Role_Name" class="col-sm-2 col-form-label">角色名稱 <font color="#FF0000">*</font></label>
                                <div class="col-sm-10">
                                    <input name="Role_Name" type="text" class="form-control" maxlength="20" id="Role_Name" placeholder="請輸入角色名稱" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Role_Desc" class="col-sm-2 col-form-label">角色說明</label>
                                <div class="col-sm-10">
                                    <textarea name="Role_Desc" class="form-control" rows="5" maxlength="250" placeholder="(選填)請輸入角色說明"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">角色權限</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_classs" name="authority[]" value="classs">
                                        <label class="form-check-label" for="checkbox_classs">班級</label>
                                    </div>
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_sign" name="authority[]" value="sign">
                                        <label class="form-check-label" for="checkbox_sign">簽到退查詢</label>
                                    </div>
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_message" name="authority[]" value="message">
                                        <label class="form-check-label" for="checkbox_message">訊息</label>
                                    </div>
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_line" name="authority[]" value="line">
                                        <label class="form-check-label" for="checkbox_line">Line串接</label>
                                    </div>
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_sys" name="authority[]" value="sys">
                                        <label class="form-check-label" for="checkbox_sys">設定</label>
                                    </div>
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_account" name="authority[]" value="account">
                                        <label class="form-check-label" for="checkbox_account">帳號權限</label>
                                    </div>
                                </div>
                            </div>
                            
                          

                        </div>

                        <button  type="submit" class="mt-3 btn my_nav_color text-light float-right">新增角色</button>
                    </div>
                </div>
            </form>
                                




            </div>
        </div>
</div>
@endsection

@section('js')
<script>
document.getElementById('nav_title').innerHTML="<small>新增角色</small>";
</script>
@endsection
