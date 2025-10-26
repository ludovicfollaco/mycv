let pageTitle = document.title;
let pageIcon = document.getElementById("pageIcon");
let pagePath = window.location.href;
let userPwResetNew = false;

let index = pagePath === "http://mycv/" ||
            pagePath === "http://mycv/index.php" ||
            pagePath === "http://mycv/index.php?page=home" ||
            pagePath === "https://follaco.fr" ||
            pagePath === "https://follaco.fr/index.php" ||
            pagePath === "https://follaco.fr/index.php?page=home";

let mycv = pagePath === "http://mycv/index.php?page=mycv" || pagePath === "https://follaco.fr/index.php?page=mycv";
let actuPresse = pagePath === "http://mycv/index.php?page=actuPresse" || pagePath === "https://follaco.fr/index.php?page=actuPresse";
let connexion = pagePath === "http://mycv/index.php?page=connexion" || pagePath === "https://follaco.fr/index.php?page=connexion";
let userPwRequestNew = pagePath === "http://mycv/index.php?page=userPwRequestNew" || pagePath === "https://follaco.fr/index.php?page=userPwRequestNew";
userPwResetNew = window.location.href.includes("userPwResetNew");

if (index){

    pageTitle = "Ludovic FOLLACO - Ingénieur produit, Développeur web et web mobile";
    pageIcon.href = "img/common/icon/white_house.svg";

}else if(mycv){

    pageTitle = "Ludovic FOLLACO - Mon Parcours, Mes Compétences, Mes Projets, Mon CV";
    pageIcon.href = "img/common/icon/white_calendar2-event.svg";

}else if(actuPresse){

    pageTitle = "Ludovic FOLLACO - La presse en parle, actualités, news, prix de l'entrepreneur GPS&O";
    pageIcon.href = "img/common/icon/news_white.svg";

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