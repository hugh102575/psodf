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
                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">進階設定</h5>
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
                                <textarea class="form-control" id="in_msg" name="in_msg" rows="4" style="resize: none;" required="required">{{Auth::user()->school->in_msg}}</textarea>
                                </div>

                                <div class="col-sm-4" >
                                <label for="out_msg_div" class="font-weight-bold my_nav_text ">簽退訊息</label>
                                </div>
                                <div class="col-sm-6" id="out_msg_div">
                                <textarea class="form-control" id="out_msg" name="out_msg" rows="4" style="resize: none;" required="required">{{Auth::user()->school->out_msg}}</textarea>
                                </div>
                                
                            </div>
                            <small class="mt-3 text-secondary">「@Name」等關鍵字將自動轉換，其他關鍵字請<a id="keyword_hint" href="#">點這裡</a>查看</small>
                        </div>
                        
                        <div class="card py-4 px-5 ">
                            <div class="form-group row">
                            <div class="col-sm-4" >
                            <label for="thresh" class="font-weight-bold my_nav_text ">辨識門檻值</label>
                            </div>
                            <div class="col-sm-6" >
                            <input class="form-control" type="number" id="thresh" name="thresh" min="1" max="2" step="0.1" required="required" placeholder="請輸入1到2之間的小數值" value="{{Auth::user()->school->thresh}}">
                            {{--<input class="form-control"  type="text" name="School_Name" id="School_Name" placeholder="請輸入安親班名稱" required="required" value="{{Auth::user()->school->School_Name}}" >
                            --}}
                            </div>

                            </div>
                            <small class="mt-3 text-secondary">辨識門檻值是介於1和2之間的小數，<br>小於辨識門檻值的特徵才能簽到，<br>門檻值愈小篩的愈嚴格、愈大篩的愈寬鬆，建議採用預設值1.0</small>
                        </div>
                        <div class="d-flex  float-right  ml-auto" >
                        <button id="default_btn" type="button" class=" mt-3 btn btn-secondary text-light ">恢復預設值</button>
                        <button  type="submit" class="ml-3 mt-3 btn my_nav_color text-light ">更新資料</button>
                        </div>
                    </div>

                </div>
            </form>




            </div>
        </div>
</div>
@endsection

@section('js')
<script>
document.getElementById('nav_title').innerHTML="<small>進階設定</small>";
$('#keyword_hint').click(function(){
    var msg="@Name  學生姓名\n@School  安親班名稱\n@Phone  安親班電話";
    alert(msg);
});
$('#default_btn').click(function(){
    document.getElementById("flexRadioDefault1").checked = false;
    document.getElementById("flexRadioDefault2").checked = true;
    document.getElementById('in_msg').innerHTML="您的孩子@Name已經到班囉!"
    document.getElementById('out_msg').innerHTML="您的孩子@Name已經下課囉!"
    document.getElementById('thresh').value="1.0"
});
var thresh=document.getElementById('thresh').value
document.getElementById('thresh').value=parseFloat(thresh).toFixed(1)
</script>
@endsection
