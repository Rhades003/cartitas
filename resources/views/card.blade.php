@extends('welcome')

@section('content')
    <div class="container">
        <div class="row-md-04">
            <div class="card" id="cardContainer">
                <div class="cardDiv" id="cardDiv"></div>
                <div class="offerDiv" id="offerDiv"></div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        let cardDiv = document.getElementById("cardDiv");
        let offerDiv = document.getElementById("offerDiv");
        searchCard();

        function searchCard() {
            let token = localStorage.getItem('token');

            let idCard = window.location.pathname.split('/').pop();


            console.log(idCard);

            axios.get("/api/cards/" + idCard, {
                    headers: {
                        'Authorization': token,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    displaySearchResults(response.data);
                    //window.location.href = '/decks';
                });
        }

        function deleteOffer(offerId) {
            let token = localStorage.getItem('token');

            axios.delete("/api/cards/offer/" + offerId, {
                    headers: {
                        'Authorization': token,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                   //displaySearchResults(response.data);
                    window.location.reload();
                });
            }

        function displaySearchResults(card) {
            console.log(card);

            cardDiv.innerHTML = "";
            offerDiv.innerHTML = "";
            console.log(card);
            if (card.card.doble == 0) {
                cardDiv.innerHTML = `
                    <div class="mb-4 w-100">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <img src="${card.card.img}" 
                                    class="h-100 w-100" 
                                    style="object-fit: contain; max-height: 600px;" 
                                    alt="${card.card.title}">
                            </div>
                            <div class="col-md-6 p-4 d-flex flex-column">
                                <div class="card-body">
                                    <h1 class="card-title mb-3">${card.card.title}</h1>
                                    <h3 class="text-muted mb-4">${card.card.mana_cost || 'Sin coste de maná'}</h3>
                                    <h3 class="text-muted mb-4">${card.card.type}</h3>
                                    <div class="card-text mb-4">
                                        ${card.card.pasive ? `<p class="lead">${card.card.pasive}</p>` : ''}
                                        ${card.card.stats ? `<p class="h5"><strong>Estadísticas:</strong> ${card.card.stats}</p>` : ''}
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>`;
            }
            else {
                cardDiv.innerHTML = `
                    <div class="mb-4 w-100">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <img src="${card.card.img}" 
                                    class="h-100 w-100" 
                                    style="object-fit: contain; max-height: 600px;" 
                                    alt="${card.card.title}">
                            </div>
                            <div class="col-md-6 p-4 d-flex flex-column">
                                <div class="card-body">
                                    <h1 class="card-title mb-3">${card.card.title}</h1>
                                    <h3 class="text-muted mb-4">${card.card.mana_cost || 'Sin coste de maná'}</h3>
                                    <h3 class="text-muted mb-4">${card.card.type}</h3>
                                    <div class="card-text mb-4">
                                        ${card.card.pasive ? `<p class="lead">${card.card.pasive}</p>` : ''}
                                        ${card.card.stats ? `<p class="h5"><strong>Estadísticas:</strong> ${card.card.stats}</p>` : ''}
                                    </div>
                                    <h1 class="card-title mb-3">${card.card.title_2}</h1>
                                    <h3 class="text-muted mb-4">${card.card.mana_cost_2 || 'Sin coste de maná'}</h3>
                                    <h3 class="text-muted mb-4">${card.card.type_2}</h3>
                                    <div class="card-text mb-4">
                                        ${card.card.pasive_2 ? `<p class="lead">${card.card.pasive_2}</p>` : ''}
                                        ${card.card.stats_2 ? `<p class="h5"><strong>Estadísticas:</strong> ${card.card.stats_2}</p>` : ''}
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>`;
            }
            if(!card.admin){
            offerDiv.innerHTML = `
                <div class="card mt-4">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Ofertas Disponibles (${card.card.offers.length})</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Vendedor</th>
                                <th>Expansión</th>
                                <th>Calidad</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>BCN</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${card.card.offers.map(offer => `
                                <tr>
                                    <td>${offer.seller || 'N/A'}</td>
                                    <td>${offer.expansion || 'N/A'}</td>
                                    <td>${offer.quality || 'N/A'}</td>
                                    <td>${offer.price ? offer.price.toFixed(2) + ' €' : 'N/A'}</td>
                                    <td>${offer.quantity || 'N/A'}</td>
                                    <td>${offer.BCN ? 'Sí' : 'No'}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>`;
            }
            else if(card.admin){
                offerDiv.innerHTML = `
                <div class="card mt-4">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Ofertas Disponibles (${card.card.offers.length})</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Vendedor</th>
                                <th>Expansión</th>
                                <th>Calidad</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>BCN</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${card.card.offers.map(offer => `
                                <tr>
                                    <td>${offer.seller || 'N/A'}</td>
                                    <td>${offer.expansion || 'N/A'}</td>
                                    <td>${offer.quality || 'N/A'}</td>
                                    <td>${offer.price ? offer.price.toFixed(2) + ' €' : 'N/A'}</td>
                                    <td>${offer.quantity || 'N/A'}</td>
                                    <td>${offer.BCN ? 'Sí' : 'No'}</td>
                                    <td><button onClick="deleteOffer(${offer.id})">Delete</button</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>`;
            }
        }

              
    
    </script>
@endsection
