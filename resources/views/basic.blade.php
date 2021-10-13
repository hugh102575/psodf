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
            <form action="{{ route('basic') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">基本資料</h5>
                    </div>
                    <div class="card-body">

                        <div class="card py-4 px-5 mb-3">
                            <div class="form-group row">
                            <div class="col-sm-4" >
                            <label for="School_Name" class="font-weight-bold my_nav_text enlarge_text">安親班名稱</label>
                            </div>
                            <div class="col-sm-6" >
                            <input class="form-control"  type="text" name="School_Name" id="School_Name" placeholder="請輸入安親班名稱" required="required" value="{{Auth::user()->school->School_Name}}" >
                            </div>

                            </div>
                        </div>
                        <button  type="submit" class="btn my_nav_color text-light float-right">更新資料</button>
                    </div>

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
