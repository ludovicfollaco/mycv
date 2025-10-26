let sommeJoueur = 0;
let joueurActif;
let partieEncours;
let deLance = false;

// Joueur name
let Joueur1 = "Joueur 1";
let Joueur2 = "Joueur 2";

let inputTotal1 = document.getElementById('total1');
let inputTotal2 = document.getElementById('total2');
let inputSomme1 = document.getElementById('somme1');
let inputSomme2 = document.getElementById('somme2');

let btnNewGame = document.getElementById('btnNewGame');
let btnCancelGame = document.getElementById('btnCancelGame');
let btnPrendre = document.getElementById('btnPrendre');
let txtJoueur1 = document.getElementById('txtJoueur1');
let txtJoueur2 = document.getElementById('txtJoueur2');

btnPrendre.style.visibility = 'hidden';
btnCancelGame.style.visibility = 'hidden';
btnNewGame.style.height= '0px';
btnCancelGame.style.height= 'auto';

bgInputBlanc();
txtInputNoir();

// Changer le nom d'Alcor
function editerNomJoueur1() {
    Joueur1 = prompt("Changer le nom du Joueur 1");
    document.querySelector("h1.Joueur1").innerHTML = Joueur1;
}

// Changer le nom de Vénusia
function editerNomJoueur2() {
    Joueur2 = prompt("Changer le nom du Joueur 2");
    document.querySelector("h1.Joueur2").innerHTML = Joueur2;
}

//Lancer le dé
function lanceLeDe(){
    if(partieEncours === true){
        document.querySelector(".img3").setAttribute("src", "../../img/goldorak/game/lanceDe.gif");
        setTimeout(valeurDuDe, 1000);
    }else{
        alert("Clique sur le bouton nouvelle partie avant de lancer le dé.");
    }
}

//Sortir une valeur aléatoire du dé et incrémenter la valeur dans la variable 'somme' OU annuler le tour si la valeur est égale à 1.
function valeurDuDe() {
    let randomNumber = Math.floor(Math.random() * 6) + 1;
    document.querySelector(".img3").setAttribute("src", "../../img/goldorak/game/dice" + randomNumber + ".webp");

    if (randomNumber === 1){
        
        sommeJoueur = 0;
        randomNumber = 0;
        deLance = false;

        if(joueurActif === 1){
            document.getElementById('somme1').value = 0;
            joueur2Joue();
        }else if(joueurActif === 2){
            document.getElementById('somme2').value = 0;
            joueur1Joue();
        }

    }else if(randomNumber > 1){
        
        if(joueurActif === 1){
            sommeJoueur = parseInt(document.getElementById('somme1').value) + randomNumber;
            document.getElementById('somme1').value = sommeJoueur;
        }else if(joueurActif === 2){
            sommeJoueur = parseInt(document.getElementById('somme2').value) + randomNumber;
            document.getElementById('somme2').value = sommeJoueur;
        }
        deLance = true;
    }
    
    changeColor();
}

//Incrémenter la somme des coups dans la variable 'total' après avoir cliqué sur le btn 'Prendre'
function validerSomme(){
    if(deLance === true){
        if(joueurActif === 1){

            document.getElementById('total1').value = parseInt(document.getElementById('total1').value) + sommeJoueur;
            document.getElementById('somme1').value = 0;
            
            if(parseInt(document.getElementById('total1').value) >= 100){
                bravoJoueur1();
                exit();
            }
            
            joueur2Joue();

        }else if(joueurActif === 2){

            document.getElementById('total2').value = parseInt(document.getElementById('total2').value) + sommeJoueur;
            document.getElementById('somme2').value = 0;
            if(parseInt(document.getElementById('total2').value) >= 100){
                bravoJoueur2();
                exit();
            }
            
            joueur1Joue();
        }
        sommeJoueur = 0;
        changeColor();
        deLance = false;
    }else{
        alert("Lance le dé avant d'ajouter la somme dans le total");
    }
}

function annulerPartie(){
    changeColor();
    resetVariable();
}

//Paramètres pour permettre à Alcor de jouer
function joueur1Joue(){
    txtJoueur1.textContent = "Allez " + document.querySelector("h1.Joueur1").innerHTML + ", à toi de jouer!" ;
    txtJoueur2.textContent = "" ;
    joueurActif = 1;
}

//Paramètres pour permettre à Vénusia de jouer
function joueur2Joue(){
    txtJoueur2.textContent = "Allez " + document.querySelector("h1.Joueur2").innerHTML + ", à toi de jouer!" ;
    txtJoueur1.textContent = "" ;
    joueurActif = 2;
}

function finPartie(){
    partieEncours= false;
    btnNewGame.style.visibility = 'visible';
    btnPrendre.style.visibility = 'hidden';
    btnCancelGame.style.visibility = 'hidden';
    btnNewGame.style.height= 'auto';
    btnCancelGame.style.height= '0px';
}

function bravoJoueur1(){
    txtJoueur1.textContent = "Bravo!!! " + document.querySelector("h1.Joueur1").innerHTML + " tu as gagné cette partie" ;
    txtJoueur2.textContent = "" ;
    finPartie();
}

function bravoJoueur2(){
    txtJoueur2.textContent = "Bravo!!! " + document.querySelector("h1.Joueur2").innerHTML + " tu as gagné cette partie" ;
    txtJoueur1.textContent = "" ;
    finPartie();
}

//Changer les bg et txt des input après avoir cliqué sur nouvelle partie
function changeColor(){

    txtInputBlanc();

    if (joueurActif === 1) {
        inputTotal1.style.backgroundColor = 'green';
        inputSomme1.style.backgroundColor = 'green';
        inputTotal2.style.backgroundColor = 'red';
        inputSomme2.style.backgroundColor = 'red';
    } else if (joueurActif === 2) {
        inputTotal1.style.backgroundColor = 'red';
        inputSomme1.style.backgroundColor = 'red';
        inputTotal2.style.backgroundColor = 'green';
        inputSomme2.style.backgroundColor = 'green';
    }
}

function resetVariable(){
    
    bgInputBlanc();
    txtInputNoir();
    finPartie();

    sommeJoueur = 0;
    joueurActif = 1;

    document.getElementById('total1').value = 0;
    document.getElementById('somme1').value = 0;
    document.getElementById('total2').value = 0;
    document.getElementById('somme2').value = 0;

    txtJoueur1.textContent = "" ;
    txtJoueur2.textContent = "" ;

    partieEncours= false;
    btnNewGame.style.visibility = 'visible';
    btnPrendre.style.visibility = 'hidden';
    btnCancelGame.style.visibility = 'hidden';
}

function nouvellePartie(){
    resetVariable();
    changeColor();
    joueur1Joue();

    btnNewGame.style.height= '0px';
    btnCancelGame.style.height= 'auto';
    
    btnNewGame.style.visibility = 'hidden';
    btnCancelGame.style.visibility = 'visible';
    btnPrendre.style.visibility = 'visible';

    partieEncours= true;
}

function bgInputBlanc(){
    inputTotal1.style.backgroundColor = '#ffffff';
    inputSomme1.style.backgroundColor = '#ffffff';
    inputTotal2.style.backgroundColor = '#ffffff';
    inputSomme2.style.backgroundColor = '#ffffff';
}

function txtInputNoir(){
    inputTotal1.style.color = '#000000';
    inputSomme1.style.color = '#000000';
    inputTotal2.style.color = '#000000';
    inputSomme2.style.color = '#000000';
}

function txtInputBlanc(){
    inputTotal1.style.color = '#ffffff';
    inputSomme1.style.color = '#ffffff';
    inputTotal2.style.color = '#ffffff';
    inputSomme2.style.color = '#ffffff';
}