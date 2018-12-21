   @extends('errors.main')

@section('code')
    404
@endsection

@section('content')

    <h1>404</h1>
    <h3 class="font-bold">页面不存在</h3>

    <div class="error-desc">

        <br/>

        页面丢掉了。。。估计是BUG大神删库跑路了

        <br/>

        请访问其它页面吧

        <br/>

        <a href="{{ route('home') }}" class="btn btn-primary m-t">返回主页</a>
    </div>


@endsection