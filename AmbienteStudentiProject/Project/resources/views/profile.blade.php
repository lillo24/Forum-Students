@extends('layout')
@section('title', 'Profilo')
@section('style')

<style>
#headerContainer{
    z-index:10;
}
#contentContainer{
    overflow:scroll;
}
.infoData{
    border-radius:20px;
    padding-top:4px;
    padding-bottom:4px;
    background-color:white;
    border:1px black solid;
    overflow: hidden;
    text-overflow: ellipsis;
}
.info-container{
    min-width:200px;
    max-width:450px;
}
#notificationsContainer{
    flex: 1 1 auto;
}
#notifications{
    border-right: 1px black solid; 
    border-left: 1px black solid; 
    border-bottom:1px black solid;
    -ms-overflow-style: none;
    scrollbar-width: none;
}
#notifications::-webkit-scrollbar {
    display: none;
}
.text {
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;

    @supports (-webkit-line-clamp: 2) {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: initial;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
}
.commentNot{
    position:relative;
    margin-left:0.5rem;
    padding-left: 10px;
    padding-top: 1px;
    padding-bottom: 1px;
    margin-top:4px;
    margin-bottom:2px;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    display: -webkit-box;
    -webkit-box-orient: vertical;
}
.commentNot::before {
    background-color: var(--bs-gray-400);
    border-radius: 4px;
    bottom: 0;
    content: "";
    left: 0;
    position: absolute;
    top: 0;
    width: 4px;
}
.openMenu{
    top:57px !important;
}
#dropDownContainer{
    z-index:9;
    right:21px;
    top:6px;
    border-right:1px black solid;
    border-left:1px black solid;
    border-bottom:1px black solid;
    transition: all 1s ease;
}
#dropDownButton{
    font-size:20px;
}
#reportError{
    background-color:#ff665e;
    font-size:25px;
}
#reportErrorModal{
    display:none;
    background:rgba(0,0,0,0.6);
    top:0px;
    z-index:10;
    color:black;
}
#contentReportErrorModal{
    z-index:15;
    margin-bottom:150px;
    width:80%;
    max-width:650px;
    font-size:18px;
}
.chooseButton{
    border:none;
    background:none;
}
.button{
    cursor:pointer;
}
</style>

@endsection
@section('content')

<div class="d-flex flex-column align-items-center w-100 pb-5">
        <div class="info-container d-flex flex-column align-items-center mt-3 pe-4 ps-4 rounded w-100 pt-4 pb-4">
            <div class="d-flex">
                <div class="material-symbols-outlined me-2" style="font-size: 50px;">{{$user->levelName()['image']}}</div>
                <div class="text-nowrap pe-2 ps-2 pt-2 pb-2 text-center bg-white rounded border mb-3" style="font-size:22px;width:fit-content"><b>{{$user->levelName()['name']}}</b></div>
            </div>
            @if($user['id'] == Auth::id())
                <div class="infoData text-nowrap mb-2 pe-3 ps-3 w-100">{{$user['email']}}</div>
                <div class="infoData text-nowrap mb-4 pe-3 ps-3 w-100">{{$user['name']}}</div>
                @if($user['student_level'] == 0 Or $user['student_level'] == 1 Or $user['student_level'] == 2)
                    <div id="notificationsContainer" class="w-100 border-top pt-4 pb-4 border-bottom">
                        <h2 class="p-2 text-center m-0 rounded-top bg-white " style="border: 1px black solid">Notifiche</h2>
                        <div id="notifications" class="rounded-bottom bg-white" style="max-height:300px;overflow:scroll">
                            @if($numberLikeNots != 0 Or sizeOf($commentNots) != 0 Or sizeOf($reportNots))

                                @if($numberLikeNots != 0)
                                    <div class="w-100 p-2 d-flex align-items-center">
                                        <div style="flex: 1 1 auto">La tua proposta ha ricevuto: {{$numberLikeNots}} Likes</div>
                                        <a href="{{route('showComments', ['id'=>$user->activeProposal()->get()[0]['id']])}}" class="material-symbols-outlined ms-1" style="font-size:20px;text-decoration:none;color:black">arrow_circle_right</a>
                                    </div>
                                @endif
                                
                                @if(sizeOf($commentNots) != 0)
                                    @foreach($commentNots as $commentNot)
                                        @if($commentNot['comment_referred_id'] == null)
                                            <div class="w-100 p-2 d-flex align-items-center border-bottom">
                                                <div style="flex: 1 1 auto;min-width:0px"><div>Qualcuno ha commentato la tua proposta: </div><div class="commentNot text-muted">{{$commentNot->comment['comment_text']}}</div></div>
                                                <a href="{{route('showComments', ['id'=>$user->activeProposal()->get()[0]['id']])}}" class="material-symbols-outlined ms-1" style="font-size:20px;text-decoration:none;color:black">arrow_circle_right</a>
                                            </div>
                                        @else
                                            <div class="w-100 p-2 d-flex align-items-center border-bottom">
                                                <div style="flex: 1 1 auto;min-width:0px"><div>Hanno risposto a un tuo commento: </div><div class="commentNot text-muted">{{$commentNot->comment['comment_text']}}</div></div>
                                                <a href="{{route('showOneComment', ['comment_id'=> $commentNot['comment_referred_id']])}}" class="material-symbols-outlined ms-1" style="font-size:20px;text-decoration:none;color:black">arrow_circle_right</a>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                                @if(sizeOf($reportNots) != 0)
                                    @foreach($reportNots as $reportNot)
                                    <div class="w-100 p-2 border-bottom">
                                        <div class="text-danger">Sei stato reportato</div>
                                        <div style="max-height:150px;overflow:scroll;word-break:break-word;white-space: pre-line">{{$reportNot->report['report_text']}}</div>
                                    </div>
                                    @endforeach
                                @endif
                            @else

                                <div class="text-center w-100 p-1">
                                    <div style="font-size: 11px;">Vuoto assoluto</div>
                                    <img src="/images/notified-cat.png" style="width:60px"></img>
                                </div>
                                
                            @endif
                        </div>
                    </div>
                    <div class="w-100 border-bottom text-center mt-3 text-muted">La tua proposta:</div>
                    @if($user->activeProposal()->exists())
                    <div id="proposal" class="bg-white p-2 w-100 mb-3" style="border:1px black solid;flex: 1 1 auto;min-height:100px;">
                        <div class="w-100 border-bottom text-center" style="word-break:break-word;white-space: pre-line"><b>{{$user->activeProposal()->get()[0]['proposal_title']}}</b></div>
                        <div class="p-2" style="word-break:break-word;white-space: pre-line">{{$user->activeProposal()->get()[0]['proposal_text']}}</div>
                        <a href="{{route('showComments', ['id'=>$user->activeProposal()->get()[0]['id']])}}"></a>
                    </div>
                    @else
                        <div class="text-center">Non hai ancora scritto una proposta <br> (Neanche un'idea?)</div>
                    @endif
                @endif
            @endif
        </div>
    <div class="mt-2 pb-5">
        <a href="{{route('logout')}}" style=" color:black">Log out</a>
    </div>  
</div>

@endsection
@section('extra')

<div id="dropDownContainer" class="d-flex flex-column position-absolute rounded-bottom bg-white">
    <a href="{{route('documentation')}}" class="material-symbols-outlined text-center user-select-none button">help</a>
    <div id="reportError" class="material-symbols-outlined text-center user-select-none text-white button">flag</div>
    <div id="dropDownButton" class="material-symbols-outlined rounded-bottom p-1 user-select-none button">menu</div>
</div>

<div id="reportErrorModal" class="position-fixed w-100 h-100">
    <div class="w-100 d-flex justify-content-center align-items-center h-100 position-relative">
        <div id="closeReportErrorModal" class="position-absolute w-100 h-100"></div>
        <div id="contentReportErrorModal" class="bg-white rounded d-flex flex-column justify-content-center pt-2 pb-2 p-3">
            <div class="text-center p-1 text-muted border-bottom" style="font-size:22px">Segnala l'errore:</div>
            <div class="w-100 text-center pt-2 pb-1 rounded" style="font-size:12px"> Scrivi la descrizione</div>
            <textarea id="reportText" class="ps-2 pt-2 w-100"placeholder="Non va la pagina delle proposte quando...." style="font-size:15px;min-height:200px;resize:none;"></textarea>
            <div class="text-center text-danger p-2" style="font-size:14px">Utlizzarlo con criterio, manderai un email al mio indirizzo personale quindi metto a disposizione il mio tempo gratuitamente, perfavore non farmi perdere tempo :( <br> (spero basti la gentilezza ⊂⁠(｡⁠•́⁠‿⁠•̀⁠｡)⁠つ)</div>
            <button id="undoReportErrorButton" class="chooseButton border-top p-1">Annulla</button>
            <button id="reportErrorButton" class="chooseButton border-top p-1">Invia</button>
        </div>
    </div>
</div>

@endsection
@section('script')

<script>
    $("#dropDownButton").click(function(){
        if($('#dropDownContainer').hasClass('openMenu')){
            $('#dropDownContainer').removeClass('openMenu')
        }else{
            $('#dropDownContainer').addClass('openMenu')
        }
    });
    $("#reportError").click(function(){
        $('#reportErrorModal').css('display', 'block');
    });
    $('#closeReportErrorModal, #undoReportErrorButton').on('click', function(){
        $('#reportErrorModal').css('display', 'none');
    });
    $("#reportErrorButton").click(function(){
        let reportText = $("#reportText").val();
        let url = "{{route('report.error')}}"
        $.ajax({
            method: "POST",
            url: url,
            async: true,
            data: JSON.stringify({
                'description': reportText,
            }),
            dataType: 'json',
            contentType: 'application/json',
            complete: function(response){
                $('#reportErrorModal').css('display', 'none');
            }
        });
    });
</script>

@endsection