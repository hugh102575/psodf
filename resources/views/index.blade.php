@extends('home')

@section('stage')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{ __('You are logged in!') }}<br>
                        @php
                        $t1=date('Y-m-d', strtotime($now));
                        //$t2=date('H:i:s', strtotime($now));
                        $dayofweek_ = date('w', strtotime($t1));
                        $dayofweek =' ('.'星期' . ['日', '一', '二', '三', '四', '五', '六'][$dayofweek_].')';
                        @endphp
                        現在時間: {{$t1}}{{$dayofweek}}{{--&nbsp;&nbsp;{{$t2}}--}}<hr>
                        <span class="">您的安親班<span class="bg-primary text-light px-1">平台序號:&nbsp;&nbsp;{{Auth::user()->school->PID}}</span>，請務必記住用來登入。<span>
                        <button type="button" class="btn btn-link" onclick=" window.open('{{url("/downloadPID")}}','_blank')"><small><u><i class="fas fa-download"></i> 按我下載</u></small></button>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>

</script>
@endsection
