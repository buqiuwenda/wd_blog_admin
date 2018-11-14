@extends('errors.main')

@section('code')
    500
@endsection

@section('content')

    <h1>500</h1>
    <h3 class="font-bold">内部服务错误</h3>

    <div class="error-desc">

        <br/>

        程序员小哥写代码BUG满天飞

        <br/>
        服务异常了, 我们已经记录此问题

        <br/>

        <br />

        <p>
            Message: {{ $exception->getMessage() }}
        </p>

        <a href="{{ route('home::dashboard.show') }}" class="btn btn-primary m-t">返回主页</a>

    </div>

@endsection