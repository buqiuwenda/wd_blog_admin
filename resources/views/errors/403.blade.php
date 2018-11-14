@extends('errors.main')

@section('code')
    403
@endsection

@section('content')

    <h1>403</h1>
    <h3 class="font-bold">访问被拒绝了</h3>

    <div class="error-desc">

        <br/>

        你好像没有此页面的访问权限

        <br/>

        请访问其它页面吧

        <br/>

        <a href="{{ route('home::dashboard.show') }}" class="btn btn-primary m-t">返回主页</a>
    </div>


@endsection