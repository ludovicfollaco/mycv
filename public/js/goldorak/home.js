/*********************************************************************************** */
// Click event button image
/*********************************************************************************** */

clickEvent('btn_img_chapter1','file_img_chapter1','img_chapter1', 'txt_img_chapter1');
clickEvent('btn_img_chapter2','file_img_chapter2','img_chapter2', 'txt_img_chapter2');

function clickEvent(button, inputFile = '', inputImage = '', inputTxt = ''){

    let buttonElement = document.getElementById(button);

    if(buttonElement){

        buttonElement.addEventListener('click', function(event) {

            event.preventDefault();

            if(inputFile != '' && inputImage != ''){
                changePicture(inputFile, inputImage);
                document.getElementById(inputTxt).value = document.getElementById(inputFile).files[0].name;
            }

        });

    }

}

function changePicture(nameInputFile, idImage) {
    let inputElement = document.getElementById(nameInputFile);
    let files = inputElement.files;

    if(files[0].name != ''){
        let imgElement = document.getElementById(idImage);
        let nouveauChemin = 'img/goldorak/picture/' + files[0].name;
        imgElement.src = nouveauChemin;
    }
}

/*********************************************************************************** */
// Function of sending data to the server with Fetch
/*********************************************************************************** */

function sendDataOfHome(button){

    let formData = new FormData();

    formData.append(button, document.querySelector('input[name="' + button + '"]').value);

    formData.append('csrf', document.querySelector('input[name="csrf"]').value);

    formData.append('txt_titre1', document.querySelector('input[name="txt_titre1"]').value);

    formData.append('txt_titre_chapter1', document.querySelector('input[name="txt_titre_chapter1"]').value);
    formData.append('txt_chapter1', document.querySelector('textarea[name="txt_chapter1"]').value);
    formData.append('txt_img_chapter1', document.querySelector('input[name="txt_img_chapter1"]').value);
    
    formData.append('txt_titre_chapter2', document.querySelector('input[name="txt_titre_chapter2"]').value);
    formData.append('txt_chapter2', document.querySelector('textarea[name="txt_chapter2"]').value);
    formData.append('txt_img_chapter2', document.querySelector('input[name="txt_img_chapter2"]').value);

    // Envoyer les données au serveur
    sendDataToServer('goldorak.php?page=home', formData) // Function in file fetch.js
    .then(response => {
        //if (response.ok) {
        const messageAlerte = 'Enregistrement effectué avec succès!';

        document.getElementById('message').innerText = messageAlerte;
        document.getElementById('messageInputEmpty1').innerText = messageAlerte;
        document.getElementById('messageInputEmpty2').innerText = messageAlerte;
        //}
    })
    .catch(error => {

        const messageAlerte1 = 'Une erreur s\'est produite lors de l\'enregistrement.';

        document.getElementById('message').innerText = messageAlerte1;
        document.getElementById('messageInputEmpty1').innerText = messageAlerte1;
        document.getElementById('messageInputEmpty2').innerText = messageAlerte1;

        console.error('Erreur :', error);

    });

}

/**************************************************************************** */
// initalized zone message (save and content error)
/**************************************************************************** */

initMessageSave('txt_titre1');
initMessageSave('txt_titre_chapter1');
initMessageSave('txt_chapter1');
initMessageSave('file_img_chapter1');
initMessageSave('txt_img_chapter1');
initMessageSave('txt_titre_chapter2');
initMessageSave('txt_chapter2');
initMessageSave('file_img_chapter2');
initMessageSave('txt_img_chapter2');

function initMessageSave(input){

    let inputElement = document.getElementById(input);

    if(inputElement){

        inputElement.addEventListener('input', function() {
    
            document.getElementById('message').innerText = '';
            document.getElementById('messageInputEmpty1').innerText = '';
            document.getElementById('messageInputEmpty2').innerText = '';
    
        });
    }

}

/**************************************************************************** */
// Event if button save of form is clicked
/**************************************************************************** */
let buttonElement = document.getElementById('btn_home_save');
if(buttonElement){

    buttonElement.addEventListener('click', function (event) {
        
        console.log('btn_home_save');

        let isError = false;

        if (!validateInput('txt_titre1')) {
            isError = true;
        }
        if (!validateInput('txt_titre_chapter1')) {
            isError = true;
        }
        if (!validateInput('txt_chapter1')) {
            isError = true;
        }
        if (!validateInput('txt_titre_chapter2')) {
            isError = true;
        }
        if (!validateInput('txt_chapter2')) {
            isError = true;
        }
        if (!validateInput('txt_img_chapter2')) {
            isError = true;
        }

        const messageAlerte = 'Vous avez un ou plusieurs champs dont la valeur n\'est pas conforme. Veuillez Corriger le ou les champs concernés marqués d\'un fond rose.';
        
        if (isError === true){

            event.preventDefault();
            
            document.getElementById('message').innerText = messageAlerte;
            document.getElementById('messageInputEmpty1').innerText = messageAlerte;
            document.getElementById('messageInputEmpty2').innerText = messageAlerte;

            isError = false;

        }else{

            sendDataOfHome('btn_home_save');

        }

    });
}