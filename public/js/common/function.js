function setInputValue(inputId, value) {

    const monInput = document.getElementById(inputId);

    if (monInput) {

        monInput.value = value;

    }

}

function veriList(input , datalist){

    let myInput = document.getElementById(input);
    let myDatalist = document.getElementById(datalist);

    let isValid = Array.from(myDatalist.options).some(function(option) {
        return option.value === myInput.value;
    });

    if(isValid){
        return true;
    }else{
        return false;
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
        
    }else if(input === 'txt_userEdit_name'){
        
        if(!checkNumberOfChar(input, 1, 50)){

            isError = true;

        }

    }else if(input === 'txt_userEdit_surname'){
        
        if(!checkNumberOfChar(input, 1, 50)){

            isError = true;

        }

    }else if(input === 'txt_userEdit_pseudo'){

        const regex = /^[a-zA-Z0-9#_]+$/;

        if (!regex.test(myInput.value)) {
            
            isError = true;
    
        }else if(!checkNumberOfChar(input, 4, 20)){

            isError = true;

        }

    }else if(input === 'txt_userEdit_email'){
        
        if(!checkNumberOfChar(input, 6, 255)){

            isError = true;

        }

    }else if(input === 'txt_userEdit_phone'){
        
        if(!checkNumberOfChar(input, 6, 18)){

            isError = true;

        }

    }else if(input === 'txt_userEdit_password'){

        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[-_/*@!])(?=.*\d)[a-zA-Z0-9_\-/*@!]*$/;

        if(!checkNumberOfChar(input, 8, 255)){

            isError = true;

        }else if (!regex.test(myInput.value)) {
            
            isError = true;

        }

    }else if(input === 'txt_userEdit_confirm'){
        
        if(!compareValueInput('txt_userEdit_confirm', 'txt_userEdit_password')){

            isError = true;

        }

    }

    if(isError){

        myInput.style.background = '#FFB4B4';
        return false;

    }else{

        myInput.style.background = '#ffffff';
        return true;

    }

}

/**************************************************************************** */
// Checking if input is empty, return true if empty
/**************************************************************************** */

function verifInputEmpty(input){
    
    const myInput = document.getElementById(input);
    
    if(myInput.value.trim() === ''){
        
        return true;

    }else{
        
        return false;

    }

}

/**************************************************************************** */
// Checking password syntaxe 
/**************************************************************************** */

function verifPassword(input){

    const passwordInput = document.getElementById(input).value.trim();

    // Vérifier que la longueur est de 8 caractères
    /*if (passwordInput.length < 8 || passwordInput.length > 255) {
        //alert("Le mot de passe doit contenir au moins 8 caractères et 255 caratères maximulm
        return false;

    }*/
    
    // Vérifier que la longueur est de 8 caractères
    /*if(!checkNumberOfChar(input, 8, 255)){
        return false;
    }*/

    //Vérifier au moins une majuscule, une minuscule, un chiffre, et un caractère spécial
    const regex =   /^(?=.*[a-z])(?=.*[A-Z])(?=.*[-_/*@!])(?=.*\d)[a-zA-Z0-9_\-/*@!]*$/;


    
    if (!regex.test(passwordInput)) {
        //alert("Le mot de passe doit contenir au moins 8 caractères dont au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial parmi les suivants (_-/*-@!)");
        return false;

    }

    return true;

}

/**************************************************************************** */
// checking of number of charactere
/**************************************************************************** */

function checkNumberOfChar(input, minChar = 8, maxChar = 255){

    const valueInput = document.getElementById(input).value;

    // Vérifier que la longueur est de 8 caractères
    if (valueInput.length < minChar || valueInput.length > maxChar) {
        //alert("Le mot de passe doit contenir au moins 8 caractères et 255 caratères maximulm
        return false;

    }

    return true;

}

/**************************************************************************** */
// compare value 2 inputs is return true if same
/**************************************************************************** */

function compareValueInput(input1, input2){

    const value1 = document.getElementById(input1).value;
    const value2 = document.getElementById(input2).value;

    console.log('valeur1 = ', value1);
    console.log('valeur2 = ', value2);

    if(value1 === value2){

        return true;

    }
    else{

        return false;

    }

}