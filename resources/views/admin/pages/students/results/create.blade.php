@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="Adding A new Result">
            </x-admin-card-tool>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="{{route('admin.scs-r.store')}}" id="resForm">
                            @csrf
                                <div class="row">
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="session">Session</label>
                                        <select data-placeholder="Session" id="session" class="form-control select2" name="session">
                                            <option value=" ">-select Session-</option>
                                            @foreach ($sessions as $p)
                                            <option value="{{$p->id}}" {{activeSession()?($p->id == activeSession()->id?'selected':''):''}}>{{$p->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="program">Program</label>
                                        <select data-placeholder="Program" id="program" class="form-control select2" name="program">
                                            <option value=" ">-select Program-</option>
                                            @foreach ($programs as $p)
                                            <option value="{{$p->id}}">{{$p->abbr}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="program">Level</label>
                                        <select data-placeholder="Level" id="level" class="form-control select2" name="level">
                                            <option value=" ">-select Level-</option>
                                            @foreach ($levels as $p)
                                            <option value="{{$p->id}}">{{$p->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="course">Course</label>
                                        <select data-placeholder="Course" id="course" class="form-control select2 required" requiredname="course">
                                            <option value=" " disabled>-select course-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="student">Student</label>
                                        <select data-placeholder="Short Course Student" id="student" class="form-control select2 required" required name="student">
                                            <option value=" " disabled>-select student-</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="score">Score</label>
                                       <input type="text" required id="score" class=" form-control" name="score" placeholder="score %">
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="scs">Exam Date</label>
                                       <input type="date" value="{{date('Y-m-d')}}" class=" form-control wtk" name="exam_date">
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label>&nbsp;</label>
                                         <div class="checkbox checkbox-primary">
                                             <input id="active"  type="checkbox" class="form-check-input form-control"
                                            name="retaken" value="1">
                                        <label for="active">
                                            Retaken Exam
                                        </label>
                                    </div>
                                    </div>
                                </div>
                            <button class="btn btn-block btn-success btn-lg">Add Result</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="/vendor/tinymce/tinymce.min.js"></script>
<script>

['#session', '#level', '#program'].forEach(ele=>{
    $(ele).on('change', function(){
        return fetchData(ele);
    })
})

function fetchData(ele){

    let l = $('#level').val();
    let s = $('#session').val();
    let p = $('#program').val();
    if(!s || !s.trim().length){
        if(ele == '#level'){
        notify({title:"Please choose session"},{type:'error'})
        }
        return;
    }
    if(!p || !p.trim().length){
          if(ele == '#level'){
        notify({title:"Please choose program"},{type:'error'})
          }
        return;
    }

    if(!l|| !l.trim().length ){
        $('#course').html('<option value=" ">-Please choose level-</option>');
        $('#student').html('<option value=" ">-Please choose Level-</option>');
        return;
    }

    axios.get(`{{route('admin.students.results.json')}}?session=${s}&program=${p}&level=${l}`).then(res=>{
        let data = res.data.courses
        console.log(data)
        let opts = '<option value=" ">-Select Course-</option>'
        for (let index = 0; index < data.length; index++) {
            const e = data[index];
            opts+=`<option value="${e.id}">${e.name}</option>`
        }
        $('#course').html(opts);


        data = res.data.students
        opts = '<option value=" ">-Select Student-</option>'
        for (let index = 0; index < data.length; index++) {
            const e = data[index];
            opts+=`<option value="${e.id}">${e.name}</option>`
        }
        $('#student').html(opts);
    })

    }

    $('#resForm').on('submit', function (e) {
        e.preventDefault()
        isLoading(1)
        axios.post("{{route('admin.students.results.store')}}", new FormData(this)).then(res => {
            isLoading(0)
            let data = res.data;
            if (data.status == 200) {
                 notify({title:data.message}, {type:data.type,timeout:data.timeout});
                // reset score
                // reset student
                if(data.type == 'success'){
                    $('#student').val('').trigger('change');
                    $('#score').val('');
                }
            }
        }).catch(err => {
              isLoading(0)
            if (err.response) {
                let data = err.response.data;
                let errors;
                let description = '';
                let title = data.message

                if(data.errors){
                    errors = Object.values(data.errors);
                errors.forEach(e => {
                    description += `<br> ${e}`;
                });
            }
                notify({title,description}, {type:'error',timeout:5000});
            }
        })
    })
</script>
@endsection
