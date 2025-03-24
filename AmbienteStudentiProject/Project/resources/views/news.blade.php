@extends('layout')
@section('title', 'Notizie')
@section('style')

<style>
#allNewsContainer{
    overflow:scroll;
    -ms-overflow-style: none;
    scrollbar-width: none;
    padding-bottom: 7rem;
}
#allNewsContainer::-webkit-scrollbar {
    display: none;
}
@media screen and (max-width: 500px) {
    #allNewsContainer {
        border:none;
    }
}
#contentContainer{
    height:100%;
    border-right:var(--bs-border-width) var(--bs-border-style) var(--bs-border-color);
    border-left:var(--bs-border-width) var(--bs-border-style) var(--bs-border-color);
}
#footerContent{
    transition: margin-bottom 1s ease;
}
#addNews{
    cursor:pointer;
    font-size: calc(2rem + .6vw);
    left:0px;
    transform: perspective(1px) translateY(-7.5%);
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
#addNewsModal{
    display:none;
    background:rgba(0,0,0,0.6);
    top:0px;
    z-index:10;
    color:black;
}
#contentAddNewsModal{
    position:relative;
    z-index:16;
    font-size:18px;
    overflow:scroll;
}
.chooseButton{
    border:none;
    background:none;
}
.delete-button{
    top:8px;
    right:.5rem;
}
#deleteModal{
    display:none;
    background:rgba(0,0,0,0.6);
    top:0px;
    z-index:10;
    color:black;
}
#contentDeleteModal{
    z-index:15;
    margin-bottom:150px;
    width:80%;
    max-width:650px;
    font-size:18px;
}
#resizeImageContainer{
}
input[type="file"] {
    display: none;
}
.custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 3px 12px;
    cursor: pointer;
}
#canvas, #cancelUpload{
    display:none;
}
#cancelUpload{
    top:5px;
    right:5px;
    cursor:pointer;
}
</style>

@endsection
@section('content')

<div id="allNewsContainer" class="h-100 pt-3">
    @if(sizeOf($news))
        @foreach($news as $new)
            <div class="border-top border-bottom mb-4 d-flex flex-column align-items-center w-100 newsContainer bg-white" id="news{{$new['id']}}">
                <div class="w-100 p-1 border-bottom position-relative">
                    <div class="w-100 text-center wrap-text" style="word-break:break-word;white-space: pre-line;font-size:20px;">{{$new['news_title']}}</div>
                    @if($user['student_level'] == 5 Or $user['student_level'] == 4 Or $user['student_level'] == 3) 
                        <div class="position-absolute delete-button text-danger material-symbols-outlined button user-select-none" style="font-size:23px;">cancel</div> 
                    @endif
                </div>
                <div class="ps-2 p-1 w-100 wrap-text" style="word-break:break-word;white-space: pre-line;">{{$new['news_description']}}</div>
                <div class>
                    @foreach($new->newsImages() as $newsImage) 
                        <img src="{{$newsImage['file_path']}}"/>
                    @endforeach</div>
            </div>
        @endforeach
    @else
        <div class="text-center p-2">Ancora nessuna notizia :)</div>
    @endif
</div>


@endsection
@section('extra')

<div id="addNewsModal" class="position-fixed w-100 h-100">
    <div class="w-100 h-100 d-flex justify-content-center">
        <div class="mt-5" style="width:80%;h-100;max-width:650px;margin-bottom:6rem;overflow:scroll;">
            <div id="contentAddNewsModal" class="w-100 bg-white rounded d-flex flex-column justify-content-center pt-2 pb-2 p-3">
                <div class="text-center p-1 text-muted border-bottom">Aggiungi una notizia</div>
                <div class="w-100 text-center pt-2 pb-1 rounded" style="font-size:12px"> Scrivi il titolo</div>
                <input id="newsTitle" class="ps-2 pt-1 pb-1 mb-2 rounded w-100" placeholder="Pizze scontateee!!" style="font-size:15px;"/>
                <div class="w-100 text-center pt-2 pb-1 rounded" style="font-size:12px"> Scrivi la descrizione</div>
                <textarea id="newsDescription" class="ps-2 pt-2 w-100"placeholder="Pizzette scontate del 2%" style="font-size:13px;min-height:100px;resize:none;"></textarea>
                <div class="d-flex justify-content-center">
                    <label for="addImage" class="custom-file-upload text-center mb-2 rounded user-select-none" style="margin-top: 0.75rem">
                        Clicca per inserire una foto
                    </label>
                    <input id="addImage" class="w-100" type="file"/>
                </div>
                <div id="resizeImageContainer" class="d-flex justify-content-center mb-1 position-relative">
                    <div id="cancelUpload" class="bg-white text-danger position-absolute rounded border pe-2 ps-2">Elimina</div>
                    <canvas id="canvas" style="width:100%;aspect-ratio : 1 / 1;"></canvas>
                </div>
                <button id="undoAddNewsButton" class="chooseButton p-1">Annulla</button>
                <button id="addNewsButton" class="chooseButton border-top p-1">Aggiungi</button>
            </div>
            <div id="closeAddNewsModal" class="position-absolute w-100 h-100" style="cursor:pointer;z-index:15;top:0px;left:0px;"></div>
        </div>
    </div>
</div>

<div id="deleteModal" class="position-fixed w-100 h-100">
    <div class="w-100 d-flex justify-content-center align-items-center h-100 position-relative">
        <div id="closeDeleteModal" class="position-absolute w-100 h-100"></div>
        <div id="contentDeleteModal" class="bg-white rounded d-flex flex-column justify-content-center pt-2 pb-2 p-3">
            <button id="undoDeleteButton" class="chooseButton p-1">Annulla</button>
            <button id="deleteButton" class="chooseButton border-top p-1 text-danger" value="">Elimina</button>
        </div>
    </div>
</div>

@endsection
@section('footer')

<div id="footerContent" class="border-top"> 
    <h3 class="text-center p-2 position-relative m-0"  style="color:gray">
        @if($user['student_level'] == 5 Or $user['student_level'] == 4 Or $user['student_level'] == 3) 
            <div id="addNews" class="position-absolute material-symbols-outlined ms-2 user-select-none">add</div>
        @endif
        Pagine notizie
        <div id="expandTutorial" class="position-absolute material-symbols-outlined me-2 user-select-none">expand_more</div>
    </h3>

    <div id="tutorialContainer" class="border-top" style="height:300px;">
        <div class="d-flex flex-column h-100 position-relative">
            <div style="flex: 1 1 auto;margin-right: 48px;margin-left: 48px;">
                <div class="swiper" style="font-size:20px;height:100%">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-4" style="flex:0 1 auto;font-size:26px"> Guarda le ultime notizie sul Liceo Berto</div>
                                <div class="text-center" style="flex:1 1 auto;">
                                    <img src="{{ asset('images/newsTutorialImage.png') }}"  style="width:150px"></img>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="d-flex flex-column h-100">
                                <div class="text-center mt-4" style="font-size:23px">Nient'altro, ma volevo fare due slide</div>
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
@section('script')
<script>
    $("#expandTutorial").click(function(){
        if($(this).text() == 'expand_more'){
            $(this).text('expand_less')
            $("#footerContent").css('margin-bottom', '0px');
        }else{
            $(this).text('expand_more')
            $("#footerContent").css('margin-bottom', '-' + $("#tutorialContainer").height() + 'px');
        }
    });
    $("#addNews").click(function(){
        $('#addNewsModal').css('display', 'block');
      });
    $('#closeAddNewsModal, #undoAddNewsButton').on('click', function(){
        $('#addNewsModal').css('display', 'none');
    });
    $("#addImage").change(function(e){
        var file = e.target.files[0];
        if(file.type.match(/image.*/)) {
            console.log('An image has been loaded');

            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            var img = new Image();
            img.src = URL.createObjectURL(file);
            img.onload = function() {
                var sWidth = img.naturalWidth;
                var sHeight = img.naturalHeight;
                if (sWidth > sHeight) {
                    sx = (sWidth - sHeight)/2;
                    sy = 0;
                    sWidth = sHeight;
                }else if(sWidth < sHeight){
                    sy = (sHeight - sWidth)/2;
                    sx = 0;
                    sHeight = sWidth;
                }else if(sWidth == sHeight){
                    sy = 0;
                    sx = 0;
                }
                ctx.drawImage(img, sx, sy, sWidth, sHeight, 0, 0, canvas.width, canvas.height);
            };
            $("#canvas").show();
            $("#cancelUpload").show();
        }
    })
    $("#cancelUpload").click(function(){
        $("#canvas").hide();
        $("#cancelUpload").hide();
        var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext("2d");
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });
    $("#addNewsButton").click(function(){
        let newsTitle = $("#newsTitle").val();
        let newsDescription = $("#newsDescription").val();
        let url = "{{route('news.store')}}";
        var dataurl = "";
        if($("#canvas").css('display') != "none"){
            dataurl = document.getElementById("canvas").toDataURL();
        }
        $.ajax({
            method: "POST",
            url: url,
            async: true,
            data: {
                'news_title' : newsTitle,
                'news_description' : newsDescription,
                'image' : dataurl,
            },
            success: function(response){
                location.reload();
            },
            complete: function(response){
                $('#addNewsModal').css('display', 'none');
                location.reload();
            }
        });
    });
    $(".delete-button").click(function(){
        $('#deleteModal').css('display', 'block');
        let id = $(this).closest(".newsContainer").attr('id');
        $('#deleteButton').attr('value', id);
    });
    $('#closeDeleteModal, #undoDeleteButton').on('click', function(){
        $('#deleteModal').css('display', 'none');
        $('#deleteButton').attr('value', "");
    });
    $("#deleteButton").click(function(){
        let id = $(this).attr("value").match(/\d+/)[0];
        let url = "{{route('news.delete', 'id_value')}}";
        url = url.replace('id_value', id)
        $.ajax({
        method: "DELETE",
        url: url,
        async: true,
        error: function(response){
            alert('Errore nel reporting');
        },
        success: function(response){
            $("#allNewsContainer").find("#news" + id).remove();
        }
        });
        $('#deleteModal').css('display', 'none');
        $('#deleteButton').attr('value', "");
    })
</script>

@endsection