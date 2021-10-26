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
            <form action="{{ route('system.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">系統設定</h5>
                    </div>
                    <div class="card-body">

                        <div class="card py-4 px-5 mb-3">
                            <div class="form-group row">
                            <div class="col-sm-4" >
                            <label for="thresh" class="font-weight-bold my_nav_text ">辨識誤差值</label>
                            </div>
                            <div class="col-sm-6" >
                            <input class="form-control" type="number" id="thresh" name="thresh" min="0" max="1" step="0.01" required="required" placeholder="請輸入0到1之間的小數值" value="{{Auth::user()->school->thresh}}">
                            {{--<input class="form-control"  type="text" name="School_Name" id="School_Name" placeholder="請輸入安親班名稱" required="required" value="{{Auth::user()->school->School_Name}}" >
                            --}}
                            </div>

                            </div>
                            <small class="mt-3">辨識誤差值會和最佳結果比較，愈大找得愈多但可能誤判，愈小找得愈精確(最少會找到一個)，預設值為0.1。</small>
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
document.getElementById('nav_title').innerHTML="<small>系統設定</small>";
</script>
@endsection
