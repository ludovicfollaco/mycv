let playerName;
let attempts = 0;
let maxNumber;
let secretNumber;
let guessedNumbers = [];

let gameContainer = document.getElementById("game-container");
let contenuHtmlActuel;
let ajoutBaliseHtml;
let ajoutBaliseHtml_2;
let propositionEffectuée;

// Fonction pour commencer le jeu
function startGame() {
    // Récupérer les valeurs du formulaire
    playerName = document.getElementById("playerName").value;
    let difficultyElements = parseInt(document.querySelector('input[name=difficulty]:checked').value);

    // Trouver la difficulté sélectionnée
    //difficultyElements = parseInt(difficultyElements);

    // Vérifier la validité de la difficulté
    if (isNaN(difficultyElements) || difficultyElements < 1 || difficultyElements > 3) {
        alert("Choix de difficulté non valide. Le jeu va se fermer.");
    } else {
        // Définir la plage de nombres en fonction de la difficulté
        switch (difficultyElements) {
            case 1:
                maxNumber = 10;
                break;
            case 2:
                maxNumber = 100;
                break;
            case 3:
                maxNumber = 1000;
                break;
            default:
                break;
        }

        // Générer le nombre mystère
        secretNumber = 0;
        while (secretNumber === 0){
            secretNumber = Math.floor(Math.random() * maxNumber) + 1;
        }

        // Afficher le jeu
        displayGame(0);
    }
}

// Afficher le jeu
function displayGame(valeur=0) {
    gameContainer.innerHTML = '<div class=" mb-3 ms-3 me-auto pe-3">\n<h2>Bon courage, ' + playerName + '!<br>Trouve le nombre de Golgoth, il peut aller de 1 à ' + maxNumber + '</h2>\n<form id="guess-form">\n<label for="userGuess">Quel est le nombre de Golgoth ?</label>\n<input type="number" id="userGuess" name="userGuess" min="1" max="' + maxNumber + '" required onkeydown="if(event.keyCode==13) makeGuess()" value="' + valeur + '">\n<br>\n<button class="btn btn-lg btn-primary" id="guessButton" type="button" onclick="makeGuess()">Proposer</button>\n</form>\n</div>\n';
    contenuHtmlActuel = gameContainer.innerHTML;

    // Ajoute un gestionnaire d'événements pour la touche "Entrée" sur le bouton "Proposer"
    document.getElementById("guessButton").addEventListener("keydown", function(event) {
        if (event.key === 13) {
            makeGuess();
        }
    });

    // Ajoute un gestionnaire d'événements pour la touche "Entrée" dans le champ de texte
    document.getElementById("userGuess").addEventListener("keydown", function(event) {
        if (event.key === 13) {
            makeGuess();
        }
    });
}

// Fonction pour faire une proposition
function makeGuess() {
    let userGuess = parseInt(document.getElementById("userGuess").value);

    // Vérifier la validité de la saisie
    if (isNaN(userGuess) || userGuess < 1 || userGuess > maxNumber) {
        alert("Saisie non valide. Réessaie.");
    } else {
        // Incrémenter le nombre de tentatives
        attempts++;

        // Ajouter la réponse à la liste des réponses déjà effectuées
        guessedNumbers.push(userGuess);
        displayGame(userGuess);
        // Vérifier la devinette
        if (userGuess < secretNumber) {
            customAlert("Trop bas! Essaie encore.");
            gameContainer.innerHTML = contenuHtmlActuel + "<p class='ms-3'><strong>" + userGuess + " c'est trop Bas!</strong></p>" + displayResults();
        } else if (userGuess > secretNumber) {
            customAlert("Trop haut! Essaie encore.");
            gameContainer.innerHTML = contenuHtmlActuel + "<p class='ms-3'><strong>" + userGuess + " c'est trop haut!</strong></p>" + displayResults();
        } else {
            // Le joueur a deviné correctement
            let messageGagnant = "<h2 class='m-3'>Bravo, " + playerName + "!</h2><h3 class='m-3'>Tu as trouvé le nombre de Golgoth en " + attempts + " tentatives.</h3><h4 class='m-3'>Goldorak doit abattre " + userGuess + " Golgoth(s) pour sauver la terre.</h4>";
            
            ajoutBaliseHtml = `
                <p class="m-3" >` + messageGagnant + `</p>
                <img class="m-3" src="../../img/goldorak/game/gagne.gif" alt="J'ai gagné">
                <br>
                `+ displayResults(); +`
                <br>
            `;
            ajoutBaliseHtml_2 = `
                <button class="btn btn-lg btn-primary ms-3 me-auto mb-3" type="button" onclick="ouvrirJeux()">Nouvelle partie</button>
            `;
            gameContainer.innerHTML = ajoutBaliseHtml + ajoutBaliseHtml_2;

        }
    }
}

// Afficher les résultats
function displayResults() {
    propositionEffectuée = "<p class='m-3'>Réponses proposées : " + guessedNumbers.join(", ") + "</p>";
    return propositionEffectuée;
}

function ouvrirJeux() {
    window.location.href = "index.php?page=goldorakgo";
}

// Fonction personnalisée pour alert
function customAlert(message) {
    alert(message);
}

// Fonction personnalisée pour prompt
function customPrompt(message) {
    return prompt(message);
}

// Ajoute un gestionnaire d'événements pour la touche "Entrée" lors de l'utilisation de prompt
window.addEventListener("keydown", function(event) {
    if (event.keyCode === 13 && document.activeElement.tagName.toLowerCase() === "input" && document.activeElement.type === "text") {
        // Intercepte la touche "Entrée" dans le champ de texte de prompt
        event.preventDefault();
        customPromptInput();
    }
});

// Fonction personnalisée pour intercepter la touche "Entrée" dans le champ de texte de prompt
function customPromptInput() {
    // Récupère la valeur actuelle du champ de texte
    let inputText = document.activeElement.value;

    // Ferme la fenêtre prompt
    customPromptClose();

    // Utilise la valeur du champ de texte comme si la touche "Entrée" avait été pressée
    customPromptReturnValue(inputText);
}

// Fonction personnalisée pour fermer la fenêtre prompt
function customPromptClose() {
    document.activeElement.blur();
}

// Fonction personnalisée pour renvoyer la valeur à partir de prompt
function customPromptReturnValue(value) {
    // Utilisez la valeur récupérée comme vous le feriez normalement dans le code
    console.log("Valeur de prompt : " + value);
}

// Redéfinition de la fonction prompt pour utiliser notre version personnalisée
window.prompt = customPrompt;