@extends('dashboard.templates.master')

@section('styles')
<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:700' rel='stylesheet' type='text/css'>
@stop

@section('content')
<div class="row">
    <div class="cards-wrapper">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 card-wrapper">
            <div class="card clearfix">

            </div>
        </div>
    </div>
</div>
@stop

@section('jsFooter')
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@stop
