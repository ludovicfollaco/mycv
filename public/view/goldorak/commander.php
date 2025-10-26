<div class="text-center">
    </br><h2>Jeu : Aide le professeur Procyon à choisir le commandant d'escadrille en l'absence d'Actarus</h2></br>
</div>

<div class="container border rounded-3 p-0 pb-5 my-5"> 
    <div class="row d-flex justify-content-center">
        <div class="col-12">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item" style="background-color: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-light fs-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Contexte
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body text-light" style="text-align: justify;">
                            Le professeur Procyon (père adoptif d'Actarus) est face à un dilemme. Actarus n'est pas en mesure de combattre car il a reçu une blessure importante lors de la dernière bataille.
                            Alcor et Vénusia se revendiquent tout deux en mesure de prendre le commandement de l'escadrille en l'absence d'Actarus.
                            Ne pouvant faire un choix affectif car les deux jeunes combattants sont suffisamment formés pour assumer cette tâche, le professeur décide de les mettre en compétition dans une épreuve d'entraînement.
                            Le gagnant sera le prochain commandant d'escadrille.
                        </div>
                    </div>
                </div>

                <div class="accordion-item" style="background-color: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-light fs-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Régle de l'épreuve
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body text-light" style="text-align: justify;">
                            Chaque compétiteur possède un score temporaire nommé Somme et un score global nommé Total.
                            À chaque tour, le joueur a sa Somme initialisée à 0 et peut lancer le dé autant de fois qu'il le souhaite.
                            Le résultat de la Somme est ajouté au Total.
                            Lors de son tour, le joueur peut décider à tout moment de :<br>
                            - Cliquer sur “Prendre”, qui permet d’envoyer les points accumulés dans Somme vers le compteur Total. Ce sera alors le
                            tour de l’autre joueur.<br>
                            - Lancer le dé. Si le joueur obtient un 1, son score (Somme) est perdu et c’est la fin de ton tour.<br>
                            Le premier joueur qui atteint les 100 points sur le compteur Total gagne le jeu.
                        </div>
                    </div>
                </div>

                <div class="accordion-item" style="background-color: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-light fs-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            Avant de commencer la partie
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body text-light" style="text-align: justify;">
                            1. Clique sur le bouton "nouvelle partie",<br>
                            2. Etant le premier joueur, Alcor peut commencer en cliquant sur le dé,<br>
                            Les compteurs (Somme) et (Total) sont en vert pour le joueur ayant la main et un texte d'état apparait en Orange. 
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <hr>
    </div>
    
    <div class="row d-flex justify-content-center mt-4" id="btnNewGame">
        <div class="col-12 d-flex justify-content-center">
            <button class="btn btn-lg btn-primary my-3 mx-auto" type="button"  onClick="nouvellePartie()">Nouvelle partie</button>
        </div>
    </div>
    
    <div class="row d-flex justify-content-center" id="btnCancelGame" >
        <div class="col-12 d-flex justify-content-center">
            <button class="btn btn-lg btn-primary my-3 mx-auto" type="button"  onClick="annulerPartie()">Annuler partie</button>
        </div>
    </div>

    <div class="row d-flex flex-wrap justify-content-between align-items-center m-0 p-0">
        
        <div class="d-flex flex-column col-md-5 m-md-0 mb-3 justify-content-center align-items-center">

            <h1 class="Joueur1 mt-0 mb-3">Alcor</h1>

            <div class="d-flex mb-3 justify-content-center align-items-center">
                
                <img class="img1 my-auto" src="../img/common/avatar/avatar_alcor_01.webp" style="width: 60px; height: 60px;">
                    
                <div class="d-flex flex-column">
                    
                    <div class="d-flex justify-content-end">
                        <label class="text-light ms-3" for="somme1">Somme</label>
                        <input class="mx-3 p-auto text-center"  type="text" name="somme1" id="somme1" style="width: 45px; height: 30px;" value="0" readonly>
                    </div>

                    <div class="d-flex justify-content-end">
                        <label class="text-light ms-3" for="total1">Total</label>
                        <input class="mx-3 p-auto text-center"  type="text" name="total1" id="total1" style="width: 45px; height: 30px;" value="0" readonly>
                    </div>

                </div>

            </div>
            
            <p class="text-warning text-center fs-2" id="txtJoueur1"></p>

        </div>

        <div class="col-md-2 m-md-0 mb-4">
            
            <div class="d-flex justify-content-center">
                <img class="img3" src="../img/goldorak/game/dice3.webp" onClick="lanceLeDe()" style="width: 100px; height: 100px;">
            </div>
        </div>
        
        <div class="d-flex flex-column col-md-5 m-md-0 mb-3 justify-content-center align-items-center">

            <h1 class="Joueur2 mt-0 mb-3">Vénusia</h1>

            <div class="d-flex mb-3 justify-content-center">
                
                <img class="img1 my-auto" src="../img/common/avatar/avatar_venusia_01.webp" style="width: 60px; height: 60px;">
                    
                <div class="d-flex flex-column">
                    
                    <div class="d-flex justify-content-end">
                        <label class="text-light ms-3" for="somme2">Somme</label>
                        <input class="mx-3 p-auto text-center"  type="text" name="somme2" id="somme2" style="width: 45px; height: 30px;" value="0" readonly>
                    </div>

                    <div class="d-flex justify-content-end">
                        <label class="text-light ms-3" for="total2">Total</label>
                        <input class="mx-3 p-auto text-center"  type="text" name="total2" id="total2" style="width: 45px; height: 30px;" value="0" readonly>
                    </div>

                </div>

            </div>
            
            <p class="text-warning text-center fs-2" id="txtJoueur2"></p>
            
        </div>
        
    </div>

    <div class="row d-flex justify-content-center my-3 mx-auto">
        <div class="col-12 d-flex justify-content-center">
            <button type="button" class="btn btn-lg btn-primary my-3 mx-auto" id="btnPrendre" onClick="validerSomme()">Prendre</button>
        </div>
    </div>

    <p class="text-warning text-center" id="p_valeur"></p>

</div>

<script src="../js/goldorak/commander.js"></script>