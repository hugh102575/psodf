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

                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">安親班LINE Notify</h5>
                    </div>
                    <div class="card-body">
                       
                        @if ($school->ClientId == null || $school->ClientSecret == null)
                        <form action="{{ route('line_notify.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="table-responsive">
                            <p class="mb-3">請將<a href="https://notify-bot.line.me/my/services/" target="_blank">LINE Notify</a>的資訊填入，來完成串接</p>
                            <p>Callback URL請填寫https://yes-psodf.yesinfo.com.tw/notify_bind/</p>
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
                               
                                <tr>
                                <th scope="row">連接狀態</th>
                                <td><button id="Linebtn" name="Linebtn" type="submit" class="btn my_nav_color text-white">連接</button></td>
                                </tr>
                                
                            </tbody>
                            </table>
                        </div>
                        </form>
                        @else
                        <form action="{{ route('line_notify.update') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('確定要斷開LINE Notify連接嗎?\nLINE Notify與簽到等相關功能將無法使用。');">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered overflow-auto">

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
                                <th scope="row">家長授權與綁定 QR Code</th>
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




            </div>
        </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script src="{{asset('vendor/copy-paste-select-jqlipboard/copy-paste-select-jqlipboard/src/jQlipboard.js')}}"></script>
<script>
document.getElementById('nav_title').innerHTML="<small>LINE Notify串接</small>";
var school={!! json_encode($school) !!};
if(school.ClientId!=null && school.ClientSecret!=null){
    //var bot_id=(school.LineID).replace("@", "");
    //var qrcode_url="https://line.me/R/ti/p/%40"+bot_id;
    var qrcode_url="https://notify-bot.line.me/oauth/authorize?response_type=code&scope=notify&client_id="+school.ClientId+"&redirect_uri=https://yes-psodf.yesinfo.com.tw/notify_bind/&state="+school.id+"@"+school.ClientId+"@"+school.ClientSecret
    console.log('qrcode_url',qrcode_url)
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
</script>
@endsection
