@extends('layout')
@section('title', 'A.S. Berto | 1st Week')
@section('style')

<style>
#contentContainer{
    height:100%;
    padding: 1.2rem;
    background-color:white;
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
#deleteButton{
    padding-top:1px;
    padding-bottom:1px;
    padding-right:10px;
    background-color:white;
    font-size: 30px;
    cursor: pointer;    
}
#proposal{
    white-space:pre-line;
    border:none;
    min-height:300px;
    resize:none;
    overflow:scroll;
    outline: none;
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
@media (min-width: 500px){
    #fakeProposal{
        font-size: 17px;
    }
    #deleteButton, #saveButton{
        font-size: 35px;
    }
    #saveLoading{
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
.error-message{
    opacity:0;
    transition: all 1s ease;
}
#proposal-title-error{
}
#proposal-text-error{
}
.appear{
    opacity:1;
}
.disappear{
    opacity:0;
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
#savedPop{
    opacity:0;
    top:-25px;
    left:0px;
    background-color: #555;
    color: #fff;
    text-align:center;
    border-radius: 6px;
    transition: all 0.5s;
}
#savedPop::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}
#noCommentSectionPop{
    opacity:0;
    top:-25px;
    right:0px;
    background-color: #555;
    color: #fff;
    text-align:center;
    border-radius: 6px;
    transition: all 0.5s;
}
</style>

@endsection
@section('content')

    <div class="h-100 w-100 pt-2 p-3 rounded">
        <div class="pb-2 d-flex justify-content-between align-content-center border-bottom">
            <div id="saveButtonContainer" class="position-relative" style="flex:0 1 auto">
                <div id="saveButton" class=" material-symbols-outlined text-success rounded user-select-none">Save</div>
                <img class="rounded" src="{{ asset('gif/loadingSpin.gif') }}" id="saveLoading"></img>
                <div id="savedPop" class="position-absolute pe-1 ps-1">Salvato!</div>
            </div>
            <div class="previewContainer me-4 ms-4 user-select-none">
                <div class="previewButton">
                    <div class="box__face box__face--front rounded" style="background:hsla( 0, 100%, 50%, 0.7)"><div class="d-flex align-items-center h-100 w-100"><div class="text-center w-100">Scrivi</div></div></div>
                    <div class="box__face box__face--back rounded"  style="color:black;background:hsla(120, 100%, 50%, 0.7);"><div class="d-flex align-items-center h-100 w-100"><div class="text-center w-100">Anteprima</div></div></div>
                </div>
            </div>
            <div id="deleteButton" class="rounded material-symbols-outlined text-danger user-select-none"  style="flex:0 1 auto">Delete </div>
        </div>
        
        <div class="realContainer mt-2">
            <div class="w-100 text-center border-bottom pt-2 pb-1 rounded" style="font-size:12px"> Scrivi il titolo</div>
            <input type="text" id="proposalTitle" class="p-1 text-center w-100 border-top mb-2" style="border: 1px black solid" maxlength="38" placeholder="Scrivi il titolo della tua proposta" value="@if($proposal != false){{$proposal['proposal_title']}}@endif" style="overflow:scroll"/>
            <div class="w-100 text-center border-bottom pt-2 pb-1" style="font-size:12px;"> Scrivi la tua proposta</div>
            <textarea type="text" id="proposal" class="p-2 w-100 border-top" style="border: 1px black solid" spellcheck="true" placeholder="Banane per merenda...">@if($proposal != false){{$proposal['proposal_text']}}@endif</textarea>
        </div>
        <div class="fakeContainer mt-2 mb-3">
                <p class="text-center mt-2 mb-2" id="firstP"> La tua proposta verra vista così: </p>
                <div id="fakeProposalTitle" class="p-1 text-center w-100 bg-black text-white rounded-top" style="min-height:39.5px;"></div>
                <div class="p-2 w-100 bg-white" style="border-right:1px black solid;border-left:1px black solid"><div id="fakeProposal" class="wrap-text" style="word-break:break-word;white-space: pre-line"></div></div>
                <div id="buttonsFakeProposalsContainer" class="w-100 d-flex bg-white rounded-bottom pe-2" style="justify-content:between;border-bottom:1px black solid;border-right:1px black solid;border-left:1px black solid">
                    <div class=' ms-2 text-muted d-flex align-items-center'><div id="expandButton">Espandi</div></div>
                    <div class="d-flex justify-content-end position-relative" style="flex: 1 1 auto">
                        <div id="numberLikes" style="margin-top:auto;margin-bottom:auto">23</div>
                        <div id="likeButton" class="like-button material-symbols-outlined m-1" style="cursor:pointer;user-select: none;">
                            favorite
                        </div>
                        <div id="commentButton" class="comment-button material-symbols-outlined ms-0 m-1 bg-white" style="cursor:pointer;user-select: none;">
                            chat_bubble
                        </div>
                        <div id="noCommentSectionPop" class="position-absolute pe-1 ps-1">É un'anteprima!</div>
                    </div>
                </div>
        </div>
        <div class="w-100 mt-2">
            <div id="proposal-title-error" class="error-message p-2 text-center rounded text-white"  style="width:100%; background-color:#f4305e;">Senza titolo nada</div>
            <div id="proposal-text-error" class="proposal-text-error error-message p-2 mt-2 text-center rounded text-white"  style="width:100%; background-color:#f4305e">Titolo o no, senza proposta io dico no (Lo so non è una rima, ma suona bene)</div>
        </div>
    </div>

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
        Prima settimana
        <div id="expandTutorial" class="position-absolute material-symbols-outlined me-2 user-select-none">expand_more</div>
    </h3>

    <div id="tutorialContainer" class="border-top" style="height:300px;">
        <div class="d-flex flex-column h-100 position-relative">
            <div style="flex: 1 1 auto;margin-right: 48px;margin-left: 48px;">
                <div class="swiper" style="font-size:20px;height:100%">
                    <div class="swiper-wrapper">                        
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-4" style="flex:0 1 auto;font-size:27px">Scrivi e rielabora <br>la tua idea: </div>
                                <div class="text-center" style="flex:1 1 auto;">
                                    <img src="{{ asset('images/lightIdea.png') }}" class="mt-3" style="width:90px"></img>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-4" style="font-size:26px">Dagli un titolo accattivante</div>
                                <div class="text-center" style="font-size:22px"> (perchè verra votata!)</div>
                                <div class="text-center" style="flex:1 1 auto;">
                                    <img src="{{ asset('images/ranking.png') }}" class="mt-3" style="width:80px"></img>
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
                                    <div class="text-center mt-4" style="font-size:26px"> Puoi rifinirla fino all'ultimo giorno della settimana :) </div>
                                    <div class="d-flex justify-content-center align-items-center mb-5" style="flex: 1 1 auto">
                                        <img src="{{ asset('images/timeCal.png') }}" class="mt-3" style="width:80px"></img>
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
            $('#saveLoading').hide();
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
                    $('#fakeProposal').text($('#proposal').val());
                    $('.fakeContainer').show();
                    if($('#fakeProposal').prop("scrollHeight") > 100){
                        $("#expandButton").css("display", "block")
                    }else{
                        $("#expandButton").css("display", "none")
                    }
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
            $("#commentButton").click(function(){
                $("#noCommentSectionPop").css("opacity", 1);
                setTimeout(function(){
                    $("#noCommentSectionPop").css("opacity", 0);
                },2000);
            });
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
                    setTimeout(function(){
                        $("#savedPop").css("opacity", 1);
                        setTimeout(function(){
                            $("#savedPop").css("opacity", 0);
                        },2000);
                    }, 2000);
                },
                error: function(response){
                    if(response.responseJSON.errors['proposal_title'] != undefined){
                        let titleError = $('#proposal-title-error');
                        titleError.removeClass('disappear');
                        titleError.addClass('appear');
                        const myTimeout = setTimeout(swipeOut, 5000);
                        function swipeOut() {
                            titleError.removeClass('appear');
                            titleError.addClass('disappear');
                        }
                    }
                    if(response.responseJSON.errors['proposal_text'] != undefined){
                        console.log('ciao')
                        let textError = $('#proposal-text-error');
                        textError.removeClass('disappear');
                        textError.addClass('appear');
                        const myTimeout = setTimeout(swipeOut, 5000);
                        function swipeOut() {
                            textError.removeClass('appear');
                            textError.addClass('disappear');
                        }
                    }
                },
                complete: function(response){
                    setTimeout(function(){
                        $('#saveLoading').hide();
                        $('#saveButton').show();
                    }, 2000);
                }
                });
            });
        $("#deleteButton").click(function(){
            $('#deleteModal').css('display', 'block');
        });
        $("#deleteModal").click(function(){
            $('#deleteModal').css('display', 'none');
        });
        $("#yesDeleteModal").click(function(){
            let url = "{{route('proposal.delete.mine')}}"
            $.ajax({
            method: "DELETE",
            url: url,
            async: true,
            error: function(response){
                alert('Errore nella cancellazione');
            },
            success: function(response){
                $('#proposalTitle').val('');
                $('#proposal').val('');
                SProposalTitle = "";
                SProposal = "";
            }
            });
        });
        $(".like-button").click(function(){
            if($(this).css('color') == 'rgb(255, 0, 0)'){
                $(this).css('color', 'black')
                $('#numberLikes').text(parseInt($('#numberLikes').text()) - 1)
            }else{
                $(this).css('color', 'red')
                $('#numberLikes').text(parseInt($('#numberLikes').text()) + 1)
            }
        });
        $("#expandTutorial").click(function(){
            $("#headerContainer").focus()
            if($(this).text() == 'expand_more'){
                $(this).text('expand_less')
                $("#footerContent").css('margin-bottom', '0px');
            }else{
                $(this).text('expand_more')
                $("#footerContent").css('margin-bottom', '-' + $("#tutorialContainer").height() + 'px');
            }
        });
        $("#commentText").focusout(function () {
            $("#headerContainer").focus()
        });
        </script>
@endsection