@extends('layouts.app_guest')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
        <h1 class="my_nav_text text-center mb-5 font-weight-bold">{{$school->School_Name}}</h1>
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
            <form action="{{ route('bind.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="card">
                <div class="card-header "><span class="font-weight-bold my_nav_text enlarge_text">家長綁定孩子資料</span><br>
                <small>當小朋友到班時本系統會自動通知您</small>
                </div>

                <div class="card-body mt-3">
                    <div class="form-group row">
                            <div class="col-sm-4" >
                            <label for="stid" class="font-weight-bold my_nav_text enlarge_text">學號</label>
                            </div>
                            <div class="col-sm-6" >
                            <input class="form-control hidden_object"  type="text" name="school_id" id="school_id" value="{{$school->id}}" required="required"  >
                            <input class="form-control hidden_object"  type="text" name="LineID" id="LineID" value="{{$LineID}}" required="required"  >
                            <input class="form-control"  type="text" name="stid" id="stid" placeholder="請輸入小朋友的學號(數字)" required="required"  >
                            </div>

                    </div>

                    <button  type="submit" class="form-control mt-3 btn my_nav_color text-light">綁定</button>

                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection


@section('app_js')
<script>
$("document").ready(function(){
    setTimeout(function(){
        $("[name='alert_msg']").hide();
    }, 3000 );
});
</script>
@endsection

