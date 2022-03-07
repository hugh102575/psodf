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
            <form action="{{ route('role.edit_post',$roles->RoleID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">編輯角色</h5>
                    </div>
                    <div class="card-body">

                        <div class="card py-4 px-5">
                            <div class="form-group row">
                                <label for="Role_Name" class="col-sm-2 col-form-label">角色名稱 <font color="#FF0000">*</font></label>
                                <div class="col-sm-10">
                                    @if($roles->Role_Name=='安親班管理員')
                                    <input name="Role_Name" type="text" class="form-control" maxlength="20" id="Role_Name" value="{{ $roles->Role_Name }}" placeholder="請輸入角色名稱" required disabled>
                                    <input name="Role_Name" type="hidden"  value="{{ $roles->Role_Name }}" />
                                    @else
                                    <input name="Role_Name" type="text" class="form-control" maxlength="20" id="Role_Name" value="{{ $roles->Role_Name }}" placeholder="請輸入角色名稱"  required>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Role_Desc" class="col-sm-2 col-form-label">角色說明</label>
                                <div class="col-sm-10">
                                    <textarea name="Role_Desc" class="form-control" rows="5" maxlength="250" placeholder="(選填)請輸入角色說明" >{{ $roles->Role_Desc }}</textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">角色權限</label>
                                <div class="col-sm-10">
                                @if($roles->authority!='empty')
                                    @if(str_contains($roles->authority, 'classs'))
                                        @if($roles->Role_Name=='安親班管理員')
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="checkbox_classs" name="authority[]" value="classs" checked disabled>
                                            <label class="form-check-label" for="checkbox_classs">班級</label>
                                            <input type="hidden" name="authority[]" value="classs" />
                                        </div>
                                        @else
                                        <div class="form-check form-switch mb-1">
                                            <input class="form-check-input" type="checkbox" id="checkbox_classs" name="authority[]" value="classs" checked>
                                            <label class="form-check-label" for="checkbox_classs">班級</label>
                                        </div>
                                        @endif
                                    @else
                                        <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_classs" name="authority[]" value="classs">
                                        <label class="form-check-label" for="checkbox_classs">班級</label>
                                        </div>
                                    @endif

                                    @if(str_contains($roles->authority, 'sign'))
                                    @if($roles->Role_Name=='安親班管理員')
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_sign" name="authority[]" value="sign" checked disabled>
                                        <label class="form-check-label" for="checkbox_sign">簽到退查詢</label>
                                        <input type="hidden" name="authority[]" value="sign" />
                                    </div>
                                    @else
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_sign" name="authority[]" value="sign" checked>
                                        <label class="form-check-label" for="checkbox_sign">簽到退查詢</label>
                                    </div>
                                    @endif
                                    @else
                                    <div class="form-check form-switch mb-1">
                                    <input class="form-check-input" type="checkbox" id="checkbox_sign" name="authority[]" value="sign">
                                    <label class="form-check-label" for="checkbox_sign">簽到退查詢</label>
                                    </div>
                                    @endif

                                    @if(str_contains($roles->authority, 'message'))
                                    @if($roles->Role_Name=='安親班管理員')
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_message" name="authority[]" value="message" checked disabled>
                                        <label class="form-check-label" for="checkbox_message">訊息</label>
                                        <input type="hidden" name="authority[]" value="message" />
                                    </div>
                                    @else
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_message" name="authority[]" value="message" checked>
                                        <label class="form-check-label" for="checkbox_message">訊息</label>
                                    </div>
                                    @endif
                                    @else
                                    <div class="form-check form-switch mb-1">
                                    <input class="form-check-input" type="checkbox" id="checkbox_message" name="authority[]" value="message">
                                    <label class="form-check-label" for="checkbox_message">訊息</label>
                                    </div>
                                    @endif

                                    @if(str_contains($roles->authority, 'line'))
                                    @if($roles->Role_Name=='安親班管理員')
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_line" name="authority[]" value="line" checked disabled>
                                        <label class="form-check-label" for="checkbox_line">LINE串接</label>
                                        <input type="hidden" name="authority[]" value="line" />
                                    </div>
                                    @else
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_line" name="authority[]" value="line" checked>
                                        <label class="form-check-label" for="checkbox_line">LINE串接</label>
                                    </div>
                                    @endif
                                    @else
                                    <div class="form-check form-switch mb-1">
                                    <input class="form-check-input" type="checkbox" id="checkbox_line" name="authority[]" value="line">
                                    <label class="form-check-label" for="checkbox_line">LINE串接</label>
                                    </div>
                                    @endif

                                    @if(str_contains($roles->authority, 'sys'))
                                    @if($roles->Role_Name=='安親班管理員')
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_sys" name="authority[]" value="sys" checked disabled>
                                        <label class="form-check-label" for="checkbox_sys">設定</label>
                                        <input type="hidden" name="authority[]" value="sys" />
                                    </div>
                                    @else
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_sys" name="authority[]" value="sys" checked>
                                        <label class="form-check-label" for="checkbox_sys">設定</label>
                                    </div>
                                    @endif
                                    @else
                                    <div class="form-check form-switch mb-1">
                                    <input class="form-check-input" type="checkbox" id="checkbox_sys" name="authority[]" value="sys">
                                    <label class="form-check-label" for="checkbox_sys">設定</label>
                                    </div>
                                    @endif

                                    @if(str_contains($roles->authority, 'account'))
                                    @if($roles->Role_Name=='安親班管理員')
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_account" name="authority[]" value="account" checked disabled>
                                        <label class="form-check-label" for="checkbox_account">帳號權限</label>
                                        <input type="hidden" name="authority[]" value="account" />
                                    </div>
                                    @else
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="checkbox" id="checkbox_account" name="authority[]" value="account" checked>
                                        <label class="form-check-label" for="checkbox_account">帳號權限</label>
                                    </div>
                                    @endif
                                    @else
                                    <div class="form-check form-switch mb-1">
                                    <input class="form-check-input" type="checkbox" id="checkbox_account" name="authority[]" value="account">
                                    <label class="form-check-label" for="checkbox_account">帳號權限</label>
                                    </div>
                                    @endif

                                @else
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
                                @endif
                                </div>
                            </div>

                            {{--<div class="form-group row">
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
                            </div>--}}
                            
                          

                        </div>

                        <button  type="submit" class="mt-3 btn my_nav_color text-light float-right">更新資料</button>
                    </div>
                </div>
            </form>
                                




            </div>
        </div>
</div>
@endsection

@section('js')
<script>
document.getElementById('nav_title').innerHTML="<small>編輯角色</small>";
</script>
@endsection
