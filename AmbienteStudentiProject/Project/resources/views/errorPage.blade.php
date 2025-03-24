<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error page</title>
<style>
    #contentContainer{
        overflow:scroll;
    }
</style>
</head>
<body>
<div class="d-flex justify-content-center">
    <div class="w-100 p-2 mt-4 bg-white" style="font-size: clamp(16px,4vw,23px);border-top:1px black solid;border-bottom:1px black solid">
@if($error == 'wrongRoute')
        Da come ho creato il sito mi sembra di capire che non dovresti essere qua:<br>
        - Cercato un url senza i necessari permessi (Senza essere loggato per esempio)<br>
        - Raggiungere dei dati non disponibili (Dei commenti durante una settimana che non sia la seconda)<br>
        - I database non sono attivi<br>
        - Qualcos'altro <br>
        spero non sia un errore mio invece :(
        <br>(Se pensi sia l'ultimo caso allora vai sul tuo profilo, abbassa la tendina e clicca sulla bandiera descrivendo poi il problema)
        ....spero non sia niente di grave <br> ~Lillo
@elseif($error == 'errorLogin')
        Errore nel loggin, esto es a problema :00
@endif
    </div>
</div>
</body>
</html>