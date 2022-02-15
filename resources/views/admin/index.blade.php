@extends('layouts.app_admin')

@section('app_css')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6">
        @if(session()->has('success_msg'))
            <div class="alert alert-success mb-3" name="alert_msg">
                {{ session()->get('success_msg') }}
            </div>
        @endif
        @if(session()->has('error_msg'))
            <div class="alert alert-danger mb-3" name="alert_msg">
                {{ session()->get('error_msg') }}
            </div>
        @endif
        @if(session()->has('normal_msg'))
            <div class="alert alert-info mb-3" name="alert_msg">
                {{ session()->get('normal_msg') }}
            </div>
        @endif
            <form action="{{ route('admin.login') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header ">
                    <span class="font-weight-bold my_nav_text enlarge_text">系統管理員登入</span><br>
                </div>

                <div class="card-body mt-3">
                    <div class="pb-1">
                        <div class="form-group row text-center">
                                <div class="col-sm-4" >
                                <label for="admin_account" class="font-weight-bold my_nav_text enlarge_text">帳號</label>
                                </div>
                                <div class="col-sm-6" >
                                <input class="form-control"  type="text" name="admin_account" id="admin_account" placeholder="請輸入系統管理員帳號" required="required"  >
                                </div>
                        </div>

                        <div class="form-group row text-center">
                                <div class="col-sm-4" >
                                <label for="admin_password" class="font-weight-bold my_nav_text enlarge_text">密碼</label>
                                </div>
                                <div class="col-sm-6" >
                                <input class="form-control"  type="password" name="admin_password" id="admin_password" placeholder="請輸入系統管理員密碼" required="required"  >
                                </div>
                        </div>
                    </div>
                    <hr>

                    <div class=" col-sm-6 mx-auto">
                        <button  type="submit" class="form-control mt-3 btn my_nav_color text-light ">登入</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('app_js')
<script>
/*$("document").ready(function(){
    setTimeout(function(){
        $("[name='alert_msg']").hide();
    }, 3000 );
});*/
</script>
@endsection

