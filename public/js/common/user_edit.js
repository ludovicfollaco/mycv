//Permet de remplir les input avec une valeur quelquonque. Utile si l'on a cliqué sur le bouton nouveau et que l'on veut annuler. 

    function retour() {        
        setInputValue('txt_userEdit_name', 'Ton Nom');
        setInputValue('txt_userEdit_surname', 'Ton Prénom');
        setInputValue('txt_userEdit_pseudo', 'Ton pseudo');
        setInputValue('txt_userEdit_email', 'user@gmail.com');
        setInputValue('txt_userEdit_phone', '00 00 00 00 00');
        setInputValue('list_userEdit_type', 'User');
        setInputValue('txt_userEdit_password', 'Abcd123456/*-');
        setInputValue('txt_userEdit_confirm', 'Abcd123456/*-');

        return;
    }
    function setInputValue(inputId, value) {
        const monInput = document.getElementById(inputId);
        if (monInput) {
            monInput.value = value;
        }
    }

    //Initialise les couleurs input list
    document.addEventListener('DOMContentLoaded', function() {
        let myInput = document.getElementById('list_userEdit_type');
        myInput.style.backgroundColor = '#DADADA';
    });

    //vérifier si la valeur saisie existe dans la liste de choix
    function validateInput(input , datalist, myLabel, myMessage){
        
        let myInput = document.getElementById(input);
        let errorMessage = document.getElementById(myLabel);
        let isError = false;
        
        if(datalist!=''){
            
            let myDatalist = document.getElementById(datalist);

            let isValid = Array.from(myDatalist.options).some(function(option) {
                return option.value === myInput.value;
            });

            if(!isValid){isError = true;}

        }else if(myInput.value.trim() === ''){
            
            isError = true;

        }else if(input === 'txt_userEdit_pseudo'){
            
            let pseudoInput = document.getElementById(input).value;

            // Vérifier que le nombre de caractères est ente 4 et 20
            if (pseudoInput.length > 3 && pseudoInput.length < 21) {
                isError=false;
            }else{
                isError=true;
            }

        }else if(input === 'txt_userEdit_password'){

            let passwordInput = document.getElementById(input).value;
            let passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\/\*\-\.\!\?\@])[A-Za-z\d\/\*\-\.\!\?\@]{13,}$/;
            if(passwordRegex.test(passwordInput)){
                isError=false;
            }else{
                isError=true;
            }
            
        }else if(input === 'txt_userEdit_confirm'){

            let password = document.getElementById('txt_userEdit_password').value;
            let passwordConfirm = document.getElementById(input).value;

            if(passwordConfirm === password){
                isError=false;
                console.log(isError);
            }
            else{
                isError=true;
                console.log(isError);
            }
        }

        if(isError){

            errorMessage.textContent = myMessage;
            errorMessage.style.color = 'red';
            myInput.style.background = '#FFB4B4';
            return false;

        }else{

            errorMessage.textContent = myMessage;
            errorMessage.style.color = '#ffffff';
            
            if(datalist!=''){
                myInput.style.background = '#DADADA';
            }else{
                myInput.style.background = '#ffffff';
            }

            return true;
        }
    }

    /*********************************************************************************************
    ****** Annuler la soumission du formulaire si une erreur subsiste dans l'un des champs *******
    *********************************************************************************************/

    document.getElementById('formUserEdit').addEventListener('submit', function (event) {

        let MessageName = "Saisissez le Nom (50 caractères maximum).";
        let MessageSurname = "Saisissez le Prénom (50 caractères maximum).";
        let MessagePseudo = "Saisissez le pseudonyme (20 caractères maximum).";
        let MessageEmail = "Saisissez l'adresse email (255 caractères maximum).";
        let MessagePhone = "Saisissez le N° de téléphone.";
        let MessageType = "Selectionnez le type d'utilisateur dans la liste de choix.";
        let MessagePassword = "Saisissez un mot de passe de 255 caractères maximum et 8 caractères minimun comprenant au moins : 1 minuscule, 1 majuscule, 1 chiffre et 1 caractère spéciale parmi les suivants /*-.!?@";
        
        let isError = false;
        
        if (!validateInput('txt_userEdit_name', '', 'labelMessageName', MessageName)){
            isError = true;
        }
        
        if (!validateInput('txt_userEdit_surname', '', 'labelMessageSurname', MessageSurname)){
            isError = true;
        }

        if (!validateInput('txt_userEdit_pseudo', '', 'labelMessagePseudo', MessagePseudo)) {
            isError = true;
        }

        if (!validateInput('txt_userEdit_email', '', 'labelMessageEmail', MessageEmail)) {
            isError = true;
        }

        if (!validateInput('txt_userEdit_phone', '', 'labelMessagePhone', MessagePhone)) {
            isError = true;
        }

        if (!validateInput('list_userEdit_type', 'datalist_userEdit_type', 'labelMessageType', MessageType)) {
            isError = true;
        }

        if (!validateInput('txt_userEdit_password', '', 'labelMessagePassword', MessagePassword)) {
            isError = true;
        }

        if (!validateInput('txt_userEdit_confirm', '', 'labelMessageConfirm', MessagePassword)) {
            isError = true;
        }

        let messageAlerte = 'Vous avez un ou plusieurs champs dont la valeur n\'est pas conforme. Veuillez vérifier et corriger le ou les champs concernés';
        
        if (isError === true){
            event.preventDefault();
            alert (messageAlerte)
            isError = false;
        }
    });