@extends('layout')
@section('title', 'A.S. Berto | 3rd Week')
@section('style')

<style>
@media (min-width:950px){
    #main{
        flex-direction: row;
    }
    #comments{
        border-top: none !important;
        border-left: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color);
    }
}
#contentContainer{
    flex:0 0 auto;
    padding: 1.2rem;
}
#firstP{
    font-size: 14px;
}
#proposalTitle{
    font-size: 20px;
    outline:none;
    border:none;
}
#proposal{
    font-size:16px;
}
#saveButtonContainer{
    padding-top:1px;
    padding-bottom:1px;
    padding-left:10px;
    height:35px;
}
#saveButton{
    font-size: 30px;
    background-color:white;
    cursor: pointer;
}
#saveLoading{
    background-color:white;
    height:30px;
    cursor: pointer;   
}
#banana{
    flex:0 1 auto;
    height:30px;
}
#proposal{
    white-space:pre-line;
    border:none;
    min-height:110px;
    resize:none;
    overflow-y:scroll;
    outline: none;
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
.fakeContainer{
    display:none;
}
#fakeProposalTitle{
    white-space:pre-line;
    overflow:hidden;
    word-break: break-word;
    font-size:20px;
}
#fakeProposal{
    white-space:pre-line;
    overflow:hidden;
    font-size:16px;
}
.wrap-text {
  width: 100%;
  max-height: 100px;
  overflow: hidden;
}
#expandButton{
    display:none;
    text-decoration:underline;
    font-size:15px;
    cursor:pointer;
}
.chooseButton{
    border:none;
    background:none;
}
#likeButton{
    font-size:40px;
}
#comments{
    font-size: 15px;
    -ms-overflow-style: none;
    scrollbar-width: none;
    padding-bottom:7rem;
}
#comments::-webkit-scrollbar {
        display: none;
}
.previewContainer {
  width: 100%;
  perspective: 600px;
  margin-top: 0.15rem;
  margin-bottom: 0.15rem;
  cursor:pointer;
}

.previewButton {
    width: 100%;
    height:100%;
    position: relative;
    transform-style: preserve-3d;
    transition: transform 1s;
}

.box__face {
    border:1px black solid;
    border-radius:10px;
    backface-visibility: hidden;
    position: absolute;
    font-size: 20px;
    font-weight: bold;
    color: white;
    text-align: center;
}
.box__face--front,
.box__face--back {
  width: 100%;
  height:100%;
}

.box__face--front  { transform: rotateY(0deg)}
.box__face--back   { transform: rotateY(180deg) rotateZ(180deg)}


.previewButton.show-back   { transform: rotateX(0deg); }
.previewButton.show-front    { transform: rotateX( -1260deg); }

@media (min-width: 500px){
    #fakeProposal{
        font-size: 17px;
        min-height:100px;
    }
    #saveButton{
        font-size: 35px;
    }
    #saveLoading, #banana{
        height:35px;
    }
    .previewContainer{
        margin-top: 0;
        margin-bottom: 0;
    }
}
@media (min-width:800px){
    #firstP{
        font-size: 15px;
    }
    #fakeProposal{
        font-size: 18px;
    }
    #fakeProposalTitle{
        font-size:22px;
    }
} 
@media (min-width: 1100px){
    #comments{
        font-size: 16px;
    }
}
#footerContent{
    transition: margin-bottom 1s ease;
}
#expandTutorial{
    cursor:pointer;
    font-size: calc(2rem + .6vw);
    right:0px;
    transform: perspective(1px) translateY(-5%);
}
#expandTutorial:hover, #listButton:hover{
    color:black;
}
.show-answers-button{
    z-index:2;
}
</style>

@endsection
@section('content')

@if($proposal != false)
    <div class="h-100 w-100 pt-2 p-3 rounded">
        <div class="pb-2 d-flex justify-content-between align-content-center border-bottom">
            <div id="saveButtonContainer" style="flex:0 1 auto">
                <div id="saveButton" class=" material-symbols-outlined text-success rounded user-select-none">Save</div>
                <img class="rounded" src="gif/loadingSpin.gif" id="saveLoading"></img>
            </div>
            <div class="previewContainer me-4 ms-4 user-select-none">
                <div class="previewButton">
                    <div class="box__face box__face--front rounded" style="background:hsla( 0, 100%, 50%, 0.7)"><div class="d-flex align-items-center h-100 w-100"><div class="text-center w-100">Scrivi</div></div></div>
                    <div class="box__face box__face--back rounded"  style="color:black;background:hsla(120, 100%, 50%, 0.7);"><div class="d-flex align-items-center h-100 w-100"><div class="text-center w-100">Anteprima</div></div></div>
                </div>
            </div>
            <img id="banana" src="{{ asset('images/banana.png') }}" class="rounded text-danger user-select-none pe-2"></img>
        </div>
        
        <div class="realContainer mt-2">
            <div class="w-100 text-center border-bottom pt-2 pb-1" style="font-size:12px;"> Scrivi il titolo</div>
            <input type="text" id="proposalTitle" class="p-1 text-center w-100 border-top mb-2" style="border: 1px black solid" maxlength="38" placeholder="@quel_lillo" value="@if($proposal != false){{$proposal['proposal_title']}}@endif" style="overflow:scroll"/>
            <div class="w-100 text-center border-bottom pt-2 pb-1" style="font-size:12px;"> Scrivi la tua proposta</div>
            <textarea type="text" id="proposal" class="p-2 w-100 border-top" style="border: 1px black solid" spellcheck="true" placeholder="@quel_lillo">@if($proposal != false){{$proposal['proposal_text']}}@endif</textarea>
        </div>
        <div class="fakeContainer mt-2 mb-3">
                <p class="text-center mt-2 mb-2" id="firstP"> La tua proposta verra vista così: </p>
                <div id="fakeProposalTitle" class="p-1 text-center w-100 bg-black text-white rounded-top" style="min-height:39.5px;"></div>
                <div class="p-2 w-100 bg-white" style="border-right:1px black solid;border-left:1px black solid"><div id="fakeProposal" class="wrap-text" style="word-break:break-word;white-space: pre-line"></div></div>
                <div id="buttonsFakeProposalsContainer" class="w-100 d-flex bg-white rounded-bottom pe-2" style="justify-content:between;border-bottom:1px black solid;border-right:1px black solid;border-left:1px black solid">
                    <div class=' ms-2 text-muted d-flex align-items-center'><div id="expandButton">Espandi</div></div>
                    <div class="d-flex justify-content-end" style="flex: 1 1 auto">
                        <div id="likeButton" class="like-button material-symbols-outlined m-1" style="cursor:pointer;user-select: none;">
                            verified
                        </div>
                    </div>
                </div>
        </div>
    </div>
@else

    <h1 class="mt-3">Non hai proposto niente o non sei rientrato nella top 10, riprova il prossimo mese :)</h1>

@endif

@endsection
@section('extraContent')

@if($proposal != false)
    <div id="comments" class="pt-3 pe-2 ps-2 bg-white border-top" style="flex: 1 1 auto;overflow-y:scroll">
        @if(sizeOf($comments) == 0)
            <h3 class="w-100 text-center pt-2">Nessun commento disponibile</h3>
        @else
            @foreach($comments as $comment)
                <div class="comment-container d-flex flex-column mb-3 ms-2 me-2">
                    <div id="comment{{$comment['id']}}" class="border-end border-start border-top position-relative @if($comment['comment_text'] == 'Commento cancellato') text-muted @endif" style="border-bottom:2px var(--bs-border-style) var(--bs-border-color)!important;">
                        <div class="d-flex ps-3 pe-3 pt-3 pb-1">
                            <div style="flex: 1 1 auto;">
                                <div style="font-size: clamp(15px,2vw,20px);">Uno studente</div>
                            </div>
                        </div>
                        <div class="ps-4 pe-2 pb-4 mb-3" style="font-size: clamp(13px,2vw,18px);" >
                            <div id="textDiv{{$comment['id']}}" class="ms-1 collapseLinesComment" style="white-space:pre-line; word-break:break-word;">{{$comment['comment_text']}}</div>
                        </div>
                        <div class="w-100 position-absolute" style="bottom:0px;">
                            @if($comment->relatedComments()->exists())
                                <div class="w-100 position-absolute d-flex justify-content-center" style="color: rgb(142,142,142);bottom:-11px;font-size: 14px;">
                                    <div id="showAnswers{{$comment['id']}}" class="pe-2 ps-2 show-answers-button user-select-none" style="background-color:white;width:fit-content;cursor:pointer;">Vedi risposte ({{$comment->relatedComments()->count()}})</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-center">
                        <div id ="relCommentsContainer{{$comment['id']}}" class="flex-column border-end border-start" style="width:95%;">
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endif

@endsection
@section('extra')

<div id="deleteModal" class="position-fixed w-100 h-100">
    <div class="w-100 d-flex justify-content-center align-items-center h-100">
        <div id="contentDeleteModal" class="bg-white rounded d-flex flex-column" >
            <div class="text-center p-1 text-muted">Sei sicuro di cancellare?</div>
            <button id="noDeleteModal" class="chooseButton border-top p-1">Annulla</button>
            <button id="yesDeleteModal" class="chooseButton border-top p-1 text-danger">Elimina</button>
        </div>
    </div>
</div>

@endsection
@section('footer')


<div id="footerContent" class="border-top"> 
    <h3 class="text-center p-2 position-relative m-0"  style="color:gray">
        Terza settimana 
        <div id="expandTutorial" class="position-absolute material-symbols-outlined me-2 user-select-none">expand_more</div>
    </h3>

    <div id="tutorialContainer" class="border-top" style="height:300px;">
        <div class="d-flex flex-column h-100 position-relative">
            <div style="flex: 1 1 auto;margin-right: 48px;margin-left: 48px;">
                <div class="swiper" style="font-size:20px;height:100%">
                    <div class="swiper-wrapper">                        
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-3" style="font-size:26px"> Raffina la tua idea implementando le idee degli altri </div>
                                <div class="text-center" style="flex:1 1 auto;">
                                    <img src="{{ asset('images/lightIdea.png') }}" class="mt-3" style="width:90px"></img>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-3" style="font-size:26px"> Nella prossima settimana ci sarà la votazione finale</div>
                                <div class="text-center" style="flex:1 1 auto;">
                                    <img src="{{ asset('images/finalVotesTutorialImage.png') }}" class="mt-3" style="width:120px"></img>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-3" style="font-size:26px"> Colpisci la scritta "scrivi" per vedere l'anteprima </div>
                                <div class="text-center" style="flex:1 1 auto;">
                                    <img src="{{ asset('images/previewContainerTutorialImage.png') }}" class="mt-3" style="width:240px"></img>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-3" style="font-size:26px"> Ricordati di cliccare la banana </div>
                                <div class="text-center" style="flex:1 1 auto;">
                                    <img src="{{ asset('images/banana.png') }}" class="mt-3" style="width:100px"></img>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center">
                                    <img src="{{ asset('images/danger.png') }}" class="mt-3" style="width:80px"></img>
                                </div>
                                <div class="text-center text-danger" style="font-size:26px">IMPORTANTE: </div>
                                <div class="text-center p-2" style="font-size:19px">Segui le <a href="{{route('documentation')}}/#rules" style="color:var(--bs-link-color)">linee guida</a>!! <br>L'anonimato resta tale finché sono rispettate queste <a href="{{route('documentation')}}/#rules"  style="color:var(--bs-link-color)">regole</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="flex: 0 1 auto" class="position-relative">
                <div class="swiper-pagination"></div>
            </div>
            <div class="swiper-button-prev swiper-button-customized"></div>
            <div class="swiper-button-next swiper-button-customized"></div>
        </div>
    </div>
</div>

@endsection
@section('scriptBeforeScreenLoad')

    $("#footerContent").css('margin-bottom', '-' + $("#tutorialContainer").height() + 'px');
    if (navigator.userAgent.match(/(iPod|iPhone|iPad)/i)) {
        $("body").height("89vh");
        $("html").height("89vh");
    }
    
@endsection
@section('script')
        <script>
            var SProposalTitle = $("#proposalTitle").val();
            var SProposal = $("#proposal").val();
            $(window).on('beforeunload', function(){
            if(SProposalTitle != $("#proposalTitle").val().trim() || SProposal != $("#proposal").val().trim())
                return "Sicuro di aver salvato tutto :-| ?";
            });
            $("#banana").click(function(){
                alert('Just a banana')
            })
            $(".previewContainer").click(function(){
                if($('.realContainer').css('display') == 'none'){
                    $('.previewButton').removeClass('show-front');
                    $('.previewButton').addClass('show-back');
                    $('.fakeContainer').hide();
                    $('.realContainer').show();
                }else{
                    $('.previewButton').removeClass('show-back');
                    $('.previewButton').addClass('show-front');
                    $('.realContainer').hide();
                    $('#fakeProposalTitle').text($('#proposalTitle').val());
                    var text = $('#proposal').val();
                    let carriageReturns = text.split(/\r\n|\r|\n/).length;
                    if(carriageReturns >= 5){
                        $("#expandButton").css("display", "block")
                    }else{
                        $("#expandButton").css("display", "none")
                    }
                    $('#fakeProposal').text($('#proposal').val());
                    
                    $('.fakeContainer').show();
                }
            })
            $("#expandButton").click(function(){
                if($(this).text() == "Espandi"){
                    $(this).text("Nascondi");
                    $("#fakeProposal").css('max-height', '2000px');
                }else{
                    $(this).text("Espandi");
                    $("#fakeProposal").css('max-height', '100px');
                }
            });
            $("#comments").on('click', '.show-answers-button', function(e){
                let comment_id = e.target.id.match(/\d+/)[0];
                if($("#" + e.target.id).text() == 'Hide answers'){ 
                    $("#relCommentsContainer" + comment_id).css('display', 'none');
                    $("#" + e.target.id).text('Show answers');
                }else if($("#" + e.target.id).text() == 'Show answers'){
                    $("#relCommentsContainer" + comment_id).css('display', 'block');
                    $("#" + e.target.id).text('Hide answers');
                }else{
                    let url = "{{route('relatedComments', ['comment_id' => 'comment_value'])}}"
                    url = url.replace('comment_value', comment_id)
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
            $('#saveLoading').hide();
            $("#saveButton").click(function(){
                $('#saveButton').hide();
                let url = "{{route('proposal.store')}}"
                let proposalTitle = $('#proposalTitle').val().trim();
                let proposalText = $('#proposal').val().trim();
                $('#saveLoading').show();
                $.ajax({
                method: "POST",
                url: url,
                async: true,
                data: JSON.stringify({
                    'proposal_title' : proposalTitle,
                    'proposal_text' : proposalText,
                }),
                dataType: 'json',
                contentType: 'application/json',
                success: function(response){
                    SProposalTitle = $("#proposalTitle").val();
                    SProposal = $("#proposal").val();
                },
                error: function(response){
                    if(response.responseJSON.errors['proposal_title'] != undefined){
                        $('.proposal-title-error').removeClass('swipe-out');
                        $('.proposal-title-error').addClass('swipe-in');
                        const myTimeout = setTimeout(swipeOut, 5000);
                        function swipeOut() {
                            $('.proposal-title-error').removeClass('swipe-in');
                            $('.proposal-title-error').addClass('swipe-out');
                        }
                    }
                    if(response.responseJSON.errors['proposal_text'] != undefined){
                        $('.proposal-text-error').removeClass('swipe-out');
                        $('.proposal-text-error').addClass('swipe-in');
                        const myTimeout = setTimeout(swipeOut, 5000);
                        function swipeOut() {
                            $('.proposal-text-error').removeClass('swipe-in');
                            $('.proposal-text-error').addClass('swipe-out');
                        }
                    }
                },
                complete: function(response){
                    setTimeout(function(){
                        $('#saveLoading').hide();
                        $('#saveButton').show();
                    }, 500);
                }
                });
            });
        $(".like-button").click(function(){
            if($(this).css('color') == 'rgb(0, 128, 0)'){
                $(this).css('color', 'black')
                $('#numberLikes').text(parseInt($('#numberLikes').text()) - 1)
            }else{
                console.log($(this).css('color'))
                $(this).css('color', 'green')
                $('#numberLikes').text(parseInt($('#numberLikes').text()) + 1)
            }
        });
        $("#expandTutorial").click(function(){
            if($(this).text() == 'expand_more'){
                $(this).text('expand_less')
                $("#footerContent").css('margin-bottom', '0px');
            }else{
                $(this).text('expand_more')
                $("#footerContent").css('margin-bottom', '-' + $("#tutorialContainer").height() + 'px');
            }
        });
        </script>
    
@endsection