@extends('layout')
@section('title', 'Page di prova')
@section('content')

<style>
    .a{
        opacity:1;
    }
    .b{
        opacity:0;
    }
    .a:hover .b{
        opacity:1;
    }
</style>
<div class="a" style="width:100%; height: 50px;"><div><div class="b">Banana</div></div></div>
<div class="a" style="width:100%; height: 50px;"><div class="b">Banana</div></div>
<div class="a" style="width:100%; height: 50px;"><div class="b">Banana</div></div>

@endsection

@section('script')
<script>
$( document ).ready(function() {
    console.log( "ready!" );
});
</script>
@endsection