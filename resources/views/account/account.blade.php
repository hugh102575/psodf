@extends('home')

@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<style>
.enlarge_text{
  font-size: x-large !important;
}
</style>
@endsection

@section('stage')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-row" >
                        <h5 class="font-weight-bold text-success mr-5 my_nav_text">帳號一覽</h5>
                        <div class="d-flex  float-right  ml-auto" >
                            {{--<a href="{{ route('role.create') }}" >
                                <button type="button"   class="btn text-light btn-icon-split  my_nav_color  ml-3 mb-1 "><i class="fas fa-plus"></i> 新增角色</button>
                            </a>--}}
                            <a href="{{ route('account.create') }}" >
                                <button type="button"   class="btn text-light btn-icon-split  my_nav_color  ml-3 mb-1 "><i class="fas fa-plus"></i> 新增帳號</button>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table dataTable table-hover text-center text-middle table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="my_nav_color text-light">
                                        <th>帳號</th>
                                        {{--<th>信箱</th>--}}
                                        <th>員工名稱</th>
                                        <th>角色名稱</th>
                                        <th>權限</th>
                                        <th>最後登入</th>
                                        <th>編輯</th>
                                        <th>停用/啟用</th>
                                        <th>刪除</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($accounts as $account)
                                    <tr>
                                        <td>{{ $account->account }}</td>
                                        {{--<td>{{ $account->email }}</td>--}}
                                        <td>{{ $account->name }}</td>
                                        <td>{{ $account->role->Role_Name }}</td>
                                        <td class="text-left">
                                            @php
                                                $authority_count=0;
                                                $authority_A=explode(',',$account->role->authority);
                                            @endphp
                                            @foreach($authority_A as $authority_per)
                                                @php
                                                    $authority_count++;
                                                @endphp

                                                @switch($authority_per)
                                                    @case("classs")
                                                        @php
                                                            $authority_per="班級";
                                                        @endphp
                                                        @break
                                                    @case("sign")
                                                        @php
                                                            $authority_per="簽到退查詢";
                                                        @endphp
                                                        @break
                                                    @case("message")
                                                        @php
                                                            $authority_per="訊息";
                                                        @endphp
                                                        @break
                                                    @case("line")
                                                        @php
                                                            $authority_per="LINE串接";
                                                        @endphp
                                                        @break
                                                    @case("sys")
                                                        @php
                                                            $authority_per="設定";
                                                        @endphp
                                                        @break
                                                    @case("account")
                                                        @php
                                                            $authority_per="帳號權限";
                                                        @endphp
                                                        @break
                                                    @default
                                                        @php
                                                            $authority_per="無";
                                                        @endphp
                                                @endswitch

                                                @if($authority_per=='無')
                                                    <i class="fas fa-times text-danger mr-1"></i> {{ $authority_per }}
                                                @else
                                                    @if($authority_count!=count($authority_A))
                                                    <i class="fas fa-check my_nav_text mr-1"></i> {{ $authority_per }}<br>
                                                    @else
                                                    <i class="fas fa-check my_nav_text mr-1"></i> {{ $authority_per }}
                                                    @endif
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($account->last_login!=null)
                                            @php
                                            @endphp
                                            <small>{{ $account->last_login }}</small>
                                            @endif
                                        </td>
                                        <td>
                                        <a href="{{route('account.edit',$account->id)}}" class="my_nav_text"><i class="fas fa-user-edit"></i> 編輯</a>
                                        </td>
                                        <td>
                                        @if($account->id != Auth::user()->id)
                                            <form  action="{{ route('account.change_active',$account->id) }}" method="POST" class="" enctype="multipart/form-data"  >
                                            @csrf
                                            @if($account->active)
                                            <button type="submit" class="btn btn-link text-success astext" name="current_status" value="{{$account->active}}"><i class="fas fa-power-off"></i> 已啟用</button>
                                            @else
                                            <button type="submit" class="btn btn-link text-danger astext" name="current_status" value="{{$account->active}}"><i class="fas fa-power-off"></i> 已停用</button>
                                            @endif
                                            </form>
                                        @else
                                        <small>我的帳號</small>
                                        @endif
                                        </td>
                                        <td>
                                            @if($account->id != Auth::user()->id)
                                                <form  action="{{ route('account.delete_post',$account->id) }}" method="POST" class="" enctype="multipart/form-data" onsubmit="return confirm('確定刪除帳號「{{$account->account}}」嗎?');" >
                                                    @csrf
                                                    <button type="submit" class="btn btn-link text-danger astext"><i class="fas fa-trash-alt"></i> 刪除</button>
                                                </form>
                                            @else
                                            <small>我的帳號</small>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
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
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script>
document.getElementById('nav_title').innerHTML="<small>帳號一覽</small>";
</script>
@endsection

