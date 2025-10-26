let pageTitle = document.title;
let pageIcon = document.getElementById("pageIcon");
let pagePath = window.location.href;
let userPwResetNew = false;

let goldorak =  pagePath === "http://mycv/goldorak.php" ||
                pagePath === "http://mycv/goldorak.php?page=home" ||
                pagePath === "https://follaco.fr/goldorak.php" ||
                pagePath === "https://follaco.fr/goldorak.php?page=home";

let events = pagePath === "http://mycv/goldorak.php?page=events" || pagePath === "https://follaco.fr/goldorak.php?page=events";
let adhere = pagePath === "http://mycv/goldorak.php?page=adhere" || pagePath === "https://follaco.fr/goldorak.php?page=adhere";
let media = pagePath === "http://mycv/goldorak.php?page=media" || pagePath === "https://follaco.fr/goldorak.php?page=media";
let goldorakgo = pagePath === "http://mycv/goldorak.php?page=goldorakgo" || pagePath === "https://follaco.fr/goldorak.php?page=goldorakgo";
let commander = pagePath === "http://mycv/goldorak.php?page=commander" || pagePath === "https://follaco.fr/goldorak.php?page=commander";
let user = pagePath === "http://mycv/goldorak.php?page=user" || pagePath === "https://follaco.fr/goldorak.php?page=user";
let userEdit = pagePath === "http://mycv/goldorak.php?page=userEdit" || pagePath === "https://follaco.fr/goldorak.php?page=userEdit";
let connexion = pagePath === "http://mycv/goldorak.php?page=connexion" || pagePath === "https://follaco.fr/goldorak.php?page=connexion";
let userPwRequestNew = pagePath === "http://mycv/goldorak.php?page=userPwRequestNew" || pagePath === "https://follaco.fr/goldorak.php?page=userPwRequestNew";
userPwResetNew = window.location.href.includes("userPwResetNew");

if (goldorak){

    pageTitle = "Club Goldorak - Accueil - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/icone_goldorak_01.webp";

}else if (userEdit){

    pageTitle = "Club Goldorak - Editer utilisateurs - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/icone_goldorak_01.webp";

}else if (user){

    pageTitle = "Club Goldorak - Utilisateurs - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/icone_goldorak_01.webp";

}else if (adhere){
    
    pageTitle = "Club Goldorak - Produits - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/icone_goldorak_01.webp";

}else if (events){

    pageTitle = "Club Goldorak - Evénements - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/icone_goldorak_01.webp";

}else if (media){

    pageTitle = "Club Goldorak - Médias - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/icone_goldorak_01.webp";

}else if (goldorakgo){

    pageTitle = "Club Goldorak - Goldorak Go! - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/icone_goldorak_01.webp";

}else if (commander){

    pageTitle = "Club Goldorak - My Commander! - by Ludovic Follaco";
    pageIcon.href = "img/common/icon/icone_goldorak_01.webp";

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