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
            <form action="{{ route('account.create_post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">新增帳號</h5>
                    </div>
                    <div class="card-body">

                        <div class="card py-4 px-5">
                            <div class="form-group row">
                            <label for="Func_Name" class="col-sm-2 col-form-label">姓名 <font color="#FF0000">*</font></label>
                            <div class="col-sm-10">
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="請輸入姓名" required="required" value="{{ old('name') }}" maxlength="30">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>

                            {{--<div class="form-group row">
                            <label for="Func_Email" class="col-sm-2 col-form-label">E-mail <font color="#FF0000">*</font></label>
                            <div class="col-sm-10">
                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required="required" placeholder="請輸入E-mail"  maxlength="100">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>--}}


                            <div class="form-group row">
                            <label for="Func_Account" class="col-sm-2 col-form-label">登入帳號 <font color="#FF0000">*</font></label>
                            <div class="col-sm-10">
                                <input class="form-control @error('account') is-invalid @enderror" type="text" name="account" required="required" placeholder="請設定登入帳號" maxlength="50" >
                                @error('account')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>


                            <div class="form-group row">
                            <label for="Func_Pswd" class="col-sm-2 col-form-label">登入密碼 <font color="#FF0000">*</font></label>
                            <div class="col-sm-10">
                                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required="required" placeholder="請設定登入密碼" maxlength="50" >
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>

                            <div class="form-group row">
                            <label for="Func_PswdChk" class="col-sm-2 col-form-label">確認密碼 <font color="#FF0000">*</font></label>
                            <div class="col-sm-10">
                                <input class="form-control" type="password" name="password_confirmation" required="required" placeholder="請再確認密碼">
                            </div>
                            </div>

                            <div class="form-group row">
                            <label for="Func_URL" class="col-sm-2 col-form-label">角色權限 <font color="#FF0000">*</font></label>
                            <div class="col-sm-10">
                                <select class="form-control" id="RoleID" name='RoleID'  required>
                                <option value="">請選擇</option>
                                @foreach($roles as $role)
                                <option value='{{ $role->RoleID }}'>{{ $role->Role_Name }}</option>
                                @endforeach
                                </select>
                            </div>
                            </div>



                        </div>

                        <button  type="submit" class="mt-3 btn my_nav_color text-light float-right">新增帳號</button>
                    </div>
                </div>
            </form>





            </div>
        </div>
</div>
@endsection

@section('js')
<script>
document.getElementById('nav_title').innerHTML="<small>新增帳號</small>";
</script>
@endsection

