<div class="text-center">
    </br><h2>Jeux : Aide Goldorak à trouver le nombre de Golgoth prêt à attaquer la terre.</h2></br>
</div>

<div class="container border rounded-3 mb-5" id="game-container">

    <div class="m-3 me-auto pe-3">

        <h2>Règle du jeu</h2>
        <p style="text-align: justify;">
            Le but du jeu est d'aider Goldorak à trouver le nombre de Golgoth prêt à attaquer la terre afin qu'il puisse dimensionner son arsenal avant de partir au combat. Tu dois trouver le nombre de Golgoth en saisissant le moins de propositions possible.
            Un agent double est connecté pour t'aider en t'indiquant si le nombre est supérieur ou inférieur à ta dernière saisie. Pour que tu puisses te concentrer sur la tâche qu'Actarus t'a confiée, le professeur a développé un nouvel outil pour que toutes tes propositions soient enregistrées et affichées sur ton tableau de bord. 
            <br><br>
            Tu as bien compris? Alors c'est parti pour une nouvelle mission et sauver la terre!
            <br><br>
            Commence par saisir ton pseudo, sélectionne un niveau de difficulté puis clique sur "Commencer la mission".
        </p>

    </div>

    <hr>

    <form class="d-flex flex-column mb-3" id="game-form">

        <div class="ms-3 me-auto pe-3">
            <label for="playerName">Quel est ton pseudo ?</label>
            <input type="text" id="playerName" name="playerName" required onkeydown="if(event.keyCode==13) startGame()">
        </div>

        <hr>

        <label class="ms-3 me-auto pe-3">Choisis un niveau de difficulté :</label>
        <div class="ms-3 me-auto pe-3">
            <input type="radio" id="difficulty" name="difficulty" value="1" checked>
            <label for="easy">de 1 à 10</label>
        </div>

        <div class="ms-3 me-auto pe-3">
            <input type="radio" id="difficulty" name="difficulty" value="2">
            <label for="medium">de 1 à 100</label>
        </div>

        <div class="ms-3 me-auto pe-3">
            <input type="radio" id="difficulty" name="difficulty" value="3">
            <label for="hard">de 1 à 1000</label>
        </div>

        <hr>

        <button id="startButton" class="btn btn-lg btn-primary ms-3 me-auto" type="button" onclick="startGame()">Commencer la mission</button>
    
    </form>
    
</div>

<script src="../js/goldorak/goldorakgo.js"></script>