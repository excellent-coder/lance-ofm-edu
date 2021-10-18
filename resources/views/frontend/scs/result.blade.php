@extends('layouts.scs')
@section('title', '| Dashboard')
@section('content')
<div class="container py-4 bg-green-200 bg-opacity-60">
    <div class="w-full my-4">
        <h1 class="my-4 text-xl font-black text-center text-black uppercase">Your Results</h1>
        @foreach ($scsPrograms as $p)
        <div class="w-full overflow-x-auto">
            <h1 class="my-4 text-xl font-black text-center text-black uppercase">Results for {{$p->title}}</h1>
            @php
            $results = App\Models\ScsResult::where('program_id', $p->id)->where('scs_id', $auth->id)->get();
            @endphp
            <table class="w-full border border-collapse border-blue-600 table-bordered">
                <thead>
                    <tr>
                        <th class="w-1/12 px-4 py-1 border border-blue-600">#</th>
                        <th class="px-4 py-1 border border-blue-600" style="width:10%;">Course</th>
                        <th class="w-1/6 px-4 py-1 border border-blue-600">Exam Date</th>
                        <th class="w-1/4 px-4 py-1 border border-blue-600">Score</th>
                        <th class="px-4 py-1 border border-blue-600 w-1/7">Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1 ?>
                    @foreach ($results as $r)
                    @php
                    $course = App\Models\Course::find($r->course_id)->first();
                    if(!$course){
                    continue;
                    }
                    $course = $course->name;
                    @endphp
                    <tr class="border-blue-600">
                        <td class="px-4 py-1 border border-blue-600">{{$i++}}</td>
                        <td class="px-4 py-1 border border-blue-600">{{$course}}</td>
                        <td class="px-4 py-1 border border-blue-600">{{$r->exam_date}}</td>
                        <td class="px-4 py-1 border border-blue-600">{{$r->score}}</td>
                        <td class="px-4 py-1 border border-blue-600">{{$r->remark}}</td>
                    </tr>
                    @endforeach

                    <tr class="border-blue-600">
                        <td class="px-4 py-1 border border-blue-600" colspan="2">Download Result</td>

                        <td class="px-4 py-1 border border-blue-600" colspan="3" align="right">
                            <button>Download results</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
</div>
@endsection
