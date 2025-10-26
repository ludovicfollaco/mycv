<?php require_once('../controller/garageparrot/car.controller.php'); ?>

<section class="m-5 d-flex flex-wrap justify-content-center" id="carSection"></section>

<script>

    // Fonction pour créer un article pour chaque voiture
    function createCarArticle(car, index) {
        const article = document.createElement('article');
        article.className = 'mb-5 p-3 border rounded-4';

        const form = document.createElement('form');
        form.action = '/index.php?page=carEdit';
        form.method = 'post';

        const divCarImg = document.createElement('div');
        divCarImg.className = 'd-flex justify-content-center div__Car--img';

        const images = [car.image1, car.image2, car.image3, car.image4, car.image5];

        let myImage = true;

        images.forEach((image) => {
            if (image && myImage) {
                const a = document.createElement("a");
                a.href = '../img/garageparrot/vehicle/' + image;
                a.className = 'popup-gallery';
                a.setAttribute('data-fancybox', 'car-gallery-' + index);

                const img = document.createElement("img");
                img.src = '../img/garageparrot/vehicle/' + image;
                img.alt = "Image du véhicule";
                img.style.width = "350px";

                a.appendChild(img);
                divCarImg.appendChild(a);

                myImage = false;
            } else if (image) {
                const a_ = document.createElement("a");
                a_.href = '../img/garageparrot/vehicle/' + image;
                a_.className = 'popup-gallery';
                a_.setAttribute('data-fancybox', 'car-gallery-' + index);
                divCarImg.append(a_);
            }
        });

        form.append(divCarImg);

        const divCarData = document.createElement('div');
        divCarData.className = 'div__Car--data';

        const table = document.createElement('table');
        table.className = 'table__Car--data';

        const carFields = [
            { label: 'ID:', id: 'id', name: 'txt_carEdit_id', value: car.id_car, type: 'text', class: 'bgDark text-light text-start ps-2', readonly: true },
            { label: 'Marque:', id: 'brand', name: 'txt__Car--Brand', value: car.brand, type: 'text', class: 'bg-secondary text-light text-start ps-2', readonly: true },
            { label: 'Modèle:', id: 'model', name: 'txt__Car--Model', value: car.model, type: 'text', class: 'bg-secondary text-light text-start ps-2', readonly: true },
            { label: 'Moteur:', id: 'engine', name: 'txt__Car--Engine', value: car.engine, type: 'text', class: 'bg-secondary text-light text-start ps-2', readonly: true },
            { label: 'Année:', id: 'year', name: 'txt__Car--year', value: car.year, type: 'text', class: 'bg-secondary text-light text-start ps-2', readonly: true },
            { label: 'Kilomètrage:', id: 'mileage', name: 'txt__Car--mileage', value: `${car.mileage} kms`, type: 'text', class: 'bg-secondary text-light text-start ps-2', readonly: true },
            { label: 'Prix:', id: 'price', name: 'txt__Car--price', value: `${car.price} € TTC`, type: 'text', class: 'bg-secondary text-light text-start ps-2', readonly: true },
            { label: 'Disponible:', id: 'sold', name: 'txt__Car--sold', value: car.sold, type: 'text', class: 'bg-secondary text-light text-start ps-2', readonly: true },
            { label: 'Description:', id: 'description', name: 'txt__Car--description', value: car.description, type: 'textarea', class: 'bg-secondary text-light text-start ps-2', readonly: true }
        ];

        carFields.forEach(field => {
            const tr = document.createElement('tr');

            const tdLabel = document.createElement('td');
            tdLabel.className = 'tdLabel text-end border border-0 pe-1';
            tdLabel.textContent = field.label;

            const tdText = document.createElement('td');
            tdText.className = 'tdText border border-0';

            let input;
            if (field.type === 'textarea') {
                input = document.createElement('textarea');
                input.rows = 3;
                input.placeholder = 'Options et description';
                input.value = field.value;
            } else {
                input = document.createElement('input');
                input.type = field.type;
                input.value = field.value;
            }

            input.id = field.id;
            input.name = field.name;
            input.className = field.class;
            if (field.readonly) {
                input.readOnly = true;
            }

            tdText.appendChild(input);
            tr.appendChild(tdLabel);
            tr.appendChild(tdText);
            table.appendChild(tr);
        });

        divCarData.appendChild(table);
        form.appendChild(divCarData);

        <?php if ($_SESSION['dataConnect']['type'] != 'Guest') { ?>
            const editButtonDiv = document.createElement('div');
            editButtonDiv.className = 'd-flex justify-content-center my-2';

            const editButton = document.createElement('button');
            editButton.type = 'submit';
            editButton.className = 'btn btn-primary fs-3 mt-3';
            editButton.id = 'bt__Car--edit';
            editButton.name = 'bt__Car--edit';
            editButton.textContent = 'Editer';

            editButtonDiv.appendChild(editButton);
            form.appendChild(editButtonDiv);
        <?php } ?>

        <?php if ($_SESSION['dataConnect']['type'] === 'Guest') { ?>
            const contactButtonDiv = document.createElement('div');
            contactButtonDiv.className = 'd-flex justify-content-center my-2';

            const contactButton = document.createElement('button');
            contactButton.type = 'button';
            contactButton.className = 'btn btn-lg btn-primary';
            contactButton.id = 'bt_car_contact';
            contactButton.textContent = 'Nous contacter';
            contactButton.onclick = function() { focusOnInput(); };

            contactButtonDiv.appendChild(contactButton);
            form.appendChild(contactButtonDiv);
        <?php } ?>

        article.appendChild(form);
        return article;
    }

    // Fonction pour afficher les voitures
    function displayCars(cars) {
        const carSection = document.getElementById('carSection');
        carSection.innerHTML = '';
        cars.forEach((car, index) => {
            const carArticle = createCarArticle(car, index);
            carSection.appendChild(carArticle);
        });
    }

    // Fonction pour filtrer les voitures en fonction de la marque, du modèle et de la motorisation sélectionnés
    function filterCars(cars, selectedBrand, selectedModel, selectedEngine, selectedMileage, selectedPrice) {
        return cars.filter(car => {
            return (selectedBrand === 'Selectionnez une marque' || car.brand === selectedBrand) &&
                (selectedModel === 'Selectionnez un modele' || car.model === selectedModel) &&
                (selectedEngine === 'Selectionnez une motorisation' || car.engine === selectedEngine) &&
                (selectedMileage === 'Selectionnez un kilometrage maxi' || car.mileage <= selectedMileage) &&
                (selectedPrice === 'Selectionnez un prix maxi' || car.price <= selectedPrice); 
        });
    }

    let allCars = [];

    // Utiliser fetch pour récupérer les données de l'API de manière asynchrone
    //fetch('../api/car.api.php')
    fetch('../api/garageparrot/car.api.php')
        .then(response => response.json())
        .then(data => {
            allCars = data;
            displayCars(allCars);

            // Écouter les changements sur le select de la marque, du modèle et de la motorisation
            document.getElementById('select_car_brand').addEventListener('change', (event) => {
                const selectedBrand = event.target.value;
                const selectedModel = document.getElementById('select_car_model').value;
                const selectedEngine = document.getElementById('select_car_engine').value;
                const selectedMileage = document.getElementById('select_car_mileage').value;
                const selectedPrice = document.getElementById('select_car_price').value;
                const filteredCars = filterCars(allCars, selectedBrand, selectedModel, selectedEngine, selectedMileage, selectedPrice);
                displayCars(filteredCars);
            });

            document.getElementById('select_car_model').addEventListener('change', (event) => {
                const selectedBrand = document.getElementById('select_car_brand').value;
                const selectedModel = event.target.value;
                const selectedEngine = document.getElementById('select_car_engine').value;
                const selectedMileage = document.getElementById('select_car_mileage').value;
                const selectedPrice = document.getElementById('select_car_price').value;
                const filteredCars = filterCars(allCars, selectedBrand, selectedModel, selectedEngine, selectedMileage, selectedPrice);
                displayCars(filteredCars);
            });

            document.getElementById('select_car_engine').addEventListener('change', (event) => {
                const selectedBrand = document.getElementById('select_car_brand').value;
                const selectedModel = document.getElementById('select_car_model').value;
                const selectedEngine = event.target.value;
                const selectedMileage = document.getElementById('select_car_mileage').value;
                const selectedPrice = document.getElementById('select_car_price').value;
                const filteredCars = filterCars(allCars, selectedBrand, selectedModel, selectedEngine, selectedMileage, selectedPrice);
                displayCars(filteredCars);
            });

            document.getElementById('select_car_mileage').addEventListener('change', (event) => {
                const selectedBrand = document.getElementById('select_car_brand').value;
                const selectedModel = document.getElementById('select_car_model').value;
                const selectedEngine = document.getElementById('select_car_engine').value;
                const selectedMileage = event.target.value;
                const selectedPrice = document.getElementById('select_car_price').value;
                const filteredCars = filterCars(allCars, selectedBrand, selectedModel, selectedEngine, selectedMileage, selectedPrice);
                displayCars(filteredCars);
            });

            document.getElementById('select_car_price').addEventListener('change', (event) => {
                const selectedBrand = document.getElementById('select_car_brand').value;
                const selectedModel = document.getElementById('select_car_model').value;
                const selectedEngine = document.getElementById('select_car_engine').value;
                const selectedMileage = document.getElementById('select_car_mileage').value;
                const selectedPrice = event.target.value;
                const filteredCars = filterCars(allCars, selectedBrand, selectedModel, selectedEngine, selectedMileage, selectedPrice);
                displayCars(filteredCars);
            });

        })
        .catch(error => {
            console.log('Error:', error);
        });

    function focusOnInput() {
        document.getElementById('contact_description').value = "Bonjour, je souhaite prendre rendez-vous pour une présentation détaillée et un essai du véhicule xxxxxxxx ";
        document.getElementById('contact_name').focus();
        document.getElementById('bottom').scrollIntoView({ behavior: 'smooth' });
    }
</script>

<?php require_once('../module/garageparrot/searchCar.php'); ?>