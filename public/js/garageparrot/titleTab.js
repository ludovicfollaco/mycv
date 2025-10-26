let pageTitle = document.title;
let pageIcon = document.getElementById("pageIcon");
let pagePath = window.location.href;
let userPwResetNew = false;

let garageparrot =  pagePath === "http://mycv/garageparrot.php" ||
                    pagePath === "http://mycv/garageparrot.php?page=home" ||
                    pagePath === "https://follaco.fr/garageparrot.php" ||
                    pagePath === "https://follaco.fr/garageparrot.php?page=home";

let car = pagePath === "http://mycv/garageparrot.php?page=car" || pagePath === "https://follaco.fr/garageparrot.php?page=car";
let carEdit = pagePath === "http://mycv/garageparrot.php?page=carEdit" || pagePath === "https://follaco.fr/garageparrot.php?page=carEdit";
let user = pagePath === "http://mycv/garageparrot.php?page=user" || pagePath === "https://follaco.fr/garageparrot.php?page=user";
let userEdit = pagePath === "http://mycv/garageparrot.php?page=userEdit" || pagePath === "https://follaco.fr/garageparrot.php?page=userEdit";
let connexion = pagePath === "http://mycv/garageparrot.php?page=connexion" || pagePath === "https://follaco.fr/garageparrot.php?page=connexion";
let userPwRequestNew = pagePath === "http://mycv/garageparrot.php?page=userPwRequestNew" || pagePath === "https://follaco.fr/garageparrot.php?page=userPwRequestNew";
userPwResetNew = window.location.href.includes("userPwResetNew");

if (garageparrot){

    pageTitle = "Garage V.PARROT - Accueil - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/garage_75x75.webp";

} else if (user) {

    pageTitle = "Garage V.PARROT - contacts - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/garage_75x75.webp";

} else if (userEdit) {

    pageTitle = "Garage V.PARROT - Editer Contact - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/garage_75x75.webp";

} else if (car) {

    pageTitle = "Garage V.PARROT - Nos occasions - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/garage_75x75.webp";

} else if (carEdit) {

    pageTitle = "Garage V.PARROT - Editer occasion - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/garage_75x75.webp";

}else if(connexion){

    pageTitle = "Ludovic FOLLACO - Connexion";
    pageIcon.href = "img/common/icon/white_person.svg";

}else if(userPwRequestNew){

    pageTitle = "Ludovic FOLLACO - Demander nouveau mot de passe";
    pageIcon.href = "img/common/icon/white_person.svg";

}else if(userPwResetNew){

    pageTitle = "Ludovic FOLLACO - Enregistrer nouveau mot de passe";
    pageIcon.href = "img/common/icon/white_person.svg";

}

document.getElementById("pageTitle").innerText = pageTitle;