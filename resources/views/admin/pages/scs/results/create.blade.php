@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="/css/file.css">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool title="Adding New Result">
            </x-admin-card-tool>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="{{route('admin.scs-r.store')}}" id="resForm">
                            @csrf
                                <div class="row">
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="year">Years</label>
                                        <select data-placeholder="Year" id="year" class="form-control select2" name="year">
                                            <option value=" ">-select Year-</option>
                                            @foreach ($years as $p)
                                            <option value="{{$p}}">{{$p}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="program">Program</label>
                                        <select data-placeholder="Program" id="program" class="form-control select2" name="program">
                                            <option value=" " disabled>-select-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="course">Course</label>
                                        <select data-placeholder="Course" id="course" class="form-control select2" name="course">
                                            <option value=" " disabled>-select course-</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="scs">Student</label>
                                        <select data-placeholder="Short Course Student" id="scs" class="form-control select2" name="student">
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
    $('#year').on('change', function(){
    let v = $(this).val();
    axios.get(`{{route('admin.scs-r.json')}}?year=${v}`).then(res=>{
        let data = res.data
        let opts = '<option value=" ">-Select Program-</option>'
        for (let index = 0; index < data.length; index++) {
            const e = data[index];
            opts+=`<option value="${e.id}">${e.abbr}</option>`
        }
        $('#program').html(opts);
    })

    })

    $('#program').on('change', function(){
    let v = $(this).val();

    if(!v || !v.length){
        $('#course').html('');
        $('#scs').html('');
        return;
    }

    axios.get(`{{route('admin.scs-r.json')}}?program=${v}`).then(res=>{
        let data = res.data.courses
        console.log(data)
        let opts = '<option value=" ">-Select Course-</option>'
        for (let index = 0; index < data.length; index++) {
            const e = data[index];
            opts+=`<option value="${e.id}">${e.name}</option>`
        }
        $('#course').html(opts);


        data = res.data.scs
        opts = '<option value=" ">-Select Student-</option>'
        for (let index = 0; index < data.length; index++) {
            const e = data[index];
            opts+=`<option value="${e.id}">${e.first_name+' '+ e.last_name}</option>`
        }
        $('#scs').html(opts);
    })
    })

    $('#resForm').on('submit', function (e) {
        e.preventDefault()
        isLoading(1)
        axios.post("{{route('admin.scs-r.store')}}", new FormData(this)).then(res => {
            isLoading(0)
            let data = res.data;
            if (data.status == 200) {
                 notify({title:data.message}, {type:data.type,timeout:data.timeout});
                // reset score
                // reset student
                if(data.type == 'success'){
                    $('#scs').val('').trigger('change');
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
