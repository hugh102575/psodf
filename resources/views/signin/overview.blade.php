@extends('home')

@section('css')
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
<style>
.enlarge_text{
  font-size: x-large !important;

}


</style>
@endsection

@section('stage')
<div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-4  " >
            <div class="my_nav_text font-weight-bold">請選擇查詢日期</div>
                <div class="input-group ">
                    
                    <input type="text" class="form-control datepicker" id="chart_current" placeholder="請選擇查詢日期" value="{{$today}}">
                    <div class="input-group-append">
                        <button class="input-group-text text-light my_nav_color" id="chart_current_btn"><small>查詢</small></button>
                    </div>
                </div>
            </div>

            <div class="col-md-8" >
                <div id="myLineChart_live_div" class="border p-3 shadow">
                <canvas id="myLineChart_live" class=""></canvas>
                <canvas id="myLineChart_live2" ></canvas>
                </div>
            </div>
        </div>
</div>
@endsection

@section('js')
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.zh-CN.min.js"></script>

<script>
document.getElementById('nav_title').innerHTML="<small>總覽</small>";

$('.datepicker').datepicker({
	    format: 'yyyy-mm-dd',
	    language: 'zh-CN',
      todayHighlight: true
	});

    var date_result = {!! json_encode($date_result) !!};
    console.log('date_result',date_result);

    var ctx = document.getElementById("myLineChart_live");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                    date_result['-5']['daily'],
                    date_result['-4']['daily'],
                    date_result['-3']['daily'],
                    date_result['-2']['daily'],
                    date_result['-1']['daily'],
                    date_result['center']['daily'],
                    date_result['+1']['daily'],
                    date_result['+2']['daily'],
                    date_result['+3']['daily'],
                    date_result['+4']['daily'],
                    date_result['+5']['daily']
                    ],
            datasets: [{
            data: [
                date_result['-5']['FbBot_use'],
                date_result['-4']['FbBot_use'],
                date_result['-3']['FbBot_use'],
                date_result['-2']['FbBot_use'],
                date_result['-1']['FbBot_use'],
                date_result['center']['FbBot_use'],
                date_result['+1']['FbBot_use'],
                date_result['+2']['FbBot_use'],
                date_result['+3']['FbBot_use'],
                date_result['+4']['FbBot_use'],
                date_result['+5']['FbBot_use']
            ],
            label: "簽到人數",
            //backgroundColor: "rgba(0,255,0,0.3)",
            backgroundColor: "rgb(92, 184, 92)",
            
            fill: true,
            tension: 0
            }/*, {
            data: [
                date_result['-5']['LineBot_use'],
                date_result['-4']['LineBot_use'],
                date_result['-3']['LineBot_use'],
                date_result['-2']['LineBot_use'],
                date_result['-1']['LineBot_use'],
                date_result['center']['LineBot_use'],
                date_result['+1']['LineBot_use'],
                date_result['+2']['LineBot_use'],
                date_result['+3']['LineBot_use'],
                date_result['+4']['LineBot_use'],
                date_result['+5']['LineBot_use']
            ],
            label: "簽退",
            backgroundColor: "rgba(0,0,255,0.3)",
            fill: true,
            tension: 0
            }*/
        ]
        },
        options: {
            animation: {
                duration: 1000, // general animation time
            },
            scales: {
                yAxes: [{
                    ticks: {
                        suggestedMax: 10,
                        beginAtZero:true,
                        userCallback: function(item) {
                            return item+'人';
                        }
                    }
                }]
                ,
                xAxes: [{
                    ticks: {
                        userCallback: function(item) {
                            item=item.replace(/-0+/g, '-'); 
                            item=item.substring(5)
                            item=item.replace("-", "/");
                            return item;
                        }
                    },
                    gridLines: {
                    lineWidth:[1,1,1,1,1,3,1,1,1,1,1],
                    color: ['rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)',
                             'rgba(255, 0, 0, 0.5)'   ,
                            'rgba(0, 0, 0, 0.1)'   ,'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)']
                    }
                }]
            }
        }
    });
    var ctx2 = document.getElementById("myLineChart_live2");
    var myLineChart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: [
                    date_result['-5']['daily'],
                    date_result['-4']['daily'],
                    date_result['-3']['daily'],
                    date_result['-2']['daily'],
                    date_result['-1']['daily'],
                    date_result['center']['daily'],
                    date_result['+1']['daily'],
                    date_result['+2']['daily'],
                    date_result['+3']['daily'],
                    date_result['+4']['daily'],
                    date_result['+5']['daily']
                    ],
            datasets: [/*{
            data: [
                date_result['-5']['FbBot_use'],
                date_result['-4']['FbBot_use'],
                date_result['-3']['FbBot_use'],
                date_result['-2']['FbBot_use'],
                date_result['-1']['FbBot_use'],
                date_result['center']['FbBot_use'],
                date_result['+1']['FbBot_use'],
                date_result['+2']['FbBot_use'],
                date_result['+3']['FbBot_use'],
                date_result['+4']['FbBot_use'],
                date_result['+5']['FbBot_use']
            ],
            label: "簽到",
            backgroundColor: "rgba(0,255,0,0.3)",
            fill: true,
            tension: 0
            },*/ {
            data: [
                date_result['-5']['LineBot_use'],
                date_result['-4']['LineBot_use'],
                date_result['-3']['LineBot_use'],
                date_result['-2']['LineBot_use'],
                date_result['-1']['LineBot_use'],
                date_result['center']['LineBot_use'],
                date_result['+1']['LineBot_use'],
                date_result['+2']['LineBot_use'],
                date_result['+3']['LineBot_use'],
                date_result['+4']['LineBot_use'],
                date_result['+5']['LineBot_use']
            ],
            label: "簽退人數",
            //backgroundColor: "rgba(0,0,255,0.3)",
            backgroundColor: "rgb(2, 117, 216)",
           
            fill: true,
            tension: 0
            }
            /*, {
            data: [
                date_result['-5']['FbBot_use']+date_result['-5']['LineBot_use'],
                date_result['-4']['FbBot_use']+date_result['-4']['LineBot_use'],
                date_result['-3']['FbBot_use']+date_result['-3']['LineBot_use'],
                date_result['-2']['FbBot_use']+date_result['-2']['LineBot_use'],
                date_result['-1']['FbBot_use']+date_result['-1']['LineBot_use'],
                date_result['center']['FbBot_use']+date_result['center']['LineBot_use'],
                date_result['+1']['FbBot_use']+date_result['+1']['LineBot_use'],
                date_result['+2']['FbBot_use']+date_result['+2']['LineBot_use'],
                date_result['+3']['FbBot_use']+date_result['+3']['LineBot_use'],
                date_result['+4']['FbBot_use']+date_result['+4']['LineBot_use'],
                date_result['+5']['FbBot_use']+date_result['+5']['LineBot_use']
            ],
            label: "All",
            backgroundColor: "#FFD700",
            fill: false,
            tension: 0
            }*/
        ]
        },
        options: {
            animation: {
                duration: 1000, // general animation time
            },
            scales: {
                yAxes: [{
                    ticks: {
                        suggestedMax: 10,
                        beginAtZero:true,
                        userCallback: function(item) {
                            return item+'人';
                        }
                    }
                }]
                ,
                xAxes: [{
                    ticks: {
                        userCallback: function(item) {
                            item=item.replace(/-0+/g, '-'); 
                            item=item.substring(5)
                            item=item.replace("-", "/");
                            return item;
                        }
                    },
                    gridLines: {
                    lineWidth:[1,1,1,1,1,3,1,1,1,1,1],
                    color: ['rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)',
                             'rgba(255, 0, 0, 0.5)'   ,
                            'rgba(0, 0, 0, 0.1)'   ,'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)', 'rgba(0, 0, 0, 0.1)']
                    }
                }]
            }
        }
    });

    $('#chart_current_btn').on('click', function (e) {
        update_date=document.getElementById('chart_current').value;
        //document.getElementById('myLineChart_live_div').innerHTML='';
        //canvas=document.createElement('canvas');
        //canvas.setAttribute("id", "myLineChart_live");
        //document.getElementById('myLineChart_live_div').appendChild(canvas);

        function ajax2(){
            return $.ajax({
            type:'POST',
            url:'/signin/update_chart',
            dataType:'json',
            data:{
                'update_date':update_date,
                _token: '{{csrf_token()}}'
            },
            success:function(data){
            },
            error:function(e){
                alert('Error: ' + e);
            }
            });
        }

        $.when(ajax2()).done(function(a2){
            var date_result=a2;
            console.log(date_result)
            //document.getElementById('chart_current').value='';
            document.getElementById('chart_current').value=date_result['center']['daily'];
            var ctx = document.getElementById("myLineChart_live");
            /*var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [
                            date_result['-5']['daily'],
                            date_result['-4']['daily'],
                            date_result['-3']['daily'],
                            date_result['-2']['daily'],
                            date_result['-1']['daily'],
                            date_result['center']['daily'],
                            date_result['+1']['daily'],
                            date_result['+2']['daily'],
                            date_result['+3']['daily'],
                            date_result['+4']['daily'],
                            date_result['+5']['daily']
                            ],
                    datasets: [{
                    data: [
                        date_result['-5']['FbBot_use'],
                        date_result['-4']['FbBot_use'],
                        date_result['-3']['FbBot_use'],
                        date_result['-2']['FbBot_use'],
                        date_result['-1']['FbBot_use'],
                        date_result['center']['FbBot_use'],
                        date_result['+1']['FbBot_use'],
                        date_result['+2']['FbBot_use'],
                        date_result['+3']['FbBot_use'],
                        date_result['+4']['FbBot_use'],
                        date_result['+5']['FbBot_use']
                    ],
                    label: "簽到",
                    backgroundColor: "#00c300",
                    fill: false,
                    tension: 0
                    }, {
                    data: [
                        date_result['-5']['LineBot_use'],
                        date_result['-4']['LineBot_use'],
                        date_result['-3']['LineBot_use'],
                        date_result['-2']['LineBot_use'],
                        date_result['-1']['LineBot_use'],
                        date_result['center']['LineBot_use'],
                        date_result['+1']['LineBot_use'],
                        date_result['+2']['LineBot_use'],
                        date_result['+3']['LineBot_use'],
                        date_result['+4']['LineBot_use'],
                        date_result['+5']['LineBot_use']
                    ],
                    label: "簽退",
                    backgroundColor: "#3b5998",
                    fill: false,
                    tension: 0
                    }

                ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }],
                        xAxes: [{

                        }]
                    }
                }
            });*/
            myLineChart.data=
            {
                labels: [
                        date_result['-5']['daily'],
                        date_result['-4']['daily'],
                        date_result['-3']['daily'],
                        date_result['-2']['daily'],
                        date_result['-1']['daily'],
                        date_result['center']['daily'],
                        date_result['+1']['daily'],
                        date_result['+2']['daily'],
                        date_result['+3']['daily'],
                        date_result['+4']['daily'],
                        date_result['+5']['daily']
                        ],
                datasets: [{
                data: [
                    date_result['-5']['FbBot_use'],
                    date_result['-4']['FbBot_use'],
                    date_result['-3']['FbBot_use'],
                    date_result['-2']['FbBot_use'],
                    date_result['-1']['FbBot_use'],
                    date_result['center']['FbBot_use'],
                    date_result['+1']['FbBot_use'],
                    date_result['+2']['FbBot_use'],
                    date_result['+3']['FbBot_use'],
                    date_result['+4']['FbBot_use'],
                    date_result['+5']['FbBot_use']
                ],
                label: "簽到人數",
                backgroundColor: "rgb(92, 184, 92)",
                //backgroundColor: " #5cb85c",
                fill: true,
                tension: 0
                }/*, {
                data: [
                    date_result['-5']['LineBot_use'],
                    date_result['-4']['LineBot_use'],
                    date_result['-3']['LineBot_use'],
                    date_result['-2']['LineBot_use'],
                    date_result['-1']['LineBot_use'],
                    date_result['center']['LineBot_use'],
                    date_result['+1']['LineBot_use'],
                    date_result['+2']['LineBot_use'],
                    date_result['+3']['LineBot_use'],
                    date_result['+4']['LineBot_use'],
                    date_result['+5']['LineBot_use']
                ],
                label: "簽退",
                backgroundColor: "rgba(0,0,255,0.3)",
                fill: true,
                tension: 0
                }*/
                ]
            }
            myLineChart.update();

            myLineChart2.data=
            {
                labels: [
                        date_result['-5']['daily'],
                        date_result['-4']['daily'],
                        date_result['-3']['daily'],
                        date_result['-2']['daily'],
                        date_result['-1']['daily'],
                        date_result['center']['daily'],
                        date_result['+1']['daily'],
                        date_result['+2']['daily'],
                        date_result['+3']['daily'],
                        date_result['+4']['daily'],
                        date_result['+5']['daily']
                        ],
                datasets: [/*{
                data: [
                    date_result['-5']['FbBot_use'],
                    date_result['-4']['FbBot_use'],
                    date_result['-3']['FbBot_use'],
                    date_result['-2']['FbBot_use'],
                    date_result['-1']['FbBot_use'],
                    date_result['center']['FbBot_use'],
                    date_result['+1']['FbBot_use'],
                    date_result['+2']['FbBot_use'],
                    date_result['+3']['FbBot_use'],
                    date_result['+4']['FbBot_use'],
                    date_result['+5']['FbBot_use']
                ],
                label: "簽到",
                //backgroundColor: "rgba(0,255,0,0.3)",
                backgroundColor: " #5cb85c",
                fill: true,
                tension: 0
                },*/ {
                data: [
                    date_result['-5']['LineBot_use'],
                    date_result['-4']['LineBot_use'],
                    date_result['-3']['LineBot_use'],
                    date_result['-2']['LineBot_use'],
                    date_result['-1']['LineBot_use'],
                    date_result['center']['LineBot_use'],
                    date_result['+1']['LineBot_use'],
                    date_result['+2']['LineBot_use'],
                    date_result['+3']['LineBot_use'],
                    date_result['+4']['LineBot_use'],
                    date_result['+5']['LineBot_use']
                ],
                label: "簽退人數",
                //backgroundColor: "rgba(0,0,255,0.3)",
                backgroundColor: "rgb(2, 117, 216)",                
                fill: true,
                tension: 0
                }
                ]
            }
            myLineChart2.update();


        });
    });



</script>
@endsection

