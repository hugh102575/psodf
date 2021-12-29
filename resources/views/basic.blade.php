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
            <form action="{{ route('basic.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">基本資料</h5>
                    </div>
                    <div class="card-body">

                        <div class="card py-4 px-5">
                            <div class="form-group row">
                            <div class="col-sm-4" >
                            <label for="School_Name" class="font-weight-bold my_nav_text enlarge_text">安親班名稱</label>
                            </div>
                            <div class="col-sm-6" >
                            <input class="form-control"  type="text" name="School_Name" id="School_Name" placeholder="請輸入安親班名稱" required="required" value="{{Auth::user()->school->School_Name}}" >
                            </div>

                            </div>

                            <div class="form-group row">
                            <div class="col-sm-4" >
                            <label for="manager_name" class="font-weight-bold my_nav_text">聯絡人</label>
                            </div>
                            <div class="col-sm-6" >
                            <input class="form-control"  type="text" name="manager_name" id="manager_name" placeholder="請輸入聯絡人" required="required" value="{{Auth::user()->name}}" >
                            </div>


                            </div>

                            <div class="form-group row">
                            <div class="col-sm-4" >
                            <label for="manager_phone" class="font-weight-bold my_nav_text">聯絡電話</label>
                            </div>
                            <div class="col-sm-6" >
                            <input class="form-control"  type="text" name="manager_phone" id="manager_phone" placeholder="請輸入聯絡電話" required="required" value="{{Auth::user()->school->phone}}" >
                            </div>



                            </div>

                            <div class="form-group row">
                            <div class="col-sm-4" >
                            <label for="manager_address" class="font-weight-bold my_nav_text">聯絡地址</label>
                            </div>
                            <div class="col-sm-6" >
                            <input class="form-control"  type="text" name="manager_address" id="manager_address" placeholder="請輸入聯絡地址" required="required" value="{{Auth::user()->school->address}}" >
                            </div>



                            </div>

                    </div>
                    <button  type="submit" class="mt-3 btn my_nav_color text-light float-right">更新資料</button>
                </div>
            </form>




            </div>
        </div>
</div>
@endsection

@section('js')
<script>
document.getElementById('nav_title').innerHTML="<small>基本資料</small>";
</script>
@endsection
