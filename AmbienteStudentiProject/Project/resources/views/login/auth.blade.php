<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/berto-icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>A.S. Berto</title>
    <style>
        html, body, #screen{
            width:100vw;
            height:100vh;
        }
        #screen{
            overflow:hidden;
        }
        #loading {
            position: fixed;
            display: none;
            flex-direction:column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            z-index: 1032;
        }
        #loading-image {
            width:200px;
            height:fit-content;
            z-index: 1032;
        }
        #pulsingButton{
            position:absolute;
            z-index:1030;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width:115px;
            aspect-ratio:1;
            transition: all 2s;
            background-color:rgba(255,7,1);
            box-shadow: 0 0 0 0 rgba(159,159,159, 0.5), 0 0 30px 10px rgba(100,100,100, 1);
        }
        .pulsing{
            animation: 
                example 2s linear 0s infinite,
                pulse 2s linear 2s infinite
            ;
        }
        #bertoImage{
            transition: all 3s;
        }
        .drown{
            margin-top:20px;
            opacity:0;
        }
        @keyframes example {
            0% {
                width:115px;
            }
            96%{
                width:170px;
            }
            100% {                
                width:115px;
            }
        }
        @keyframes pulse{
            0% {
            }
            70%{
                box-shadow: 0 0 50px 350px  rgba(159,159,159, 0);
            }
            100% {                
                box-shadow: 0 0 0 0 rgba(159,159,159, 0);
            }
        }
        #scriptContainer{
            display:none;
            opacity:0;
        }
        .fade-in{
            display:flex !important;
            animation: fade-in 3s forwards;
        }
        @keyframes fade-in {
            0% {
                margin-top:20px;
                opacity: 0;
            }
            100% {
                margin-top:0px;
                opacity: 1;
            }
        }
        </style>
  </head>
  <body style="background-color:#fafafa">
        <div id="loading" class="bg-black">
            <div style="flex: 1 1 auto" class="d-flex align-items-center"><img id="loading-image" src="{{ asset('images/nameReverseColor-image.png') }}" alt="Loading..."/></div>
            <div style="height:50px;" class="mb-5 text-white">Made by <br><div  class="text-center"style="font-size:20px;text-decoration:underline">Lillo</div></div>
        </div>
        <div id="screen" class="position-relative d-flex justify-content-center align-items-center">
                    
            <div id="pulsingButton" class="pulsing rounded-circle d-flex justify-content-center align-items-center user-select-none" style="cursor:pointer;">
                <img id="bertoImage" src="{{ asset('images/homeButton.png') }}" alt="Liceo Berto" style="width:100%;max-width:40vh"></img>
                <div id="scriptContainer" class="align-items-center justify-content-center flex-column" style="width:100vw; height:100vh;">
                    <div class="pe-4 ps-4 text-center text-white" style="font-size:25px;"> <div>Benvenuto in A.S. Berto</div> <div style="font-size:18px;"> Clicca in una qualsiasi parte dello schermo per accedere</div></div>
                </div>
            </div>
        </div>
        <script>
            $(window).on('load', function () {
                @if(session('error') !== null)
                    alert('devi essere uno studente per accedere') 
                @endif
            }) 
            $("#pulsingButton").click(function(){
                let height = $("html").height();
                let width = $("html").width();
                $('#pulsingButton').removeClass("pulsing")
                if($("html").height()>=$("html").width()){
                    let r = Math.sqrt(Math.pow(height,2) + Math.pow(height,2)) + "px";
                    $('#pulsingButton').css("width", r)
                }else{
                    let r = Math.sqrt(Math.pow(width,2) + Math.pow(width,2)) + "px";
                    $('#pulsingButton').css("width", r)
                }
                $(this).css("background-color", "#ff5656");
                $('#bertoImage').addClass("drown")
                setTimeout(function() {
                    $("#bertoImage").hide();
                    $("#scriptContainer").addClass("fade-in");
                    $("#scriptContainer").css("opacity", 1);
                }, 4000);
                $('#pulsingButton').on("click", function() {
                    window.location.href = "{{route('google.login')}}";
                });
            })
            window.onbeforeunload = function () { 
                $('#loading').css("display", "flex");
            }
        </script>
</body>
</html>