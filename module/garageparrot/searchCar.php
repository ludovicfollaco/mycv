<script>

    const form = document.createElement("form");
    form.action = "";
    form.method = "post";

    // Créer la div principale avec les classes appropriées
    const mainDiv = document.createElement("div");
    mainDiv.className = "d-sm-flex justify-content-sm-between p-3 mx-2 mb-2 mt-2 mx-md-5 bgDark border border-secondary border-3 rounded-4";
    form.appendChild(mainDiv);

    // Fonction pour créer un conteneur avec un label et un select
    function createSelectContainer(labelText, selectId, selectName, options) {
        const container = document.createElement("div");
        container.className = "container d-flex flex-column";
        
        const label = document.createElement("label");
        label.htmlFor = selectId;
        label.className = "form-label text-light";
        label.textContent = labelText;
        container.appendChild(label);
        
        const select = document.createElement("select");
        select.className = "form-select fw-bolder rounded-3";
        select.id = selectId;
        select.name = selectName;
        
        options.forEach(optionText => {
            const option = document.createElement("option");
            option.value = optionText;
            option.textContent = optionText;
            select.appendChild(option);
        });
        
        container.appendChild(select);
        return container;
    }

    // Marque options
    const carBrands = [
        'Selectionnez une marque', 'ALPINE', 'AUDI', 'BMW', 'CITROEN', 'DACIA', 'DS', 
        'MERCEDES', 'OPEL', 'PEUGEOT', 'RENAULT', 'WOLKSWAGEN', '_'
    ];
    const carBrandContainer = createSelectContainer('Marque :', 'select_car_brand', 'select_car_brand', carBrands);
    mainDiv.appendChild(carBrandContainer);

    // Modèle options
    const carModels = [
        'Selectionnez un modele', '208', '308', '408', '508', 'A1', 'A110', 'A2', 'A3', 'A4', 
        'A6', 'A8', 'C4', 'CAPTUR', 'CLASSE A', 'CLASSE B', 'CLASSE C', 'CLIO', 'ESPACE', 
        'GOLF', 'i8', 'JOGGER', 'MEGANE', 'MEGANE E-TECH', 'PASSAT', 'POLO', 'Q4 E-TRON', 
        'SANDERO', 'SCENIC', 'SERIE1', 'SIROCCO', 'TWINGO', '_'
    ];
    const carModelContainer = createSelectContainer('Modèle :', 'select_car_model', 'select_car_model', carModels);
    mainDiv.appendChild(carModelContainer);

    // Motorisation options
    const carEngines = [
        'Selectionnez une motorisation', '1.2 PURE TECH 110CH (81kW)', '1.5 BLUE HDI 130CH (96kW)',
        '1.6 CRDI 115CH (85kW)', '1.6 ECO-G 115CH (85kW)', 'FUEL CELL 150kWh', '64 kWh EV',
        '40kWh ELECTRIC', '2.0 TFSI 200CH (147kW)', '2.0 TDI 150CH (110kW)', '2.0 ATKINSON 250CH (180kW)',
        '1.8 SYNERGY DRIVE 220CH (162kW)', '1.6 VTEC 120CH (88kW)','_'
    ];
    const carEngineContainer = createSelectContainer('Motorisation :', 'select_car_engine', 'select_car_engine', carEngines);
    mainDiv.appendChild(carEngineContainer);

    // Kms MAX options
    const carMileages = [
        'Selectionnez un kilometrage maxi', '10000', '20000', '30000', '40000', '50000', 
        '60000', '70000', '80000', '90000', '100000', '150000', '200000'
    ];
    const carMileageContainer = createSelectContainer('Kms MAX :', 'select_car_mileage', 'select_car_mileage', carMileages);
    mainDiv.appendChild(carMileageContainer);

    // Prix MAX options
    const carPrices = [
        'Selectionnez un prix maxi', '2500', '5000', '6000', '7000', '8000', '9000', 
        '10000', '12500', '15000', '17500', '20000', '25000', '30000', '35000', '40000', 
        '45000', '50000 € et +'
    ];
    const carPriceContainer = createSelectContainer('Prix MAX :', 'select_car_price', 'select_car_price', carPrices);
    mainDiv.appendChild(carPriceContainer);
/*
    // Conteneur pour le bouton de recherche
    const searchButtonContainer = document.createElement("div");
    searchButtonContainer.className = "container d-flex flex-column w-50 w-sm-25";

    const searchButtonLabel = document.createElement("label");
    searchButtonLabel.htmlFor = "btn-SearchCar";
    searchButtonLabel.className = "form-label text-light text-dark";
    searchButtonLabel.textContent = "Rechercher";
    searchButtonContainer.appendChild(searchButtonLabel);

    const searchButton = document.createElement("button");
    searchButton.className = "btn btn-lg btn-primary px-3 py-2";
    searchButton.type = "submit";
    searchButton.id = "btn-SearchCar";
    searchButton.name = "btn-SearchCar";
    searchButton.textContent = "Rechercher";
    searchButtonContainer.appendChild(searchButton);

    mainDiv.appendChild(searchButtonContainer);
*/
    // Insérer le formulaire au début de la balise <main>
    const mainElement = document.querySelector("main");
    if (mainElement) {
        mainElement.insertBefore(form, mainElement.firstChild);
    } else {
        console.error("La balise <main> n'a pas été trouvée.");
    }
    
</script>