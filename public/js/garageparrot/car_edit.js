//Permet de remplir les input avec une valeur quelquonque. Utile si l'on a cliqué sur le bouton nouveau et que l'on veut annuler. 

function retour() {        
    setInputValue('list_carEdit_brand', '_');
    setInputValue('list_carEdit_model', '_');
    setInputValue('list_carEdit_engine', '_');
    setInputValue('txt_carEdit_year', '2024');
    setInputValue('txt_carEdit_mileage', '0');
    setInputValue('txt_carEdit_price', '0');
    setInputValue('list_carEdit_sold', 'Oui');
    setInputValue('list_carEdit_option', 'option');
    setInputValue('txt_carEdit_image1', '_.webp');
    setInputValue('txt_carEdit_image2', '_.webp');
    setInputValue('txt_carEdit_image3', '_.webp');
    setInputValue('txt_carEdit_image4', '_.webp');
    setInputValue('txt_carEdit_image5', '_.webp');

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
    var myInput = document.getElementById('list_carEdit_brand');
    myInput.style.backgroundColor = '#DADADA';
    var myInput = document.getElementById('list_carEdit_model');
    myInput.style.backgroundColor = '#DADADA';
    var myInput = document.getElementById('list_carEdit_engine');
    myInput.style.backgroundColor = '#DADADA';
    var myInput = document.getElementById('list_carEdit_sold');
    myInput.style.backgroundColor = '#DADADA';
});

//vérifier si la valeur saisie existe dans la liste de choix
function validateInput(input , datalist, myLabel, myMessage){
    
    var myInput = document.getElementById(input);
    var errorMessage = document.getElementById(myLabel);
    var isError = false;

    if(datalist!=''){
        
        var myDatalist = document.getElementById(datalist);

        var isValid = Array.from(myDatalist.options).some(function(option) {
            return option.value === myInput.value;
        });

        if(!isValid){isError = true;}

    }else if(myInput.value.trim() === ''){
        
        isError = true;

    }else{

        if(input === 'txt_carEdit_year'){

            var isValidNumber = /^\d{4}$/.test(myInput.value);
            if(!isValidNumber){isError = true;}

        }else if(input === 'txt_carEdit_price' || input === 'txt_carEdit_mileage'){

            var isValidNumber = /^\d+$/.test(myInput.value);
            if(!isValidNumber){isError = true;}

        }else if(input === 'txt_carEdit_image1' ||
                input === 'txt_carEdit_image2' ||
                input === 'txt_carEdit_image3' ||
                input === 'txt_carEdit_image4' ||
                input === 'txt_carEdit_image5'){
            
            var isValidExtension = /\.(png|jpg|webp)$/i.test(myInput.value);
            var isValidCharacters = /^[a-zA-Z0-9_\-\.]+$/.test(myInput.value);

            if (!isValidExtension || !isValidCharacters){
                isError = true;
            }
        }
    }

    if(isError){

        errorMessage.textContent = myMessage;
        errorMessage.style.color = 'red';
        myInput.style.background = '#FFB4B4';
        return false;

    }else{

        errorMessage.textContent = myMessage;
        errorMessage.style.color = '#000000';
        
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

document.getElementById('formCarEdit').addEventListener('submit', function (event) {

    var MessageBrand = "Selectionner une marque dans la liste de choix.";
    var MessageModel = "Selectionner un modèle dans la liste de choix.";
    var MessageEngine = "Selectionner une engine dans la liste de choix.";
    var MessageYear = "Saisissez l'année (à 4 chiffres) de 1er mise en circulation.";
    var MessageMileage = "Saisissez le kilomètrage (uniquement des chiffres).";
    var MessagePrice = "Saisissez le prix (uniquement des chiffres).";
    var MessageSold = "Selectionnez Oui ou Non dans la liste de choix pour indiquer la disponibilité";
    var MessageImage1 = "Saisissez le nom de l'image (sans caractères spéciaux sauf - et _) aux formats png, jpg et webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image1 au ratio de 350px sur 180px.";
    var MessageImage = "Saisissez le nom de l'image (sans caractères spéciaux sauf - et _) aux formats png, jpg et webp. Sinon, téléchargez une image depuis votre disque local.";
    
    var isError = false;
    
    if (!validateInput('list_carEdit_brand', 'datalist_carEdit_brand', 'labelMessageBrand', MessageBrand)){
        isError = true;
    }
    
    if (!validateInput('list_carEdit_model', 'datalist_carEdit_model', 'labelMessageModel', MessageModel)){
        isError = true;
    }

    if (!validateInput('list_carEdit_engine', 'datalist_carEdit_engine', 'labelMessageEngine', MessageEngine)) {
        isError = true;
    }

    if (!validateInput('txt_carEdit_year', '', 'labelMessageYear', MessageYear)) {
        isError = true;
    }

    if (!validateInput('txt_carEdit_mileage', '', 'labelMessageMileage', MessageMileage)) {
        isError = true;
    }

    if (!validateInput('txt_carEdit_price', '', 'labelMessagePrice', MessagePrice)) {
        isError = true;
    }

    if (!validateInput('list_carEdit_sold', 'datalist_carEdit_sold', 'labelMessageSold', MessageSold)) {
        isError = true;
    }

    if (!validateInput('txt_carEdit_image1', '', 'labelMessageImage1', MessageImage1)) {
        isError = true;
    }

    if (!validateInput('txt_carEdit_image2', '', 'labelMessageImage2', MessageImage)) {
        isError = true;
    }

    if (!validateInput('txt_carEdit_image3', '', 'labelMessageImage3', MessageImage)) {
        isError = true;
    }

    if (!validateInput('txt_carEdit_image4', '', 'labelMessageImage4', MessageImage)) {
        isError = true;
    }

    if (!validateInput('txt_carEdit_image5', '', 'labelMessageImage5', MessageImage)) {
        isError = true;
    }
    
    var messageAlerte = 'Vous avez un ou plusieurs champs dont la valeur n\'est pas conforme. Veuillez vérifier et corriger le ou les champs concernés';
    
    if (isError === true){
        event.preventDefault();
        alert (messageAlerte)
        isError = false;
    }
});