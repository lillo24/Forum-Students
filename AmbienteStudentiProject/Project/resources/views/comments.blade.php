<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery.collapser.js')}}"></script>
    <script src="http://benalman.com/code/projects/jquery-throttle-debounce/jquery.ba-throttle-debounce.js"></script>
    <title>A.S. Berto</title>
    <style>
        .material-symbols-outlined {
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48
        }
        html, body {
            height:100vh;
            overflow:hidden;
        }
        #screen{
            overflow:hidden;
        }
        #main{
            max-width:1000px;
            min-height:0;
            min-width:0;
            flex: 1 1 auto;
        }
        #backButtonContainer{
            padding-top:0.5rem;
        }
        @media (min-width:1000px){
            #backButtonContainer{
                border-bottom: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color)!important;
                padding-top:0.25rem;
            }
            #main{
                border-right: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color)!important;
                border-left: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color)!important;
            }
        }
        #backButton{
            flex: 0 1 auto;
            left:0px;
            font-size: clamp(27px,4vw,30px);
            text-decoration:none; 
            color:black;
            cursor:pointer;
        }
        #saveButton{
            border:none;
            background:none;
        }
        #proposal{
            flex: 0 1 auto;
            min-height:20%;
            min-width:0;
            border-bottom: 2px var(--bs-border-style) var(--bs-border-color)!important;
            overflow:scroll;
        }
        #comments{
            flex: 1 1 auto;
            overflow:scroll;
            -ms-overflow-style: none;
            scrollbar-width: none;
            min-height:0;
            min-width:0;
            padding-bottom:8rem;
        }
        #comments::-webkit-scrollbar {
            display: none;
        }
        a{
            font-size: clamp(14px, 2.5vw, 18px);
            text-decoration-color:#dee2e6 ;
            color:#707070;
        }
        a:hover{
            color:black;
        }
        #commentText{
            white-space:pre-line;
            width:100%;
            border:none;
            resize:none;
            overflow:scroll;
            outline: none;
            min-height:40px;
            font-size: 22px;
        }
        .show-answers-button{
            z-index:2;
        }
        #footer{
            position:absolute; 
            bottom:0px;
            z-index:100;
        }
        #answeringToContainer{
            display:none;
        }
        #answeringTo{
            flex: 1 1 auto;
            opacity: 0.64;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space:nowrap;
        }
        #closeAnsweringTo{
            font-size:20px;
            cursor:pointer;
        }
        #relCommentsContainer{
            display:flex;
        }
        .delete-button{
            opacity:0;
            transition: opacity 1s;
        }
        .comment-container:hover .delete-button {
            opacity:1;
        }
        #deleteModal{
            display:none;
            background:rgba(0,0,0,0.6);
            top:0px;
            z-index:2;
            color:black;
        }
        #contentDeleteModal{
            z-index:3;
            margin-bottom:150px;
            width:250px;
            font-size:18px;
        }
        .chooseButton{
            border:none;
            background:none;
        }
        .reply-button{
            float:right;
            font-size:13px;
            color: rgb(90,90,90);
            cursor:pointer;
            -webkit-user-select: none!important;
            -moz-user-select: none!important;
            user-select: none!important;
        }
        .test-muted{
            color:var(--bs-secondary);
        }
    </style>
</head>

<style>
    .proposal-title{
        font-size: clamp(15px,4vw,17px);
    }

    .proposal-text{
        font-size: clamp(17px,4vw,22px);
    }
</style>

<body>
<div id="screen"  class="d-flex flex-column align-items-center w-100 h-100 position-relative">
    <div id="backButtonContainer" class="pb-1 w-100 bg-white" style="flex: 0 1 auto;">
        <div class="w-100 text-center position-relative" style="font-size: clamp(17px,4vw,20px);">
            <div id="backButton" class="position-absolute material-symbols-outlined" onclick="history.back()">keyboard_arrow_left</div>
            Commenti
        </div>
    </div>
    <div id="main" class="d-flex flex-column bg-white w-100  position-relative">
        <div id="proposal" class="pt-3 ps-3 pe-3 pb-3">
            <div class="d-flex">
                <div class="proposal-title" style="flex:1 1 auto;width:fit-content;word-break:break-word;white-space: pre-line"><b class="border-bottom">{{$proposal['proposal_title']}}</b></div>
                <div id="proposalLikes">{{$proposal['proposal_likes']}}</div>
                <div id="likeProposalButton" class="ms-1 user-select-none material-symbols-outlined " style="cursor:pointer; @if($proposal->userLiked()) color:red @else color:black @endif">favorite</div>
            </div>
            <div class="proposal-text" style="white-space:pre-line;word-break:break-word;">{{$proposal['proposal_text']}}</div>
        </div>
        <div id="comments" class="w-100 pt-3 pe-2 ps-2">
            @foreach($comments as $comment)
                <div class="comment-container d-flex flex-column mb-3 ms-2 me-2">
                    <div id="comment{{$comment['id']}}" class="border-end border-start border-top position-relative @if($comment['comment_text'] == 'Commento cancellato') text-muted @endif" style="border-bottom:2px var(--bs-border-style) var(--bs-border-color)!important;">
                        <div class="d-flex ps-3 pe-3 pt-3 pb-1">
                            <div style="flex: 1 1 auto;">
                                <div style="font-size: clamp(18px,2vw,20px);">Uno studente</div>
                            </div>
                            @if($comment['comment_text'] != 'Commento cancellato')
                                @if($comment->user['id'] == Auth::id())
                                    <div id="deleteButton{{$comment['id']}}" class="delete-button material-symbols-outlined me-2 text-danger user-select-none" style="font-size: clamp(16px,3vw,18px);cursor:pointer;flex: 0 1 auto;">delete</div>
                                @endif
                            @endif
                            <div  id="numberLikes{{$comment['id']}}" class="me-1 text-muted" style="font-size: 13px;margin-top:-2px;">{{$comment['comment_likes']}}</div>
                            <div id="likeButton{{$comment['id']}}" class="like-button material-symbols-outlined user-select-none " style="@if($comment->userLiked()) color:red @else color:black @endif ;font-size: clamp(16px,3vw,18px);cursor:pointer;flex: 0 1 auto;">favorite</div>
                        </div>
                        <div class="ps-4 pe-2 pb-4 mb-3" style="font-size: clamp(16px,2vw,18px);" >
                            <div id="textDiv{{$comment['id']}}" class="ms-1 collapseLinesComment" style="white-space:pre-line; word-break:break-word;">{{$comment['comment_text']}}</div>
                        </div>
                        <div class="w-100 position-absolute" style="bottom:0px;">
                            @if($comment->relatedComments()->exists())
                                <div class="w-100 position-absolute d-flex justify-content-center" style="color: rgb(142,142,142);bottom:-11px;font-size: 14px;">
                                    <div id="showAnswers{{$comment['id']}}" class="pe-2 ps-2 show-answers-button user-select-none" style="background-color:white;width:fit-content;cursor:pointer;">Vedi risposte ({{$comment->relatedComments()->count()}})</div>
                                </div>
                            @endif
                            <div  id="reply{{$comment['id']}}" class="reply-button me-3 mb-2 d-flex align-items-center d-inline">
                                Rispondi
                            </div>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-center">
                        <div id ="relCommentsContainer{{$comment['id']}}" class="flex-column border-end border-start" style="width:95%;">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="deleteModal" class="position-fixed w-100 h-100">
        <div class="w-100 d-flex justify-content-center align-items-center h-100">
            <div id="contentDeleteModal" class="bg-white rounded d-flex flex-column" >
                <div class="text-center p-1 text-muted">Sei sicuro di cancellare?</div>
                <button id="noDeleteModal" class="chooseButton border-top p-1">Annulla</button>
                <button id="yesDeleteModal" class="chooseButton border-top p-1 text-danger" value="">Elimina</button>
            </div>
        </div>
    </div>
</div>
<div id="footer" class="w-100 d-flex flex-column align-items-center bg-white">
    <div id="answeringToContainer" class="w-100">
        <div class="border-end border-start border-top rounded-top pt-1 pb-1 p-2 d-flex bg-white me-auto ms-auto" style="width:97.5%;">
            <div class="material-symbols-outlined pe-1">forward</div><div style="flex:0 0 auto">Rispondi a:</div><div class="ms-1" id="answeringTo" data-who="null "> qualcuno di bello</div>
            <span id="closeAnsweringTo" class="material-symbols-outlined">close</span>
        </div>
    </div>
    <div class="w-100 d-flex border-top">        
        <div class="w-100 mt-1 mb-1 ms-2 d-flex">
            <textarea id="commentText" style="height: 40px;"></textarea>
        </div>
        <button class="me-3" id="saveButton">Invia</button></div>
    </div>
</div>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
</script>
<script>
    $(window).bind("load", function() {
        console.log($('html').width())
        if (navigator.userAgent.match(/(iPod|iPhone)/i) && $('html').width() < 500) {
            $("body").height("89vh");
            $("html").height("89vh");
        }
        $('#screen').css('display', 'flex');
    });
    const cT =$("#commentText");
    $(document).ready(function() {
        cT.css("height", 0);
        cT.css("height", cT.prop('scrollHeight') + "px"); 
    });
    $("#commentText").on("input", ($.debounce(100, function(e) {
        cT.css("height", 0);
        this.style.height = (this.scrollHeight) + "px"; 
    })));
    cT.each(function () {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;");
        }).on("input", function(){
        this.style.height = (this.scrollHeight) + "px";
    });
    $('.collapseLinesComment').collapser({
        speed: 'fast',
        mode: 'lines',
        truncate: 3,
        showText: 'Espandi',
        hideText: 'Nascondi',
    });
    $("#saveButton").click(function(){
        let url = "{{route('comment.store')}}";
        let proposal_id = "@if(!isset($proposal['proposal_id'])){{$proposal['id']}}@else{{$proposal['proposal_id']}}@endif";
        let commentText = $('#commentText').val().trim();
        if(!commentText){
            alert("Perchè un commento vuoto");
            return;
        }
        let rel_comment_id = $('#answeringTo').data('who');
        $.ajax({
        method: "POST",
        url: url,
        async: true,
        data: JSON.stringify({
            'comment_text' : commentText,
            'proposal_id' : proposal_id,
            'rel_comment_id' : rel_comment_id,
        }),
        dataType: 'json',
        contentType: 'application/json',
        error: function(){
            alert('Errore nel salvataggio, segnala il problema nella home')
        },
        success: function(response){
            $relComment = (response[0]['rel_comment_id'] != null) @if(!isset($proposal['proposal_id']))@else && (response[0]['rel_comment_id'] != {{$proposal['id']}}) @endif;
            if($relComment){
                $("#relCommentsContainer" + response[0]['rel_comment_id']).prepend("<div class='comment-container d-flex flex-column ms-2 me-2'><div id='comment" + response[0]['id'] + "' class='mb-3 position-relative'><div class='d-flex ps-3 pe-3 pt-3 pb-1'><div style='flex: 1 1 auto;'><div style='font-size: clamp(18px,2vw,20px);'>Uno studente</div></div><div id='deleteButton" + response[0]['id'] + "' class='delete-button material-symbols-outlined ms-2 text-danger' style='font-size: clamp(15px,2vw,17px);cursor:pointer;flex: 0 1 auto'>delete</div><div id='likeButton" + response[0]['id'] + "' class='like-button material-symbols-outlined ms-2 user-select-none' style='font-size: clamp(15px,2vw,17px);cursor:pointer;flex: 0 1 auto;'>favorite</div></div><div class='ps-4 pe-2 border-bottom' style='font-size: clamp(16px,2vw,18px);padding-bottom:2.5rem;'><div id='textDiv"+ response[0]['id'] + "' class='ms-1 collapseLinesComment' style='white-space:pre-line; word-break:break-word;'>" + $('#commentText').val() + "</div></div><div class='w-100 position-absolute' style='bottom:0px;'><div  id='reply"+ response[0]['id'] + "' class='reply-button me-3 mb-2 d-flex align-items-center d-inline'>Rispondi</div></div></div><div class='d-flex w-100 justify-content-center'><div id ='relCommentsContainer" + response[0]['id'] + "' class='flex-column border-end border-start' style='width:95%;'></div></div></div>");
            }else{
                $("#comments").prepend("<div class='comment-container d-flex flex-column mb-3 ms-2 me-2'><div id='comment" + response[0]['id'] + "' class='border-end border-start border-top position-relative' style='border-bottom:2px var(--bs-border-style) var(--bs-border-color)!important;''><div class='d-flex ps-3 pe-3 pt-3 pb-1'><div style='flex: 1 1 auto;'><div style='font-size: clamp(18px,2vw,20px);'>Uno studende</div></div><div id='deleteButton" + response[0]['id'] + "' class='delete-button material-symbols-outlined ms-2 text-danger' style='font-size: clamp(15px,2vw,17px);cursor:pointer;flex: 0 1 auto'>delete</div><div id='likeButton" + response[0]['id'] + "' class='like-button material-symbols-outlined ms-2 user-select-none' style='font-size: clamp(15px,2vw,17px);cursor:pointer;flex: 0 1 auto;'>favorite</div></div><div class='ps-4 pe-2 pb-4 mb-3' style='font-size: clamp(16px,2vw,18px);'><div id='textDiv"+ response[0]['id'] + "' class='ms-1 collapseLinesComment' style='white-space:pre-line; word-break:break-word;'>" + $('#commentText').val() + "</div></div><div class='w-100 position-absolute' style='bottom:0px;'><div  id='reply"+ response[0]['id'] + "' class='reply-button me-3 mb-2 d-flex align-items-center d-inline'>Rispondi</div></div></div><div class='d-flex w-100 justify-content-center'><div id ='relCommentsContainer" + response[0]['id'] + "' class='flex-column border-end border-start' style='width:95%;'></div></div></div>");
            }
            $('#commentText').val("");
            $('#commentText').css("height", 0);
        }
        });
    });
    $("#comments").on('click', '.delete-button', function(e){
        $('#deleteModal').css('display', 'block');
        let comment_id = e.target.id.match(/\d+/);
        $('#yesDeleteModal').attr('value', comment_id);
    });
    $("#deleteModal").click(function(){
        $('#yesDeleteModal').attr('value', "");
        $('#deleteModal').css('display', 'none');
    });
    $("#yesDeleteModal").click(function(){
        let This = this
        let comment_id = $(This).attr("value").match(/\d+/);
        let url = "{{route('comment.cancel', ['comment_id' => 'comment_value'])}}"
        url = url.replace('comment_value', comment_id[0])
        $.ajax({
            method: "DELETE",
            url: url,
            async: true,
            error: function(response){
                alert('Errore nella cancellazione');
            },
            success: function(response){
                $('#comment' + comment_id).addClass('test-muted');
                $('#textDiv' + comment_id).text('Commento cancellato');
            }
        });
    });
    $("#likeProposalButton").click(function(){
        let This = this;
        let id = {{$proposal['id']}};
        let url = "{{route('like', ['id' => 'proposal_value', 'type' => 'type_value'])}}"
        url = url.replace('proposal_value', id);
        {{$isProposal}}
        url = url.replace('type_value', @if(!$isProposal) 'comment' @else 'proposal' @endif );
        $.ajax({
        method: "GET",
        url: url,
        async: true,
        error: function(){
            alert('couldn\'t load');
        },
        success: function(response){
            if(response == 'saved'){
                $(This).css('color', 'red')
                $('#proposalLikes').text(parseInt($('#proposalLikes').text()) + 1)
            }else if(response == 'destroyed'){
                $(This).css('color', 'rgb(33, 37, 41)')
                $('#proposalLikes').text(parseInt($('#proposalLikes').text()) - 1)    
            }
        }
        });
    });
    $("#comments").on('click', '.like-button', function(e){
        let This = this;
        let id = $(this).attr("id").match(/\d+/);
        let url = "{{route('like', ['id' => 'proposal_value', 'type' => 'type_value'])}}"
        url = url.replace('proposal_value', id[0])
        url = url.replace('type_value', 'comment')
        $.ajax({
        method: "GET",
        url: url,
        async: true,
        error: function(){
            alert('couldn\'t load');
        },
        success: function(response){
            if(response == 'saved'){
                $(This).css('color', 'red')
                $('#numberLikes' + id[0]).text(parseInt($('#numberLikes' + id[0]).text()) + 1)
            }else if(response == 'destroyed'){
                $(This).css('color', 'rgb(33, 37, 41)')
                $('#numberLikes' + id[0]).text(parseInt($('#numberLikes' + id[0]).text()) - 1)    
            }
        }
        });
    });
    $("#comments").on('click', '.reply-button', function(e){
        let comment_id = e.target.id.match(/\d+/);
        let text = $('#textDiv' + comment_id[0]).text().replace('.', '');
        $('#answeringTo').text(text);
        $('#answeringToContainer').show();
        $('#answeringTo').data('who', comment_id[0]);
    });
    $("#comments").on('click', '.show-answers-button', function(e){
        let comment_id = e.target.id.match(/\d+/);
        if($("#" + e.target.id).text() == 'Hide answers'){
            $("#relCommentsContainer" + comment_id).css('display', 'none');
            $("#" + e.target.id).text('Show answers');
        }else if($("#" + e.target.id).text() == 'Show answers'){
            $("#relCommentsContainer" + comment_id).css('display', 'block');
            $("#" + e.target.id).text('Hide answers');
        }else{
            let url = "{{route('relatedComments', ['comment_id' => 'comment_value'])}}"
            url = url.replace('comment_value', comment_id[0])
            $.ajax({
                method: "Get",
                url: url,
                async: true,
                error: function(response){
                    alert('Errore nella visualizzazione');
                },
                success: function(response){
                    if(Array.isArray(response)){
                        response.forEach(element => $("#relCommentsContainer" + comment_id).append(element));
                        $("#" + e.target.id).text('Hide answers');
                    }else{
                        window.location = response;
                    }
                }
            });
        }
    });
    $("#closeAnsweringTo").click(function(){
        $('#answeringToContainer').hide();
        $('#answeringTo').data('who', "null");
    });
    $("#commentText").focusout(function () {
        $("#headerContainer").focus()
    });
</script>

<body>
</html>