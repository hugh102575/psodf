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
                    
                        <div class="table-responsive">
                            {{--<p class="mb-3">請將<a href="https://developers.line.biz/console" target="_blank">LINE@後台</a>的資訊填入，來完成串接</p>--}}
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

</script>
@endsection
