@extends('home')

@section('css')
<style>
   
@media only screen and (max-width: 800px) {
    .wrapper-1 {
    width: auto;
    }
}
.wrapper-2 {
  width: auto;
}

</style>
@endsection

@section('stage')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    <h5 class="font-weight-bold text-success mr-5 my_nav_text"><span class="h3 font-weight-bold"><i class="fas fa-pencil-alt my_nav_text"></i> {{$this_classs->Classs_Name}}</span>的學生名單&nbsp;</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="overflow-auto table  table-hover  text-middle" id="tblAppendGrid"></table>
                        </div>

                    <button id="save_student_list" type="button" class="btn my_nav_color text-light float-right ml-3">存檔</button>
                    <a href="{{route('classs.classs')}}" class="btn btn-secondary  float-right">不變更返回班級</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{asset('vendor/jquery.appendGrid-master/dist/AppendGrid.js')}}"></script>
<script>
document.getElementById('nav_title').innerHTML="<small>學生名單</small>";
var this_classs={!! json_encode($this_classs) !!};
var classs_student={!! json_encode($classs_student) !!};

/*var width = window.innerWidth
|| document.documentElement.clientWidth
|| document.body.clientWidth;
alert(width)*/




    window.myAppendGrid = new AppendGrid({
        element: document.getElementById("tblAppendGrid"),
        uiFramework: "bootstrap5", // ui framework
        iconFramework: "fontawesome5", // iconic font
        initRows: 3,


        columns: [
        {
            name: "name",
            display: "姓名 (必填)",ctrlClass:"wrapper-1"
        },


        {
            name: "gender",
            display: "性別",
            type: "select",
            ctrlOptions: [
                "",
                "男",
                "女",
            ],
            ctrlClass:"wrapper-2"
        },


            {
            name: "school",
            display: "學校",ctrlClass:"wrapper-1"
            },

            {
            name: "grade",
            display: "年級",
            type: "select",
            ctrlOptions: [
            "",
            "小一",
            "小二",
            "小三",
            "小四",
            "小五",
            "小六",
            "國一",
            "國二",
            "國三"
            ],
            ctrlClass:"wrapper-2"
            },


            {
            name: "parent_name",
            display: "家長姓名",ctrlClass:"wrapper-1"
            },

            {
            name: "parent_phone",
            display: "家長電話",ctrlClass:"wrapper-1"
            },

            {
            name: "memo",
            type: "textarea",
            display: "附註",ctrlClass:"wrapper-1"
            },

            {
            name: "parent_line",
            display: "家長的Line",ctrlClass:"wrapper-1",type:"hidden"
            },

            {
            name: "id",
            display: "id",ctrlClass:"wrapper-1",type:"hidden"
            },



            ],









        sectionClasses: {
            table: 'is-narrow is-fullwidth ' }

    });

/*
if(this_classs.Student_List!=null){
    var Student_List= JSON.parse(this_classs.Student_List);
    console.log('Student_List',Student_List)
    myAppendGrid.removeEmptyRows();
    myAppendGrid.appendRow(Student_List);
}*/
console.log('classs_student',classs_student)
if(classs_student.length!=0){
    var Student_List= classs_student;
    console.log('Student_List',Student_List)
    myAppendGrid.removeEmptyRows();
    myAppendGrid.appendRow(Student_List);
}

$('#save_student_list').click(function(){
 var result=myAppendGrid.getAllValue();
 var result_old=classs_student;
 console.log('result',result)
 if(result.length==0){
    result=null;
 }
 if(result_old.length==0){
    result_old=null;
 }
 var format = /[!@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?]+/;
 var fine_name = false
 if(result!=null){
    for (let i = 0; i < result.length; i++) {
        st_name=result[i].name
        if(format.test(st_name)){
            fine_name=false
            break;
        } else {
            fine_name=true
        }
    }
 }else{
    fine_name=true
     console.log("result null")
 }
 console.log("fine_name",fine_name)
 if(fine_name){

 
        $.ajax({
                    type:'POST',
                    url:'/classs/'+this_classs.id+'/student',
                    dataType:'json',
                    data:{
                    'Student_List':result,
                    'Student_List_old':result_old,
                    _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        console.log("data",data)
                        var result=data.result;
                        if(result=='success'){
                            //window.location.href = "/classs"+"?success_msg="+data.msg;
                            window.location.href = "/classs/"+data.id+"/student"+"?success_msg="+data.msg;
                        }else{
                            //window.location.href = "/classs"+"?error_msg="+data.msg;
                            window.location.href = "/classs/"+data.id+"/student"+"?error_msg="+data.msg;
                        }
                    },
                    error:function(e){
                        alert('Error: ' + e);
                    }
        });
    }else{
        alert("姓名不可包含特殊符號")
    }
})
</script>
@endsection
