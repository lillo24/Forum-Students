@extends('layout')
@section('title', 'A.S. Berto | 4th Week')
@section('style')
<script type="text/javascript" src="{{asset('js/jquery.collapser.js')}}"></script>
<style>
#contentContainer{
    padding-top:1.5rem;
    padding-bottom:7rem;
    overflow:scroll;
}
.comment-button{
    text-decoration: none;
    color:rgb(33, 37, 41);
}
.proposalTitle{
    font-size:20px;
}
.proposal{
    font-size:16px;
}
@media (min-width:500px){
    .proposal{
        font-size: 17px;
    }
}
@media (min-width:800px){
    .proposal{
        font-size: 18px;
    }
    .proposalTitle{
        font-size:22px;
    }
}
a{
    text-decoration-color:#dee2e6 ;
    color:#707070;;
}
a:hover{
    color:black;
}
.wrap-text {
  width: 100%;
  max-height: 100px;
  overflow: hidden;
}
.expand-button{
    z-index:10;
    curor:pointer;
}
.like-button{
    font-size: 40px;
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
</style>

@endsection
@section('content')
    @foreach($proposals as $proposal)
        <div id="proposalContainer{{$proposal['id']}}" class="proposal-container me-4 ms-4 mb-4 rounded bg-white" style="border:1px black solid">
            <div class="border-bottom text-center p-1 bg-dark text-white proposalTitle rounded-top" style="word-break:break-word;white-space: pre-line">{{$proposal['proposal_title']}}</div>
            <div class="w-100 position-relative pb-0 p-2 proposal"><div id="proposal{{$proposal['id']}}" class="wrap-text" style="word-break:break-word;white-space: pre-line">{{$proposal['proposal_text']}}</div></div>
            <div class="under-bar-proposal w-100 d-flex bg-white rounded pe-2" style="justify-content: flex-end">
                <div class="d-flex">
                    <!-- <div id="numberLikes{{$proposal['id']}}"style="margin-top:auto;margin-bottom:auto">{{$proposal['proposal_likes']}}</div> -->
                    <div id="likeButton{{$proposal['id']}}" class="like-button material-symbols-outlined w-100 text-center rounded pt-1 pb-1" 
                    style="@if($proposal->userLiked()) color:green @else color:black @endif ;user-select: none;margin-top:auto; margin-left:-59px">
                        verified
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('footer')

<div id="footerContent" class="border-top"> 
    <h3 class="text-center p-2 position-relative m-0"  style="color:gray">
        Quarta e ultima settimana
        <div id="expandTutorial" class="position-absolute material-symbols-outlined me-2 user-select-none">expand_more</div>
    </h3>

    <div id="tutorialContainer" class="border-top" style="height:300px;">
        <div class="d-flex flex-column h-100 position-relative">
            <div style="flex: 1 1 auto;margin-right: 48px;margin-left: 48px;">
                <div class="swiper" style="font-size:20px;height:100%">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-4" style="flex:0 1 auto;font-size:26px"> Dai il voto finale alle proposte</div>
                                <div class="text-center" style="font-size:20px"> (Solo 3 vinceranno)</div>
                                <div class="text-center" style="flex:1 1 auto;">
                                    <img src="{{ asset('images/voteTutorialImage.png') }}" class="mt-3" style="width:100px"></img>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class= "d-flex flex-column h-100">
                                    <div class="text-center mt-4" style="font-size:23px"> Indipendentemente dalla popolarità è necessario un minimo di voti</div>                                    
                                    <div class="text-center" style="flex:1 1 auto;">
                                        <img src="{{ asset('images/cakeGraphic.png') }}" class="mt-3" style="width:150px"></img>
                                    </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-4" style="font-size:23px">Se vincenti, saranno presentate alla scuola in assemblea di istituto</div>
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
    
@endsection
@section('scriptAfterScreenLoaded')

    $(".proposal-container").each(function() {
        let proposal = $(this).find(".wrap-text");
        let lengthOfText = proposal.prop("scrollHeight");
        let id = proposal.attr("id").match(/\d+/);
        if(lengthOfText > 100){
            let underBar = $(this).find(".under-bar-proposal")
            console.log(underBar.css("justify-content"));
            underBar.css("justify-content" , "space-between");
            underBar.prepend("<div class='ms-2 text-muted d-flex align-items-center'><div  id='expandButton"+ id +"' class='expand-button' style='text-decoration:underline;font-size:15px;cursor:pointer;'>Espandi</div></div>");
        }
    });

@endsection
@section('script')

    <script>
        $("#contentContainer").on('click', '.expand-button', function(e){
            let id = $(this).attr("id").match(/\d+/);

            if($(this).text() == "Espandi"){
                $(this).text("Nascondi");
                $('#proposal' + id[0]).css('max-height', '2000px');
            }else{
                $(this).text("Espandi");
                $('#proposal' + id[0]).css('max-height', '100px');
            }
        });
        $(".like-button").click(function(){
            let This = this;
            let id = $(this).attr("id").match(/\d+/);
            let url = "{{route('like', ['id' => 'proposal_value', 'type' => 'type_value'])}}"
            url = url.replace('proposal_value', id[0])
            url = url.replace('type_value', 'proposal')
            $.ajax({
                method: "GET",
                url: url,
                async: true,
                error: function(){
                    alert('couldn\'t load');
                },
                success: function(response){
                    if(response == 'saved'){
                        $(This).css('color', 'green')
                    }else if(response == 'destroyed'){
                        $(This).css('color', 'black') 
                    }
                }
            });
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