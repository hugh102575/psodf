@extends('home')

@section('css')
<style>
.enlarge_text{
  font-size: x-large !important;
}
.LineColor {
    background-color: rgb(29, 191, 33);
  }

  #snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>
@endsection

@section('stage')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm">
                    {{--<div class="card-header d-flex flex-row" >--}}
                    <div class="card-header" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">安親班LINE串接</h5>
                        <div class="text-secondary small">包含LINE@和LINE Notify</div>
                        <div class="float-right">
                        <button type="button" class="btn btn-primary text-light" onclick=" window.open('{{url("/document1.pdf")}}','_blank')">教學手冊請點我</button>
                        </div>
                    </div>
                    <div class="card-body">
                    @if ($school->LineChannelSecret == null || $school->LineChannelAccessToken == null)
                    <form action="{{ route('line.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="table-responsive">
                            <p class="mb-3">請將<a href="https://notify-bot.line.me/my/services/" target="_blank">LINE Notify</a>的資訊填入，來完成串接，可以<span class="">「免費」</span>推送訊息喔！</p>
                            <p>Callback URL請填寫<span class="small text-light my_nav_color">https://yes-psodf.yesinfo.com.tw/notify_bind/<span></p>
                            <table class="table table-bordered overflow-auto">

                            <tbody>
                                <tr>
                                <th scope="row">Client ID<font color="#FF0000">*</font></th>
                                <td><input type="text" class="form-control" placeholder="Client ID" id="ClientId" name="ClientId" required="required" ></td>
                                </tr>
                                <tr>
                                <th scope="row">Client Secret<font color="#FF0000">*</font></th>
                                <td><input type="text" class="form-control" placeholder="Client Secret" id="ClientSecret" name="ClientSecret" required="required"></td>
                                </tr>
                               
                               
                                
                            </tbody>
                            </table>

                            <hr>

                            <p class="mb-3">請將<a href="https://developers.line.biz/console" target="_blank">LINE@後台</a>的資訊填入，來完成串接。<br><br>(由於是在LINE Notify推播，因此不用擔心有額外的費用喔！)</p>
                            <table class="table table-bordered overflow-auto">

                            <tbody>
                                <tr>
                                <th scope="row">Bot basic ID<font color="#FF0000">*</font></th>
                                <td><input type="text" class="form-control" placeholder="格式以@開頭" id="LineID" name="LineID" required="required" ></td>
                                </tr>
                                <tr>
                                <th scope="row">Channel secret<font color="#FF0000">*</font></th>
                                <td><input type="text" class="form-control" placeholder="Channel secret" id="LineChannelSecret" name="LineChannelSecret" required="required"></td>
                                </tr>
                                <tr>
                                <th scope="row">Channel access token<font color="#FF0000">*</font></th>
                                <td><input type="text" class="form-control" placeholder="Channel access token" id="LineChannelAccessToken" name="LineChannelAccessToken" required="required"></td>
                                </tr>
                                <tr>
                                {{--<th scope="row">連接狀態</th>
                                <td><button id="Linebtn" name="Linebtn" type="submit" class="btn my_nav_color text-white">連接</button></td>
                                </tr>--}}
                                <!--<tr>
                                <td><input type="text" class="form-control" placeholder="格式以@開頭" id="LineID" name="LineID" ></td>
                                <td><input type="text" class="form-control" placeholder="Channel secret" id="LineChannelSecret" name="LineChannelSecret" ></td>
                                <td><input type="text" class="form-control" placeholder="Channel access token" id="LineChannelAccessToken" name="LineChannelAccessToken" ></td>
                                <td><button id="Linebtn" name="Linebtn" type="button" class="btn LineColor text-white">連接</button></td>
                                </tr>-->
                            </tbody>
                            </table>
                            <button id="Linebtn" name="Linebtn" type="submit" class="form-control btn my_nav_color text-white">連接</button>
                        </div>
                    </form>
                    @else
                    <form action="{{ route('line.update') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('確定要斷開連接嗎?\nLine@與簽到等相關功能將無法使用。');">
                    @csrf
                    
                    <span class="small d-flex justify-content-center">請於<a href="https://developers.line.biz/console" target="_blank">LINE@後台</a>設定webhook，若您已經設定請忽略此訊息</span>

                    <div class="card p-3 mb-5">
                        <div class="">您的webhook網址為:&nbsp;&nbsp;<br><span id="my_webhook_url" class="small text-light my_nav_color">{{URL::to('/')}}/callback/{{Auth::user()->api_token}}</span><br><button id="copy_webhook_btn" type="button" class="btn btn-light text-secondary shadow-sm"><small><i class="far fa-copy"></i> 複製</small></button></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered overflow-auto " style='table-layout:fixed;'>

                        <tbody>
                            <tr>
                                <th scope="row">Client ID<font color="#FF0000">*</font></th>
                                <td><input type="text" class="form-control" placeholder="Client ID" value="{{$school->ClientId}}" required="required" disabled></td>
                            </tr>
                            <tr>
                                <th scope="row">Client Secret<font color="#FF0000">*</font></th>
                                <td><input type="password" class="form-control" placeholder="Client Secret" value="{{$school->ClientSecret}}" required="required" disabled></td>
                            </tr>
                            <tr>
                            <th scope="row">LINE@名稱</th>
                            <td class="enlarge_text">{{$school->LineChannelName}}</td>
                            </tr>
                            <tr>
                            <th scope="row">LINE@ ID (邀請碼)</th>
                            <td class="enlarge_text">{{$school->LineID}}</td>
                            </tr>
                            {{--<tr>
                            <th scope="row">Channel secret</th>
                            <td>
                                <p style="overflow: hidden;text-overflow:ellipsis; white-space: nowrap;">{{ $school->LineChannelSecret }}</p>
                            </td>
                            </tr>
                            <tr>
                            <th scope="row">Channel access token</th>
                            <td>
                                <p style="overflow: hidden;text-overflow:ellipsis; white-space: nowrap;">{{ $school->LineChannelAccessToken }}</p>
                            </td>
                            </tr>--}}
                            <tr>
                            <th scope="row">LINE@ QR Code (掃描加入)</th>
                            <td><div id="qr_div" class="p-3 "><div class="" id="qrcode"></div><button type="button" id="qr_download" class="btn btn-link"><small><u><i class="fas fa-download"></i> 按我下載</u></small></button></div></td>
                            </tr>
                            <tr>
                            <th scope="row">連接狀態</th>
                            <td><span class="">已連接！</span><button id="Linedisbtn" name="Linedisbtn" type="submit" class="btn btn-link text-danger btn-sm float-right"><i class="fas fa-exclamation-triangle"></i><small>斷開連接</small></button></td>
                            </tr>

                        </tbody>
                        </table>
                    </div>
                    </form>
                    @endif
                    </div>

                </div>




                <div id="snackbar">webhook已複製到剪貼簿</div>
            </div>
        </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script src="{{asset('vendor/copy-paste-select-jqlipboard/copy-paste-select-jqlipboard/src/jQlipboard.js')}}"></script>
<script>
document.getElementById('nav_title').innerHTML="<small>安親班LINE串接</small>";
var school={!! json_encode($school) !!};
if(school.LineChannelSecret!=null && school.LineChannelAccessToken!=null){
    var bot_id=(school.LineID).replace("@", "");
    var qrcode_url="https://line.me/R/ti/p/%40"+bot_id;
    $('#qrcode').qrcode({
        width: 180,
        height: 180,
        text: qrcode_url
    });
}

function download(canvas, filename) {
		  /// create an "off-screen" anchor tag
		  var lnk = document.createElement('a'), e;

		  /// the key here is to set the download attribute of the a tag
		  lnk.download = filename;

		  /// convert canvas content to data-uri for link. When download
		  /// attribute is set the content pointed to by link will be
		  /// pushed as "download" in HTML5 capable browsers
		  lnk.href = canvas[0].toDataURL("image/png");

		  /// create a "fake" click-event to trigger the download
		  if (document.createEvent) {
		    e = document.createEvent("MouseEvents");
		    e.initMouseEvent("click", true, true, window,
		                     0, 0, 0, 0, 0, false, false, false,
		                     false, 0, null);

		    lnk.dispatchEvent(e);
		  } else if (lnk.fireEvent) {
		    lnk.fireEvent("onclick");
		  }
		}

var qr_download = document.getElementById('qr_download');
qr_download.addEventListener("click", function() {
    //alert('ccc')
var canvas = $('#qrcode canvas');
    download(canvas,school.School_Name+".png");
});

var copy_webhook_btn = document.getElementById('copy_webhook_btn');
copy_webhook_btn.addEventListener("click", function() {
     var x = document.getElementById("snackbar");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    $('#my_webhook_url' ).copy();
   
});
</script>
@endsection
