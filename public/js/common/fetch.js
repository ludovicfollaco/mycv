function sendDataToServer(url, data){
    
    return fetch(url, {

        method: 'POST',
        body: data

    })
    .then(response => {
        /*
        if (!response.ok){

            throw new Error('Une erreur s\'est produite lors de la requête.');

        }

        return response.text();
        */
        if (!response.ok){
                return response.text().then(error => {
                throw new Error(error);

            });
        }
        return response.text();

    })
    .then(data => {

        //console.log('Réponse du serveur :', data);
        return data;

    })
    .catch(error => {

        //console.error('Erreur :', error);
        throw error;

    });
}