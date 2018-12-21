@extends('layouts.app')

@section('content')
    <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-success pull-right">@if($list['user']['is_up']) Monthly @else Low value @endif</span>
                        <h5>用户</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $list['user']['total'] }}</h1>
                        <div class="stat-percent font-bold text-success">{{ $list['user']['precentage'] }}% <i class="fa @if($list['user']['is_up']) fa-level-up @else fa-level-down @endif"></i></div>
                        <small>总数</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">@if($list['article']['is_up']) Monthly @else Low value @endif</span>
                        <h5>文章</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $list['article']['total'] }}</h1>
                        <div class="stat-percent font-bold text-info">{{ $list['article']['precentage'] }}% <i class="fa @if($list['article']['is_up']) fa-level-up @else fa-level-down @endif"></i></div>
                        <small>总数</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">@if($list['visitor']['is_up']) Monthly @else Low value @endif</span>
                        <h5>文章访问</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $list['visitor']['total'] }}</h1>
                        <div class="stat-percent font-bold text-navy">{{ $list['visitor']['precentage'] }}% <i class="fa @if($list['visitor']['is_up']) fa-level-up @else fa-level-down @endif"></i></div>
                        <small>游客访问</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-danger pull-right">@if($list['comment']['is_up']) Monthly @else Low value @endif</span>
                        <h5>用户评论</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $list['comment']['total'] }}</h1>
                        <div class="stat-percent font-bold text-danger">{{ $list['comment']['precentage'] }}% <i class="fa @if($list['comment']['is_up']) fa-level-up @else fa-level-down @endif"></i></div>
                        <small>当月</small>
                    </div>
                </div>
            </div>
        </div>

@endsection
