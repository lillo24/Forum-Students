@extends('layout')
@section('style')

<style>
    #main{
        position:relative;
    }
    #saveModal{
        display:block;
        color:black;
        top:0px;
    }
    #contentSaveModal{
        width:100%;
        max-width:350px;
    }
    #saveLoading{
        padding-top:1px;
        padding-bottom:1px;
        padding-right:3px;
        padding-left:3px;
        background-color:white;
        height:34px;
        width:38px;
        border:1px black solid;
        cursor: pointer;   
    }
    .chooseButton{
        border:none;
        background:none;
        text-decoration:none;
    }
</style>

@endsection
@section('extraContent')

<div id="saveModal" class="position-absolute w-100 h-100 d-flex flex-column">
    <div class="w-100 d-flex justify-content-center align-items-center" style="flex: 1 1 auto">
        <div  id="contentSaveModal" class="p-4 rounded bg-white d-flex flex-column border">
            <div class="material-symbols-outlined text-center mb-1" style="font-size: 80px;">
                lock_clock
            </div>
            <div class="text-center mb-2"><b>Salva le tue informazioni</b></div>
            <div class="text-center text-muted mb-2">Decidi se vorresti salvare il tuo accesso su questo browser</div>
            <div class="w-100 p-1 rounded position-relative" style="background-color:#8FEE8F">
                <button id="yesSaveModal" class="chooseButton w-100 text-center" >Salva</button>
            </div>
            <a href="{{route('auth')}}" id="noSaveModal" class="chooseButton mt-2 p-1 text-primary text-center">Non ora</a>
        </div>
    </div>
    <div class="text-center" style="height:120px;flex: 0 1 auto,"><u>By lillo</u> :0</div>
</div>

@endsection
@section('script')

<script>
    $('#yesSaveModal').click(function(){
        let url = "{{route('saveCred', ['remember' => true])}}"
        $.ajax({
        method: "GET",
        url: url,
        async: true,
        success: function(response){
            window.location.replace('{{route('auth')}}');
        },
        error: function(response){
            alert('Errore nel remember :(');
        }
        });
    });
</script>

@endsection