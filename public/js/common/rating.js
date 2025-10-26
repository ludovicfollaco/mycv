function handleRating(event){

    if(event.target.tagName === 'I'){

        // Récupérer la valeur de data-rating
        let ratingValue = event.target.getAttribute('data-rating');

        // Mettre à jour la valeur du champ de texte
        document.getElementById('selectedRating').value = ratingValue;

        // Réinitialiser les classes "active" pour toutes les étoiles
        let stars = document.querySelectorAll('.rating i');
        stars.forEach(function(star) {
            star.classList.remove('active');
        });

        // Ajouter la classe "active" pour les étoiles jusqu'à la note sélectionnée
        for (let i = 0; i < ratingValue; i++) {
            stars[i].classList.add('active');
        }
        
    }

}

function verifSendComment(input){

    if(!comment(input)){
        alert ("Le commentaire ne pas être vide!!!");
    }

}

function comment(input){
    
    const myInput = document.getElementById(input);

    if(verifInputEmpty(input)){

        myInput.style.background = '#FFB4B4';
        return false;

    }else{

        myInput.style.background = '#FFFFFF';
        return true;

    }

}

function verifInputEmpty(input) {
    const myInput = document.getElementById(input);
    return myInput.value.trim() === '';
}