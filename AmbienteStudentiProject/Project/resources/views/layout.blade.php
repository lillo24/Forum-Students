<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="icon" href="{{ asset('images/berto-icon.png') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery.collapser.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <title>@yield('title')</title>
    @yield('head')
    <style>
      #screen{
        display:none;
      }
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
      body{
        background-color:rgb(250,250,250);
      }
      #main{
        flex:1 1 auto;
        min-height:0;
        flex-direction:column;
        position:relative;
      }
      .content-container{
        max-width:500px;
        padding:0;
      }
      .content-container::-webkit-scrollbar {
        display: none;
      }
      .header{
        max-width: calc(945px);
        width:100%;
        padding-right:15px;
        padding-left:15px;
      }
      #footer{
        position:absolute; 
        bottom:0px;
        z-index:100;
      }
      .popup{
        transition: opacity 1.5s linear;
      }
      .popup::before {
          content: "";
          position: absolute;
          top: -25%;
          transform: rotate(180deg);
          left: 70%;
          border: 5px;
          border-style: solid;
          border-color: rgb(255, 47, 64) transparent transparent transparent;
      }
      #containerNotifications{
        display:none;
      }
      #reportModal{
          display:block;
          background:rgba(0,0,0,0.6);
          top:0px;
          z-index:10;
          color:black;
      }
      #contentReportModal{
          z-index:15;
          margin-bottom:150px;
          width:80%;
          max-width:650px;
          font-size:18px;
      }
      .swiper-pagination-bullet {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 10px;
        background: #999;
        box-shadow: 0px 1px 2px #555 inset;
        margin: 0 3px;
        cursor: auto;
      }
      .swiper-button-customized{
        color:black;    
      }
      @media (orientation:landscape) {
        #tutorialContainer{
          height: 200px;
        }
      }
      #mainTutorial{
        display:flex;
        background:rgba(0,0,0,0.6);
        top:0px;
        z-index:101;
        color:black;
      }
      #infoContainer{
        max-width:80%;
      }
    </style>
    @yield('style')
  </head>
  <body>
    <div id="screen" class="flex-column w-100 h-100" style="min-width:250px;">
      <div  id="headerContainer" class="d-flex justify-content-center pt-2 pb-2 border-bottom bg-white" style="flex: 0 1 auto">
        <div class="header">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{route('news')}}" class="material-symbols-outlined text-center user-select-none" style="font-size:37px;text-decoration:none;color:black">newspaper</a>
            <a href="{{route('auth')}}"><img src="{{ asset('images/name-image.png') }}" alt="Liceo Berto" style="max-width:110px;"></img></a>
            <a href="{{route('profile', ['id' => Auth::id()])}}" class="d-flex align-content-center position-relative profile user-select-none" style="text-decoration:none;color:black;height:40px">
              <div  class="w-100 h-100 position-relative">
                <span class="material-symbols-outlined" style="font-size:40px">face_6 </span>
                @if(Auth::user()->notifications()->where('type', 'like')->where('seen', 0)->exists() Or Auth::user()->notifications()->where('type', 'comment')->where('seen', 0)->exists())
                  <div class="position-absolute text-danger" style="right:-3px; top:-5px;font-size:18px">!</div>
                  <div id="containerNotifications" class="position-absolute pt-1 pb-1 pe-1 rounded text-white popup d-flex align-content-center" style="background-color:rgb(255, 47, 64);bottom:-35px;">
                    @if(Auth::user()->notifications()->where('type', 'like')->exists())<div id="likeNotification" class="d-flex align-content-center"><div class="material-symbols-outlined me-1 ms-1">favorite</div>{{Auth::user()->notifications()->where('type', 'like')->count()}} </div>@endif 
                    @if(Auth::user()->notifications()->where('type', 'comment')->where('seen', 0)->exists())<div id="commentNotification" class="d-flex align-content-center"><div class="material-symbols-outlined me-1 ms-1" >chat_bubble</div>{{Auth::user()->notifications()->where('type', 'comment')->where('seen', 0)->count()}}</div>@endif
                  </div>
                @endif
              </div>
            </a>
          </div>
        </div>
      </div>
      <div id="main" class=" w-100 d-flex">
        <div id="contentContainer" class="content-container container-fluid"> 
          @yield('content') 
        </div>
        @yield('extraContent')
        @if(Auth::user()['logged_before'] == 0 && Request::url() != 'https://ambientestudenti.site/saveCred') 
            <div id="mainTutorial" class="position-fixed w-100 h-100 justify-content-center align-items-center">
                <div id="infoContainer" class="bg-white rounded pe-3 ps-3 p-2" style="font-size:18px">
                    <div class="text-center border-bottom pb-2" style="font-size:20px">Bonju, se non hai mai fatto l'accesso e non sai di cosa si tratta leggiti il breve tutorial <br>(son tre righe)</div>
                    <a class="text-center w-100 border-bottom p-2" style="display:block;text-decoration:none;color:blue;" href="{{route('documentation')}}/#tutorial" id="goToTutorial">Tutorial</a>
                    <div id="closeMainTutorial" class="w-100 text-center pt-2 p-1" style="cursor:pointer">Chiudi</div>
                </div>
            </div>
        @endif
      </div>
      <div class="w-100 bg-white" id="footer">
        @yield('footer')
      </div>
      @yield('extra')
      @if(Auth::user()->notifications()->where('type', 'report')->where('seen', 0)->exists()) 
        <div id="reportModal" class="position-fixed w-100 h-100">
          <div class="w-100 d-flex justify-content-center align-items-center h-100 position-relative">
              <div class="closeModal position-absolute w-100 h-100"></div>
              <div id="contentReportModal" class="bg-white rounded d-flex flex-column justify-content-center pt-2 pb-2 p-3">
                  <div class="text-center p-1 border-bottom text-danger" style="font-size:20px;">ATTENZIONE: <br>SEI STATO SEGNALATO</div>
                  <div id="reportText" class="ps-2 pt-2 w-100" style="font-size:18px;height:200px;overflow:scroll">{{Auth::user()->notifications()->where('type', 'report')->first()->report()->first()['report_text']}}</div>
                  <button class="closeModal chooseButton border-top pt-2 p-1">Ok, mi impegno a rettificare l'intervento</button>
                  <a class="text-center border-top" href="#">Se non sei a conoscenza delle regole o delle punizioni clicca questo testo </a>
              </div>
          </div>
        </div>
      @endif
    </div>
    <script>
      $(window).bind("load", function() {
        @if(Auth::user()->notifications()->where('type', 'like')->where('seen', 0)->exists() Or Auth::user()->notifications()->where('type', 'comment')->where('seen', 0)->exists())
          setTimeout(function(){
            $('#containerNotifications').css('left', "calc(-40px @if(Auth::user()->notifications()->where('type', 'like')->where('seen', 0)->exists()) - " + $('#likeNotification').width() + "px + 39px @endif  @if(Auth::user()->notifications()->where('type', 'comment')->where('seen', 0)->exists()) - " + $('#commentNotification').width() + "px + 39px @endif  )");
            $('#containerNotifications').css('display', 'flex');
          },0);
        @endif
        @if(Auth::user()['logged_before'] == 0 && Request::url() != 'https://ambientestudenti.site/saveCred')
            let url = "{{route('first.login')}}";
            $.ajax({
                method: "POST",
                url: url,
                async: true,
                complete: function(response){
                    console.log(response);
                }
            });
        @endif
        @yield('scriptBeforeScreenLoad')
        $('#screen').css('display', 'flex');
        @yield('scriptAfterScreenLoaded')
      });
      $('#mainTutorial, #closeMainTutorial').on('click', function(){
          $('#mainTutorial').css('display', 'none');
      });
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      setTimeout(function popupDissolve() {
        $('.popup').css('opacity', 0)
      }, 3000);
      $('.closeModal').on('click', function(){
          $('#reportModal').css('display', 'none');
      });
      var mySwiper = new Swiper ('.swiper', {
        grabCursor:true,
        pagination: {
            el: '.swiper-pagination',
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
      })
    </script>
    @yield('script')
</body>
</html>