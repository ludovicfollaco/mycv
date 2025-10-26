/*********************************************************************************** */
// Function of sending data to the server with Fetch
/*********************************************************************************** */
function initFormDataHeader(button){
    
    const form = document.getElementById('formHome');
    let formData = new FormData(form);

    formData.append(button, document.querySelector('input[name="' + button + '"]').value);

    formData.append('csrf', document.querySelector('input[name="csrf"]').value);

    formData.append('text_home_title', document.querySelector('input[name="text_home_title"]').value);
    formData.append('text_home_subtitle', document.querySelector('input[name="text_home_subtitle"]').value);

    formData.append('text_home_title_page', document.querySelector('input[name="text_home_title_page"]').value);

    formData.append('text_home_article1_title', document.querySelector('input[name="text_home_article1_title"]').value);
    formData.append('textarea_home_article1', document.querySelector('textarea[name="textarea_home_article1"]').value);
    formData.append('text_home_article1_img', document.querySelector('input[name="text_home_article1_img"]').value);
    
    formData.append('text_home_article2_title', document.querySelector('input[name="text_home_article2_title"]').value);
    formData.append('textarea_home_article2', document.querySelector('textarea[name="textarea_home_article2"]').value);
    formData.append('text_home_article2_img', document.querySelector('input[name="text_home_article2_img"]').value);


    sendDataOfHome(formData);

}


function initFormDataHome(button){

    const form = document.getElementById('formHome');
    let formData = new FormData(form);

    formData.append(button, document.querySelector('input[name="' + button + '"]').value);

    formData.append('csrf', document.querySelector('input[name="csrf"]').value);

    formData.append('text_home_title', document.querySelector('input[name="text_home_title"]').value);
    formData.append('text_home_subtitle', document.querySelector('input[name="text_home_subtitle"]').value);

    formData.append('text_home_title_page', document.querySelector('input[name="text_home_title_page"]').value);

    formData.append('text_home_article1_title', document.querySelector('input[name="text_home_article1_title"]').value);
    formData.append('textarea_home_article1', document.querySelector('textarea[name="textarea_home_article1"]').value);
    formData.append('text_home_article1_img', document.querySelector('input[name="text_home_article1_img"]').value);
    
    formData.append('text_home_article2_title', document.querySelector('input[name="text_home_article2_title"]').value);
    formData.append('textarea_home_article2', document.querySelector('textarea[name="textarea_home_article2"]').value);
    formData.append('text_home_article2_img', document.querySelector('input[name="text_home_article2_img"]').value);

    sendDataOfHome(formData);

}

function sendDataOfHome(myFormData){

    let formData = myFormData;

    // Envoyer les données au serveur
    sendDataToServer('index.php?page=home', formData) // Function in file fetch.js
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

initMessageSave('text_home_title_page');

initMessageSave('text_home_article1_title');
initMessageSave('textarea_home_article1');
initMessageSave('file_home_article1_img');

initMessageSave('text_home_article2_title');
initMessageSave('textarea_home_article2');
initMessageSave('file_home_article2_img');

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
let buttonSave = document.getElementById('btn_home_save');
//let buttonElement = document.getElementById('btn_home_save').addEventListener('click', function (event);
if(buttonSave){

    buttonSave.addEventListener('click', function (event) {
        
    //document.getElementById('btn_home_save').addEventListener('click', function (event) {
        
        //console.log('btn_home_save');

        let isError = false;

        if (!validateInput('text_home_title_page')) {
            isError = true;
        }
        if (!validateInput('text_home_article1_title')) {
            isError = true;
        }
        if (!validateInput('textarea_home_article1')) {
            isError = true;
        }
        if (!validateInput('text_home_article1_img')) {
            isError = true;
        }
        if (!validateInput('text_home_article2_title')) {
            isError = true;
        }
        if (!validateInput('textarea_home_article2')) {
            isError = true;
        }
        if (!validateInput('text_home_article2_img')) {
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
            
            initFormDataHome('btn_home_save');

        }

    });
    
    let buttonSaveHeader = document.getElementById('btn_save_header');
    if(buttonSaveHeader){

        buttonSaveHeader.addEventListener('click', function (event) {
            
            initFormDataHeader('btn_save_header');

        });

    }
}