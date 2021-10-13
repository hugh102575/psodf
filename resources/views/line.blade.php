@extends('home')

@section('css')
<style>
.enlarge_text{
  font-size: x-large !important;
}
.LineColor {
    background-color: rgb(29, 191, 33);
  }
</style>
@endsection

@section('stage')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                <div class="card">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">安親班LINE@</h5>
                    </div>
                    <div class="card-body">
                    @if ($school->LineChannelSecret == null || $school->LineChannelAccessToken == null)
                    <form action="{{ route('line.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered overflow-auto">

                            <tbody>
                                <tr>
                                <th scope="row">Line Channel ID<font color="#FF0000">*</font></th>
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
                                <th scope="row">連接狀態</th>
                                <td><button id="Linebtn" name="Linebtn" type="submit" class="btn my_nav_color text-white">連接</button></td>
                                </tr>
                                <!--<tr>
                                <td><input type="text" class="form-control" placeholder="格式以@開頭" id="LineID" name="LineID" ></td>
                                <td><input type="text" class="form-control" placeholder="Channel secret" id="LineChannelSecret" name="LineChannelSecret" ></td>
                                <td><input type="text" class="form-control" placeholder="Channel access token" id="LineChannelAccessToken" name="LineChannelAccessToken" ></td>
                                <td><button id="Linebtn" name="Linebtn" type="button" class="btn LineColor text-white">連接</button></td>
                                </tr>-->
                            </tbody>
                            </table>
                        </div>
                    </form>
                    @else
                    <form action="{{ route('line.update') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('您確定要斷開LINE@連接嗎?');">
                    @csrf
                    <div class="table-responsive">
                        <p class="mb-3">您的webhook網址為:&nbsp;&nbsp;<span class="text-light bg-dark">{{URL::to('/')}}/callback/{{$school->id}}</span><br>請於<a href="https://developers.line.biz/console" target="_blank">LINE@後台</a>設定，若您已經設定請忽略此訊息
                        </p>
                        <table class="table table-bordered overflow-auto" style='table-layout:fixed;'>

                        <tbody>
                            <tr>
                            <th scope="row">LINE@名稱</th>
                            <td class="enlarge_text">{{$school->LineChannelName}}</td>
                            </tr>
                            <tr>
                            <th scope="row">Channel ID (邀請碼)</th>
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
                            <th scope="row">QR Code (掃描加入)</th>
                            <td><div class="p-1"id="qrcode"></div></td>
                            </tr>
                            <tr>
                            <th scope="row">連接狀態</th>
                            <td><button id="Linedisbtn" name="Linedisbtn" type="submit" class="btn btn-link text-danger btn-sm">斷開連接</button></td>
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
<script>
document.getElementById('nav_title').innerHTML="<small>LINE @串接</small>";
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

</script>
@endsection
