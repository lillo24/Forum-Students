@extends('layout')
@section('title', 'Documentazione')
@section('style')

<style>
    #contentContainer{
        padding: 1rem;
        padding-bottom: 2rem;
        padding-top:0px;
        overflow:scroll;
    }
</style>

@endsection
@section('content')
<div id="introduction" class="mt-3">
    <div style="font-size:25px;"><b>Benvenuto nell'ambiente studenti (A.S.) del Liceo Berto</b></div>
</div>
<div class="mt-3" id="navContainer">
    <a href="#introduction" style="color:black; text-decoration:none;"><span style="color:red;margin-right:4px"><i>#</i></span>Introduzione</a>
    <br>
    <a href="#tutorial" style="color:black; text-decoration:none;"><span style="color:red;margin-right:4px"><i>#</i></span>Tutorial</a>
    <br>
    <a href="#rules" style="color:black; text-decoration:none;"><span style="color:red;margin-right:4px"><i>#</i></span>Regole</a>
</div>
<div class="mt-3" id="introduction">
    <div class="" style="font-size:22px"><span style="color:red;margin-right:4px"><i>#</i></span>Introduzione</div>
    <div class="mt-2" style="font-size:17px;">Questo è un progetto ideato da Leonardo Colli come automotivazione per studiare informatica :)</div>
    <div class="" style="font-size:17px;">L'obbiettivo secondario è ovviamente di migliorare effetivamente la scuola</div>
    <div class="mt-2" style="font-size:17px;">Sarà un collettivo studentesco online, in poche parole un forum online per gli studenti strutturato a settimane</div>
    <div class="mt-2" style="font-size:17px;">L'anonimato dovrebbe risolvere il problema della pressione/paura del giudizio degli altri, mi ha fatto molto male in passato e mi da fastidio tutt'ora, quindi sono soddisfatto di poter vedere un ambiente protetto da questa tendenza dannosa dell'umano</div>
    <div class="mt-2" style="font-size:17px;">Gli abusi essendo un sito istituzionale si sperà non venga neanche in mente di praticarli, ma nel caso qualcuno avesse bisogno di un aiutino per capire come non offendere gli altri c'è la sezione del regolamento ⊂⁠(｡⁠•́⁠‿⁠•̀⁠｡)⁠つ</div>
    <div class="mt-3" style="font-size:17px;">Fin'ora ho speso all'incirca 50 euro di tasca mia nel sito (Non sono comprese le centinaia di ore che ho speso per farlo visto che le conoscenze che ho acquisito nel farlo sono il compenso), lascerò queste frasi finchè non li recupererò in qualche modo. É abbastanza triste averci speso tutte queste ore, darlo gratis e doverlo pagare :/</div>
</div>
<div class="mt-3" id="tutorial">
    <div class="" style="font-size:22px"><span style="color:red;margin-right:4px"><i>#</i></span>Tutorial</div>
    <div class="mt-2" style="font-size:17px;">In A.S. Berto in poche parole puoi proporre le tue idee e votare quelle degli altri, confrontarsi attraverso i commenti e infine, se abbastanza popolare, vedere la propria idea portata in consiglio di istituto</div>
    <div class="mt-2" style="font-size:17px;"> Ogni mese inizia un "ciclo", per esempio l'1 febbraio ne inizia uno e finirà il 28</div>
    <div class="mt-2" style="font-size:17px;"> Ogni ciclo è composto da 4 settimane (7 giorni), quindi la fine della prima settimana (e quindi l'inizio della seconda) sarà l'8 febbraio</div>
    <div class="mt-2" style="font-size:17px;"> Se l'1 febbraio è di mercoledì allora la prima settimana finirà il mercoledì successivo </div>
    <div class="mt-2" style="font-size:17px;"> Le settimane con le relative funzioni sono: 
        <ul>
            <li>Prima: Formula e rielabora la tua proposta (Hai fino all'ultimo giorno)</li>
            <li>Seconda: Le proposte vengono pubblicate, te puoi commentare sotto le proposte degli altri e mettere like a quelle che ritieni più interessanti (Ne verranno scelte 10)</li>
            <li>Terza: Rielabora la tua idea in base ai suggerimenti (commenti) che ti hanno dato i tuoi compagni</li>
            <li>Quarta: Votazione finale, ne verranno scelte tre che se supereranno un minimo di voti verranno portate dai rappresentanti in assemblea di istituto (Riunione tra preside, professori e rappresentanti)</li>
        </ul>
    </div>
    <div class="mt-2" style="font-size:17px;">(Per ogni settimana è presente un mini tutorial cliccando la freccetta in basso a destra</div>
</div>
<div class="mt-3" id="rules">
    <div class="" style="font-size:22px"><span style="color:red;margin-right:4px"><i>#</i></span>Regole</div>
    <div class="mt-2" style="font-size:17px;">La regola base è che tutto quello che si fa nel sito deve avere l'obbiettivo di fare bene, ovvero: Migliorare la scuola, procurare divertimento, aiutare qualcuno.. se non vengono rispettate L'ANONIMATO VIENE MENO, quindi: </div>
    <div class="mt-2" style="font-size:17px;">- No offese e quindi RISPETTO reciproco</div>
    <div class="mt-2" style="font-size:17px;">- No volgarità (Inutili)</div>
    <div class="mt-2" style="font-size:17px;">- No utilizzi del sito in modo che rovinino l'esperienza agli altri (Esempio: provare a rompere la grafica inserendo scritte in modo particole o inserendone tantissime) </div>
    <div class="mt-2" style="font-size:17px;">- Non ci si può firmare, ma penso fosse scontato </div>
</div>
@endsection
@section('scriptBeforeScreenLoad')

    if (navigator.userAgent.match(/(iPod|iPhone|iPad)/i)) {
        $("body").height("89vh");
        $("html").height("89vh");
    }

@endsection