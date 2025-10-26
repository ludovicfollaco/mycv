document.addEventListener("DOMContentLoaded", function() {
    const consentDuration = 1 * 24 * 60 * 60 * 1000; // 1 jours en millisecondes
    const lastConsentDate = localStorage.getItem("lastConsentDate");
    const currentDate = new Date().getTime();

    if (!lastConsentDate || (currentDate - lastConsentDate) > consentDuration) {
        document.getElementById("cookieConsent").style.display = "block";
    }

    document.getElementById("acceptCookies").addEventListener("click", function() {
        localStorage.setItem("cookiesAccepted", "true");
        localStorage.setItem("lastConsentDate", currentDate);
        document.getElementById("cookieConsent").style.display = "none";
    });

    document.getElementById("refuseCookies").addEventListener("click", function() {
        localStorage.setItem("cookiesRefused", "true");
        localStorage.setItem("lastConsentDate", currentDate);
        deleteAllCookies();
        document.getElementById("cookieConsent").style.display = "none";
    });

    if (localStorage.getItem("cookiesRefused") && (currentDate - lastConsentDate) <= consentDuration) {
        deleteAllCookies();
    }
});

function deleteAllCookies() {
    const cookies = document.cookie.split(";");

    cookies.forEach(function(cookie) {
        const name = cookie.split("=")[0].trim();
        console.log("Deleting cookie:", name);

        // Supprimer le cookie pour le chemin actuel
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;domain=" + window.location.hostname;
        
        // Supprimer le cookie pour le chemin racine
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;domain=" + window.location.hostname;
    });
}