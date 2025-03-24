@extends('layout')
@section('title', 'A.S. Berto | Extra days')
@section('style')

<style>
#mainBox{
    background-color: #333333;
    flex: 1 1 auto;
    min-height:0;
}
#proposalsContainer{
    overflow:scroll;
            max-width:500px;
}
#proposalsContainer::-webkit-scrollbar {
    display: none;
}
.wrap-text {
  width: 100%;
  max-height: 100px;
  overflow: hidden;
}
 #main{
    flex:0;
    min-height:0;
    flex-direction:column;
    position:relative;
  }
#popUpContainer{
    display:none;
    margin: 0;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}
#bananasContainer{
    z-index: 1000;
    height: 10vh;
    top:-10vh;
    left:0;
}
.button{
    cursor:pointer;
}
.text-js{
  opacity: 0;
}
.cursor{
  display: block;
  position: absolute;
  height: 100%;
  top: 0;
  right: -5px;
  width: 2px;
  /* Change colour of Cursor Here */
  background-color: white;
  z-index: 1;
  animation: flash 0.5s none infinite alternate;
}
@keyframes flash{
  0%{
    opacity: 1;
  }
  100%{
    opacity: 0;
  }
}
#c1,#c2,#c3{
    position:absolute;
    top:0;
    left:0;
    height:120px;
    width:200px;
    backface-visibility: hidden;
}
.box-front  {
    transform: translate(50%, 50%);
    z-index:10;
}
.box-back-left   {
    transform: translate(0%, 0%);
    z-index:5;
}
.box-back-right   {
    transform: translate(100%, 0%);
    z-index:5;
}
#nextProposal{
    cursor:pointer;
}

</style>

@endsection
@section('extra')
<div id="bananasContainer" class="position-absolute w-100">
    <img id="banana" src="{{ asset('images/banana.png')}}" class="button h-100"></img>
</div>

<div id="mainBox" class="w-100 d-flex justify-content-center">

    <div id="proposalsContainer" class="w-100 h-100 pb-5 pt-4">
        <!--<div class="position-relative w-100" style="height:300px">
            <div id="c1" class="box-front" style="background-color:yellow"></div>
            <div id="c2" class="box-back-left " style="background-color:blue"></div>
            <div id="c3" class="box-back-right " style="background-color:red"></div>

        </div>
        <div id="nextProposal" class="text-white text-center">Next</div>-->
        @foreach($proposals as $proposal)
            <div id="proposalContainer{{$proposal['id']}}" class="proposal-container me-4 ms-4 mb-4 rounded bg-white" style="border:1px black solid">
                <div class="border-bottom text-center p-1 bg-dark text-white proposalTitle" style="word-break:break-word;white-space: pre-line">{{$proposal['proposal_title']}}</div>
                <div class="w-100 position-relative p-2 proposal"><div id="proposal{{$proposal['id']}}" class="wrap-text" style="word-break:break-word;white-space: pre-line">{{$proposal['proposal_text']}}</div></div>
                <div class="under-bar-proposal w-100 d-flex bg-white rounded pe-2 pb-1" style="justify-content: flex-end"></div>
            </div>
        @endforeach

    </div>
</div>

<div id="popUpContainer" class="w-100 text-center text-white bg-black"  style="opacity:0.8">
    <div class="type-js headline">
    <h1 class="text-js">
        LALALA</h1>
    </div>
    <!-- <h1 class="text-js">
        Setting banans on the airplane...
        Turning on the machines...
        Control System checking...
        BANANAS GAME............ ON?</h1>
    </div> -->
</div>

@endsection
@section('scriptAfterScreenLoaded')

    $(".proposal-container").each(function() {
        let proposal = $(this).find(".wrap-text");
        let lengthOfText = proposal.prop("scrollHeight");
        let id = proposal.attr("id").match(/\d+/);
        if(lengthOfText > 100){
            let underBar = $(this).find(".under-bar-proposal")
            underBar.css("justify-content" , "space-between");
            underBar.prepend("<div class='ms-2 text-muted d-flex align-items-center'><div  id='expandButton"+ id +"' class='expand-button' style='text-decoration:underline;font-size:15px;cursor:pointer;'>Espandi</div></div>");
        }
    });

@endsection
@section('script')

<script>
async function autoType(elementClass, typingSpeed){
    return new Promise(resolve => {
        var thhis = $(elementClass);
        thhis.css({
        "position": "relative",
        "display": "inline-block"
        });
        thhis.prepend('<div class="cursor" style="right: initial; left:0;"></div>');
        thhis = thhis.find(".text-js");
        var text = thhis.text().trim().split('');
        var amntOfChars = text.length;
        var newString = "";
        thhis.text("|");
        setTimeout(function(){
        thhis.css("opacity",1);
        thhis.prev().removeAttr("style");
        thhis.text("");
        for(var i = 0; i < amntOfChars; i++){
            (function(i,char){
            setTimeout(function() {        
                newString += char;
                thhis.text(newString);
            },i*typingSpeed);
            })(i+1,text[i]);
        }
        },1500);
        return true;
    })
}
$("#proposalsContainer").on('click', '.expand-button', function(e){
    let id = $(this).attr("id").match(/\d+/);

    if($(this).text() == "Espandi"){
        $(this).text("Nascondi");
        $('#proposal' + id[0]).css('max-height', '2000px');
    }else{
        $(this).text("Espandi");
        $('#proposal' + id[0]).css('max-height', '100px');
    }
});
var isGameActive = false;
$("#fallBananas").click(async function(){
    if(!isGameActive){
        $("#popUpContainer").show();
        let result = await autoType(".type-js", 100);
        result.then(function(){
            $("#popUpContainer").hide();
        })
    }
    isGameActive = true;
})
$("#nextProposal").click(function(){
    let frontProposal = $("#proposalsContainer").find(".box-front")
    let numberId = frontProposal.attr("id").match(/\d+/)[0];

    // FIXARE NUMERO CHE VA OLTRE AL 3

    let leftProposal = $("#proposalsContainer").find("#c" + (+numberId + 1))
    let rightProposal = $("#proposalsContainer").find("#c" + (+numberId + 2))
    frontProposal.removeClass("box-front")
    frontProposal.addClass("box-back-left")
    leftProposal.removeClass("box-back-left")
    leftProposal.addClass("box-back-right")
    rightProposal.removeClass("box-back-right")
    rightProposal.addClass("box-front")
})
</script>

@endsection
