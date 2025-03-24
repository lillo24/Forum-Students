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
    <title>Admin Page</title>
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
        overflow:scroll;
        flex-direction:column;
        position:relative;
      }
      .content-container{
        max-width:800px;
        min-height:0;
        padding:0;
      }
      .header{
        max-width: calc(945px);
        width:100%;
        padding-right:15px;
        padding-left:15px;
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
        #buttonStudentsContainer, #buttonProposalsContainer, #buttonCommentsContainer{
          padding-bottom:1.5rem;
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
      .selected{
        border: 2px black solid;
        border-radius: 8px;
        background-color:white;
      }
      .button{
        cursor:pointer;
      }
      .data-container{
        overflow-y:scroll;
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
      .data-container::-webkit-scrollbar {
        display: none;
      }
      #commentsContainerLvl2, #studentsContainerLvl2{
        display:none;
      }
      #commentsContainer, #studentsContainer, #proposalsContainer{
        padding-bottom: 5rem;
      }
      #reportModal{
          display:none;
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
      .chooseButton{
          border:none;
          background:none;
      }
      #buttonStudentsContainer, #buttonProposalsContainer, #buttonCommentsContainer{
        bottom:0px;
        left:0px;
        padding-bottom:4rem;
      }
      .userContainer{
        display:flex;
      }
      #saveChanges{
        border:2px black solid;
        border-radius: 5px;
        background-color:#8FEE8F;
      }
      #addUserModal{
          display:none;
          background:rgba(0,0,0,0.6);
          top:0px;
          z-index:10;
          color:black;
      }
      #contentAddUserModal{
          z-index:15;
          margin-bottom:150px;
          width:80%;
          max-width:650px;
          font-size:18px;
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
    </style>
    @yield('style')
  </head>
  <body>
    <div id="screen" class="flex-column w-100 h-100" style="min-width:250px;">
      <div  role="header" class="d-flex justify-content-center pt-2 pb-2 border-bottom bg-white" style="flex: 0 1 auto">
        <div class="header">
          <div class="d-flex justify-content-between align-items-center">
            <a href="{{route('news')}}" class="material-symbols-outlined text-center user-select-none" style="font-size:37px;text-decoration:none;color:black">newspaper</a>
            <a href="{{route('admin')}}"><img src="{{ asset('images/name-image.png') }}" alt="Liceo Berto" style="max-width:110px;"></img></a>
            <a href="{{route('profile', ['id' => Auth::id()])}}" class="material-symbols-outlined d-flex align-content-center position-relative profile user-select-none" style="text-decoration:none;color:black;font-size:40px">face_6 </a>
          </div>
        </div>
      </div>
      <div id="main" class="w-100 d-flex">
        <div id="contentContainer" class="h-100 content-container container-fluid d-flex flex-column">
          <div class="chooseMode d-flex w-100 justify-content-around p-2 border-bottom" style="flex: 0 1 auto">
            <div id="proposalsSection" class="selected pt-1 pb-1 p-2 button user-select-none">Proposte</div>
            <div id="commentsSection" class="pt-1 pb-1 p-2 button user-select-none">Commenti</div>
            @if($user['student_level'] == 5)
              <div id="studentsSection" class="pt-1 pb-1 p-2 button user-select-none">Studenti</div> 
            @endif
          </div>
          <div id="proposalsContainerLvl2" class="position-relative" style="flex: 1 1 auto;min-height:0">
            <div id="buttonProposalsContainer" class="w-100 position-absolute pe-4 ps-4 d-flex align-items-center justify-content-center">
              <div class="filter-container position-relative bg-white" style="width:90%;z-index:5;border-radius:10px;">
                <img src="{{ asset('images/search.png') }}" class="position-absolute"style="width:25px;left:9px;top:7px;" ></img>
                <input type="text" id="proposalsFilter" class="w-100 rounded" style="padding-left:37px;height:40px;"></input>
              </div>
            </div>
            <div id="proposalsContainer" class="pt-3 data-container h-100">
              @foreach($proposals as $proposal)
                <div id="proposalContainer{{$proposal['id']}}" class="data-container proposal-container me-4 ms-4 mb-4 rounded bg-white" style="border:1px black solid">
                    
                    <div class="border-bottom text-center p-1 bg-dark text-white proposalTitle rounded-top" style="word-break:break-word;white-space: pre-line">{{$proposal['proposal_title']}}</div>
                    
                    <div class="w-100 position-relative pb-0 p-2 proposal"><div id="proposal{{$proposal['id']}}" class="wrap-text" style="word-break:break-word;white-space: pre-line">{{$proposal['proposal_text']}}</div>
                    </div>
                    
                    <div class="under-bar-proposal w-100 d-flex bg-white rounded pe-2" style="justify-content: flex-end">
                        <div class="d-flex">
                            @if($user['student_level'] == 5) 
                            <div class="p-1 me-2" style="width:150px;overflow:hidden;text-overflow:ellipsis;">{{$proposal->user()->get()[0]["email"]}}</div>
                            <div id="deleteButton{{$proposal['id']}}" class="delete-proposal text-danger bg-white ms-0 m-1 material-symbols-outlined button user-select-none">cancel</div>
                            @endif
                            <div id="flagButton{{$proposal['id']}}" class="flag-button button material-symbols-outlined bg-white ms-0 m-1 user-select-none">
                                flag
                            </div>
                            <a id="commentButton{{$proposal['id']}}" class="comment-button button material-symbols-outlined bg-white ms-0 m-1 user-select-none">
                                chat_bubble
                            </a>
                        </div>
                    </div>
                </div>
              @endforeach
            </div>  
          </div>
          <div id="commentsContainerLvl2" class="position-relative" style="flex: 1 1 auto;min-height:0">
            <div id="buttonCommentsContainer" class="w-100 position-absolute pe-4 ps-4 d-flex align-items-center justify-content-center">
              <div class="filter-container position-relative bg-white" style="width:90%;z-index:5;border-radius:10px;">
                <img src="{{ asset('images/search.png') }}" class="position-absolute"style="width:25px;left:9px;top:7px;" ></img>
                <input type="text" id="commentsFilter" class="w-100 rounded" style="padding-left:37px;height:40px;"></input>
              </div>
            </div>
            <div id="commentsContainer" class="bg-white pt-3 data-container h-100">
                <div class="w-100 text-center">Nada ancora</div>
            </div>
          </div>
          @if($user['student_level'] == 5)
            <div id="studentsContainerLvl2" class="position-relative" style="flex: 1 1 auto;min-height:0">
              <div id="buttonStudentsContainer" class="w-100 position-absolute pe-4 ps-4 d-flex align-items-center justify-content-center">
                <div class="filter-container position-relative" style="width:90%;z-index:5;border-radius:10px;">
                  <img src="{{ asset('images/search.png') }}" class="position-absolute"style="width:25px;left:9px;top:7px;" ></img>
                  <input type="text" id="studentsFilter" class="w-100 rounded" style="padding-left:37px;height:40px;"></input>
                </div>
                <div id="addUser" class="ms-3"><div class="material-symbols-outlined rounded-circle p-2 button" style="font-size:30px;border:1px black solid">person_add</div></div>
              </div>
              <div id="studentsContainer" class="bg-white pt-2 pe-2 ps-2 data-container h-100" style="padding-bottom:7rem">
                @foreach($students as $student)
                  <div  id="{{$student['id']}}" class="w-100 userContainer justify-content-between p-3 border-bottom">
                    <div class="email me-2" style="flex: 1 1 auto;overflow:hidden;text-overflow: ellipsis;">{{$student['email']}}</div>
                    <div class="d-flex align-items-center">
                      <div class="delete-user text-danger me-2 material-symbols-outlined button user-select-none" style="font-size:20px;">cancel</div>
                      <select class="button studentLevelSelection" style="width:100px;border:none;border-left:1px black solid;">
                        <option type="checkbox" class="std-check-box" value="std">Studente</option>
                        <option type="checkbox" @if($student['student_level'] == 3) selected @endif class="mod-check-box" value="3">Moderatore</option>
                        <option type="checkbox" @if($student['student_level'] == 4) selected @endif class="rep-check-box" value="4">Rappresentante</option>
                        <option type="checkbox" @if($student['student_level'] == 5) selected @endif class="rep-check-box" value="5">Dirigente</option>
                      </select>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>
      
      @if($user['student_level'] == 5)
        <div id="deleteModal" class="position-fixed w-100 h-100">
          <div class="w-100 d-flex justify-content-center align-items-center h-100 position-relative">
              <div id="closeDeleteModal" class="position-absolute w-100 h-100"></div>
              <div id="contentDeleteModal" class="bg-white rounded d-flex flex-column justify-content-center pt-2 pb-2 p-3">
                  <button id="undoDeleteButton" class="chooseButton p-1">Annulla</button>
                  <button id="deleteButton" class="chooseButton border-top p-1 text-danger" value="">Elimina</button>
              </div>
          </div>
        </div>
        <div id="addUserModal" class="position-fixed w-100 h-100">
          <div class="w-100 d-flex justify-content-center align-items-center h-100 position-relative">
              <div id="closeAddUserModal" class="position-absolute w-100 h-100"></div>
              <div id="contentAddUserModal" class="bg-white rounded d-flex flex-column justify-content-center pt-2 pb-2 p-3">
                  <div class="text-center p-1 text-muted border-bottom">Aggiungi manualmente l'utente:</div>
                  <input id="nameInput" class="ps-2 pt-1 pb-1 mb-2 mt-3 rounded w-100" placeholder="Leonardo Colli" style="font-size:15px;"/>
                  <input id="emailInput" class="ps-2 pt-1 pb-1 mb-3 rounded w-100" placeholder="leonardo.colli04@gmail.com" style="font-size:15px;"/>
                  <button id="undoAddUserButton" class="chooseButton border-top p-1">Annulla</button>
                  <button id="addUserButton" class="chooseButton border-top p-1">Aggiungi</button>
              </div>
          </div>
        </div>
      @endif
      <div id="reportModal" class="position-fixed w-100 h-100">
        <div class="w-100 d-flex justify-content-center align-items-center h-100 position-relative">
            <div id="closeModal" class="position-absolute w-100 h-100"></div>
            <div id="contentReportModal" class="bg-white rounded d-flex flex-column justify-content-center pt-2 pb-2 p-3">
                <div class="text-center p-1 text-muted border-bottom">Fai la segnalazione:</div>
                <textarea id="reportText" class="ps-2 pt-2 w-100"placeholder="Motivazioni/Avviso" style="font-size:15px;min-height:200px;resize:none;"></textarea>
                <button id="undoButton" class="chooseButton border-top p-1">Annulla</button>
                <button id="reportButton" class="chooseButton border-top p-1 text-danger" value="">Reporta</button>
            </div>
        </div>
      </div>
    </div>
    <script>
      $(window).bind("load", function() {
        if (navigator.userAgent.match(/(iPod|iPhone|iPad)/i)) {
            $("body").height("89vh");
            $("html").height("89vh");
        }
        $('#screen').css('display', 'flex');
        
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

      });
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $("#proposalsSection").click(function(){
        if(!$(this).hasClass('selected')){
          $("#commentsSection").removeClass('selected');
          $("#studentsSection").removeClass('selected');
          $(this).addClass('selected');
          $('#commentsContainerLvl2').hide();
          $('#studentsContainerLvl2').hide();
          $('#proposalsContainerLvl2').show();
        }
      });
      $("#proposalsFilter").on("input", function(){
        let users = Array.from($('#proposalsContainer').children())
        let search = $(this).val().toLowerCase();
        users.forEach(function(element){
          let title = $(element).find(".proposalTitle").text().toLowerCase();
          if(title.match(search) == null){
            $(element).css('display', 'none');
          }else{
            $(element).css('display', 'block');
          }
        })
      });
      $("#commentsSection").click(function(){
        if(!$(this).hasClass('selected')){
          $("#proposalsSection").removeClass('selected');
          $("#studentsSection").removeClass('selected');
          $(this).addClass('selected');
          $('#proposalsContainerLvl2').hide();
          $('#studentsContainerLvl2').hide();
          $('#commentsContainerLvl2').show();
        }
      });
      $("#commentsFilter").on("input", function(){
        let users = Array.from($('#commentsContainer').children())
        let search = $(this).val().toLowerCase();
        users.forEach(function(element){
          let text = $(element).find(".text-div").text().toLowerCase();
          if(text.match(search) == null){
            $(element).css('display', 'none');
          }else{
            $(element).css('display', 'block');
          }
        })
      });
      @if($user['student_level'] == 5)
        $("#studentsSection").click(function(){
          if(!$(this).hasClass('selected')){
            $("#proposalsSection").removeClass('selected');
            $("#commentsSection").removeClass('selected');
            $(this).addClass('selected');
            $('#commentsContainerLvl2').hide();
            $('#proposalsContainerLvl2').hide();
            $('#studentsContainerLvl2').show();
          }
        });
        $(".studentLevelSelection").change(function(){
          let url = "{{route('user.level.change', ['id' => 'id_value',  'level' => 'level_value'])}}"
          let id = $(this).closest(".userContainer").attr('id');
          url = url.replace('id_value', id)
          url = url.replace('level_value', $(this).val())
          $.ajax({
              method: "GET",
              url: url,
              async: true,
              error: function(response){
                  alert('errore nella modifica')
              },
          });
        })
        $("#studentsFilter").on("input", function(){
          let users = Array.from($('#studentsContainer').children())
          let search = $(this).val().toLowerCase();
          users.forEach(function(element){
            let email = $(element).find(".email").text().toLowerCase();
            if(email.match(search) == null){
              $(element).css('display', 'none');
            }else{
              $(element).css('display', 'flex');
            }
          })
        });
        $("#addUser").click(function(){
          $('#addUserModal').css('display', 'block');
        });
        $('#closeAddUserModal, #undoAddUserButton').on('click', function(){
          $('#addUserModal').css('display', 'none');
        });
        $("#addUserButton").click(function(){
          let name = $("#nameInput").val();
          let email = $("#emailInput").val();
          let url = "{{route('user.store')}}"
          $.ajax({
            method: "POST",
            url: url,
            async: true,
            data: JSON.stringify({
              'name' : name,
              'email' : email,
            }),
            dataType: 'json',
            contentType: 'application/json',
          });
          $('#addUserModal').css('display', 'none');
        })
        $(".delete-user").click(function(){
          $('#deleteModal').css('display', 'block');
          let id = $(this).closest(".userContainer").attr('id');
          $('#deleteButton').attr('value', id);
        });
        $(".delete-proposal").click(function(){
          $('#deleteModal').css('display', 'block');
          let id = $(this).attr("id").match(/\d+/);
          $('#deleteButton').attr('value', id);
        });
        $("#commentsContainer").on('click', '.delete-comment', function(e){
          $('#deleteModal').css('display', 'block');
          let id = $(this).attr("id").match(/\d+/);
          $('#deleteButton').attr('value', id);
        });
        $('#closeDeleteModal, #undoDeleteButton').on('click', function(){
          $('#deleteModal').css('display', 'none');
          $('#deleteButton').attr('value', "");
        });
        $("#deleteButton").click(function(){
          let id = $(this).attr("value").match(/\d+/)[0];
          var url = "";
          var type = null;
          if($("#proposalsSection").hasClass('selected')){
            type=1;
          }else if($("#commentsSection").hasClass('selected')){
            type=2;
          }else{
            type=3;
          }
          switch(type){
            case 1:
              url = "{{route('proposal.delete', 'id_value')}}";
              break;
            case 2:
              url = "{{route('comment.delete', 'id_value')}}";
              break;
            case 3:
              url = "{{route('user.delete', 'id_value')}}";
              break;
          }
          url = url.replace('id_value', id)
          $.ajax({
            method: "DELETE",
            url: url,
            async: true,
            error: function(response){
              alert('Errore nel reporting');
            },
            success: function(response){
              switch(type){
                case 1:
                  $("#proposalsContainer").find("#proposalContainer" + id).remove();
                  break;
                case 2:
                  $("#commentsContainer").find("#comment" + id).remove();
                  break;
                case 3:
                  $("#studentsContainer").find("#" + id).remove();;
                  break;
              }
            }
          });
          $('#deleteModal').css('display', 'none');
          $('#deleteButton').attr('value', "");
        })
      @endif
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
      $("#proposalsContainer").on('click', '.flag-button', function(e){
        $('#reportModal').css('display', 'block');
        let targetOfReport = e.target.id.match(/\d+/);
        $('#reportButton').attr('value', targetOfReport);
      });
      $("#commentsContainer").on('click', '.report-button', function(e){
        $('#reportModal').css('display', 'block');
        let targetOfReport = e.target.id.match(/\d+/);
        $('#reportButton').attr('value', targetOfReport);
      });
      $('#closeModal, #undoButton').on('click', function(){
          $('#reportButton').attr('value', "");
          $('#reportModal').css('display', 'none');
      });
      $("#reportButton").click(function(){
        let id = $(this).attr("value").match(/\d+/)[0];
        let reportText = $("#reportText").val();
        if($("#proposalsSection").hasClass('selected')){
          var data = {
            'report_text' : reportText,
            'proposal_reported' : id,
          }
        }else{
          var data = {
            'report_text' : reportText,
            'comment_reported' : id,
          }
        }
        let url = "{{route('report.store')}}"
        $.ajax({
            method: "POST",
            url: url,
            async: true,
            data: JSON.stringify(data),
            dataType: 'json',
            contentType: 'application/json',
            complete: function(response){
              $('#reportButton').attr('value', "");
              $('#reportModal').css('display', 'none');
            }
        });
      });
      $(".comment-button").click(function(){
        let This = this;
        let id = $(this).attr("id").match(/\d+/);
        let url = "{{route('retrieveAllComments', 'proposal_value')}}"
        url = url.replace('proposal_value', id[0])
        $.ajax({
        method: "GET",
        url: url,
        async: true,
        error: function(){
            alert('couldn\'t load');
        },
        success: function(response){
          $("#commentsContainer").children().not("#buttonCommentsContainer").remove();
          if (response.length === 0) {
            $("#commentsContainer").append("<div class='text-center w-100'>No commuentas here... mi dispiace</div>");
          }else{
            response.forEach(element => $("#commentsContainer").append(element));
          }
        }
        });
        $("#commentsSection").addClass('selected');
        $("#proposalsSection").removeClass('selected');
        $('#proposalsContainerLvl2').hide();
        $('#commentsContainerLvl2').show();
      });
      $("#commentsContainer").on('click', '.show-answers-button', function(e){
        let comment_id = e.target.id.match(/\d+/);
        if($("#" + e.target.id).text() == 'Hide answers'){
            $("#relCommentsContainer" + comment_id).css('display', 'none');
            $("#" + e.target.id).text('Show answers');
        }else if($("#" + e.target.id).text() == 'Show answers'){
            $("#relCommentsContainer" + comment_id).css('display', 'block');
            $("#" + e.target.id).text('Hide answers');
        }
      });
    </script>
  </body>
</html>