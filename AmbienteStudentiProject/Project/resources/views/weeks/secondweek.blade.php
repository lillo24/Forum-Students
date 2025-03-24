@extends('layout')
@section('title', 'A.S. Berto | 2nd Week')
@section('style')
    <script type="text/javascript" src="{{asset('js/jquery.collapser.js')}}"></script>
<style>
#contentContainer{
    padding-top:1.5rem;
    padding-bottom: 7rem;
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
    color:#707070;
}
a:hover{
    color:black;
}
.wrap-text {
  width: 100%;
  max-height: 100px;
  overflow: hidden;
}
#footerContent{
    transition: margin-bottom 1s ease;
}
#listButton{
    cursor:pointer;
    font-size: calc(2rem + .6vw);
    left:0px;
    transform: perspective(1px) translateY(-7.5%);
}
#listModal{
    display:none;
    background:rgba(0,0,0,0.6);
    top:0px;
    z-index:2;
    color:black;
}
#contentListModal{
    z-index:3;
    margin-bottom:150px;
    width:250px;
    font-size:18px;
}
.pre-ball{
    flex: 0 0 auto;
    height:13px;
    width:13px; 
    background-color: var(--bs-border-color);
    border: 1px #bcbcbc solid;
}
.chooseButton{
    border:none;
    background:none;
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
                    <div id="numberLikes{{$proposal['id']}}"style="margin-top:auto;margin-bottom:auto">{{$proposal['proposal_likes']}}</div>
                    <div id="likeButton{{$proposal['id']}}" class="like-button material-symbols-outlined mt-auto m-1 user-select-none" 
                    style="@if($proposal->userLiked()) color:red @else color:black @endif">
                        favorite
                    </div>
                    <a href="{{route('showComments', ['id'=> $proposal['id']])}}" id="commentButton{{$proposal['id']}}" class="comment-button material-symbols-outlined bg-white ms-0 m-1 user-select-none">
                        chat_bubble
                    </a>
                </div>
            </div>
        </div>
    @endforeach

@endsection
@section('extra')

<div id="listModal" class="position-fixed w-100 h-100">
    <div class="w-100 d-flex justify-content-center align-items-center h-100">
        <div id="contentListModal" class="bg-white rounded d-flex flex-column" >
            <div class="text-center p-1 text-muted">Ordina le proposte per:</div>
            <div class="d-flex border-top">@if(Session::get('mode') == 'random') <div class="pre-ball mt-auto mb-auto ms-2 rounded"></div> @endif<button id="randomListModal" class="chooseButton p-1" style="flex:1 1 auto"><span>R</span><span>a</span><span>n</span><span>d</span><span>o</span><span>m</span></button></div>
            <div class="d-flex border-top">@if(Session::get('mode') == 'likes') <div class="pre-ball mt-auto mb-auto ms-2 rounded"></div> @endif<button id="likesListModal" class="chooseButton p-1" style="flex:1 1 auto">Più <span class="text-danger">likes</span></button></div>
        </div>
    </div>
</div>

@endsection
@section('footer')

<div id="footerContent" class="border-top"> 
    <h3 class="text-center p-2 position-relative m-0"  style="color:gray">
        <div id="listButton" class="position-absolute material-symbols-outlined ms-2 user-select-none">list</div>
        Seconda settimana 
        <div id="expandTutorial" class="position-absolute material-symbols-outlined me-2 user-select-none">expand_more</div>
    </h3>

    <div id="tutorialContainer" class="border-top" style="height:300px;">
        <div class="d-flex flex-column h-100 position-relative">
            <div style="flex: 1 1 auto;margin-right: 48px;margin-left: 48px;">
                <div class="swiper" style="font-size:20px;height:100%">
                    <div class="swiper-wrapper">                        
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-3" style="font-size:26px">Metti mi piace alle proposte </div>
                                <div class="text-center mt-1" style="font-size:20px"> Le top 10 passeranno allo step successivo </div>
                                <div class="text-center" style="flex:1 1 auto;">
                                    <img src="{{ asset('images/heart.png') }}" class="mt-3" style="width:90px"></img>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-3" style="font-size:26px">Commenta costruttivamente </div>
                                <div class="text-center mt-1" style="font-size:20px"> Migliora le proposte degli altri </div>
                                <div class="text-center" style="flex:1 1 auto;">
                                    <img src="{{ asset('images/commentSection.png') }}" class="mt-3" style="width:80px"></img>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-3" style="font-size:26px">Ordina le proposte nelle due modalità </div>
                                <div class="text-center">
                                <img src="{{ asset('images/listTutorialImage.png') }}" class="mt-3" style="width:180px"></img>
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
                    $(This).css('color', 'red')
                    $('#numberLikes' + id[0]).text(parseInt($('#numberLikes' + id[0]).text()) + 1)
                }else if(response == 'destroyed'){
                    $(This).css('color', 'rgb(33, 37, 41)')
                    $('#numberLikes' + id[0]).text(parseInt($('#numberLikes' + id[0]).text()) - 1)    
                }
            }
            });
        });
        let spans = $('#randomListModal').children();
        $("#listButton").click(function(){
            var back = ["blue","red", "purple", "green", "orange"];
            var rand = "";
            spans.each(function(e){
                rand = back[Math.floor(Math.random() * back.length)];
                $(spans[e]).css('color')
                $(spans[e]).css('color', rand)
            })
            $('#listModal').css('display', 'block');
        });
        $("#listModal").click(function(){
            $('#listModal').css('display', 'none');
        });
        $("#randomListModal").click(function(){
            let url = "{{route('set.session')}}"
            $.ajax({
                method: "POST",
                url: url,
                async: true,
                data: JSON.stringify({
                    'mode': 'random',
                }),
                dataType: 'json',
                contentType: 'application/json',
                complete: function(response){
                },
            });
            setTimeout(function(){
                window.location.reload();
            },500);
        });
        $("#likesListModal").click(function(){
            let url = "{{route('set.session')}}"
            $.ajax({
                method: "POST",
                url: url,
                async: true,
                data: JSON.stringify({
                    'mode': 'likes',
                }),
                dataType: 'json',
                contentType: 'application/json',
                complete: function(response){
                },
            });
            setTimeout(function(){
                window.location.reload();
            },500);
           //window.location = "{{route('main')}}";
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