@extends('layouts.frontend')

@section('title', 'Canets - Sinh Viên Giúp Việc, Gia  Sư nhé')
@section('content')

<section id="trogiup">
</section>
<section id="section_two">
    <div class="my_container">
        @foreach($qAndA as $key => $qa)
            <div class="question-anwser">
                <p class="question">
                {{( $key+1) . ' . ' . $qa->question }}</p>
                <span class="anwser">
                    <i class="fa fa-reply"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                    {{ $qa->answer }}
                </span>
            </div>
        @endforeach
    </div>
</section>


@stop