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
                        <div class="card py-4 px-5 mb-5">
                            <div class="form-group row">
                            <div class="col-sm-4" >
                            <label for="sign_mode" class="font-weight-bold my_nav_text ">簽到模式</label>
                            </div>
                            <div class="col-sm-6" id="sign_mode">
                                @if(Auth::user()->school->sign_mode==1)
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="sign_mode" id="flexRadioDefault1" value="mode_1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    簽到
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="sign_mode" id="flexRadioDefault2" value="mode_2" >
                                <label class="form-check-label" for="flexRadioDefault2">
                                    簽到 / 簽退
                                </label>
                                </div>
                                @endif
                                @if(Auth::user()->school->sign_mode==2)
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="sign_mode" id="flexRadioDefault1" value="mode_1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    簽到
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="sign_mode" id="flexRadioDefault2" value="mode_2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    簽到 / 簽退
                                </label>
                                </div>
                                @endif

                            </div>

                            </div>
                        </div>
                        <div class="card py-4 px-5 mb-5">
                            <div class="form-group row">
                                <div class="col-sm-4" >
                                <label for="in_msg_div" class="font-weight-bold my_nav_text ">簽到訊息</label>
                                </div>
                                <div class="col-sm-6 mb-3" id="in_msg_div">
                                <textarea class="form-control" id="in_msg" name="in_msg" rows="3" style="resize: none;" required="required">{{Auth::user()->school->in_msg}}</textarea>
                                </div>

                                <div class="col-sm-4" >
                                <label for="out_msg_div" class="font-weight-bold my_nav_text ">簽退訊息</label>
                                </div>
                                <div class="col-sm-6" id="out_msg_div">
                                <textarea class="form-control" id="out_msg" name="out_msg" rows="3" style="resize: none;" required="required">{{Auth::user()->school->out_msg}}</textarea>
                                </div>
                                
                            </div>
                            <small class="mt-3">「@Name」等關鍵字將自動轉換，其他關鍵字請<a id="keyword_hint" href="#">點這裡</a>查看</small>
                        </div>
                        <div class="card py-4 px-5 ">
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
                            <small class="mt-3">辨識誤差值會和最佳結果比較，愈大找到得愈多但可能誤判，愈小找得愈精確(至少會找到一個)，預設值為0.1。</small>
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
document.getElementById('nav_title').innerHTML="<small>系統設定</small>";
$('#keyword_hint').click(function(){
    var msg="@Name  學生姓名\n@School  安親班名稱\n@Phone  安親班電話";
    alert(msg);
});
</script>
@endsection
