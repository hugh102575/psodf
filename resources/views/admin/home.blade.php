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