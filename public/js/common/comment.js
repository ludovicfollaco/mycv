/**************************************************************************** */
// Event if button save of form is clicked
/**************************************************************************** */

document.addEventListener('DOMContentLoaded', function() {

    const commentActions = document.querySelectorAll('.comment-action');

    commentActions.forEach(function(actionButton){

        actionButton.addEventListener('click', function(event) {

            const id = this.getAttribute('data-comment-id');
            const btn = this.getAttribute('data-action');

            sendDataOfComment(btn,id);

        });
    });
});

/*********************************************************************************** */
// Function of sending data to the server with Fetch
/*********************************************************************************** */

function sendDataOfComment(button, id = ''){

    let formData = new FormData();

    formData.append(button, button);
    formData.append('csrf', document.querySelector('input[name="csrf"]').value);
    formData.append('txt_comment_id', id);

    if(button === 'bt_save_comment'){
        
        formData.append('txt_comment_pseudo', document.querySelector('input[name="txt_comment_pseudo"]').value);
        formData.append('selectedRating', document.querySelector('input[name="selectedRating"]').value);
        formData.append('txt_comment_comment', document.querySelector('textarea[name="txt_comment_comment"]').value);

    }

    if(button === 'bt_save_comment' && validateInput('txt_comment_comment')){

        sendDataToServer('', formData)
        .then(response => {

            document.getElementById('txt_comment_comment').value = '';
            alert("Le message a été transmi au modérateur pour validation avant publication.");
            console.log(response);

        })
        .catch(error => {
    
            if(button === 'bt_save_comment'){
    
                document.getElementById('txt_comment_comment').value = '';
                alert("Il c'est produit une erreur, le message n'a pas été transmis.");
    
            }
    
            console.error('Erreur :', error);
    
        });

    }else if(button === 'bt_comment_validate'){
        
        sendDataToServer('', formData)
        .then(response => {

            if(document.getElementById('stateComment_' + id).value != 'Etat : Supprimé'){

                document.getElementById('stateComment_' + id).value = 'Etat : Validé';

                let element = document.getElementById('stateComment_' + id);
                element.classList.remove('bg-info','bg-success','bg-danger','bg-warning');
                element.classList.add('bg-success');
            }

        })
        .catch(error => {
    
            console.error('Erreur :', error);
    
        });

    }else if(button === 'bt_comment_refuse'){
        
        sendDataToServer('', formData)
        .then(response => {

            if(document.getElementById('stateComment_' + id).value != 'Etat : Supprimé'){
                
                document.getElementById('stateComment_' + id).value = 'Etat : Refusé';

                let element = document.getElementById('stateComment_' + id);
                element.classList.remove('bg-info','bg-success','bg-danger','bg-warning');
                element.classList.add('bg-warning');
            }

        })
        .catch(error => {
    
            console.error('Erreur :', error);
    
        });
        
    }else if(button === 'bt_comment_delete'){

        sendDataToServer('', formData)
        .then(response => {

            document.getElementById('stateComment_' + id).value = 'Etat : Supprimé';

            let element = document.getElementById('stateComment_' + id);
            element.classList.remove('bg-info','bg-success','bg-danger','bg-warning');
            element.classList.add('bg-danger');

            returnUrl();
            return;

        })
        .catch(error => {
    
            console.error('Erreur :', error);
    
        });

    }
}

function returnUrl(){
                
    let valeurSession = document.getElementById('txt_local').value;

    let currentURL = window.location.href;
    let goldorak = "/goldorak";
    let garageParrot = "/garageparrot";
    
    console.log('valeurSession = ' + valeurSession);
    console.log(currentURL.search(goldorak));
    console.log(currentURL.search(garageParrot));

    if (valeurSession === "1"){
        if(currentURL.search(goldorak) !== -1){

            window.location.href = "http://mycv/goldorak.php?page=home";

        }else if(currentURL.search(garageParrot) !== -1){
            
            window.location.href = "http://mycv/garageparrot.php?page=home";

        }else{
            
            window.location.href = "http://mycv/index.php?page=home";

        }

    }else{

        if(currentURL.search(goldorak) !== -1){

            window.location.href = "https://www.follaco.fr/goldorak.php?page=home";

        }else if(currentURL.search(garageParrot) !== -1){
            
            window.location.href = "https://www.follaco.fr/garageparrot.php?page=home";

        }else{
            
            window.location.href = "https://www.follaco.fr/index.php?page=home";

        }

    }
}

/**************************************************************************** */
// checking input and Changing background if the content is empty
/**************************************************************************** */

function validateInput(input){

    const myInput = document.getElementById(input);

    let isError = false;
    
    if(verifInputEmpty(input)){

        isError = true;
        
    }

    if(isError){
        console.log('validateInput' + input + ' = false');
        myInput.style.background = '#FFB4B4';
        return false;

    }else{
        console.log('validateInput' + input + ' = true');
        myInput.style.background = '#ffffff';
        return true;
    }
}

function verifInputEmpty(input){
    
    const myInput = document.getElementById(input);
    
    if(myInput.value.trim() === ''){
        
        return true;

    }else{
        
        return false;

    }

}