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
                        現在時間: {{$t1}}{{$dayofweek}}{{--&nbsp;&nbsp;{{$t2}}--}}
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
