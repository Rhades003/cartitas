@extends('welcome')

@section('content')
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header">Filtrar Cartas</div>
                <div class="card-body">
                    <form id="filter-form">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="name-card" placeholder="Nombre de carta">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <div id="loading" class="text-center my-4" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>

            <div id="cards-container" class="row">

            </div>

            <div id="pagination" class="d-flex justify-content-center mt-4">

            </div>
        </div>
    </div>
    <script>
        document.getElementById('filter-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            searchCard();
        });
        let cardsContainer = document.getElementById("cards-container");

        function searchCard() {
            let token = localStorage.getItem('token');

            let nameCard = document.getElementById("name-card");

            
            console.log(nameCard.value);

            axios.get("/api/cards/", {
                    params: {
                        name: nameCard.value,
                        searchOnlyhForName: false,
                    },
                }, {
                    headers: {
                        'Authorization': token,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log(response.data);
                    console.log("-------------------");
                    displaySearchResults(response.data.data);
                    //window.location.href = '/decks';
                })
                .catch(error => {
                    console.error("Error completo:", {
                        status: error.response?.status,
                        data: error.response?.data,
                        headers: error.response?.headers
                    });
                });
        }

        function displaySearchResults(cards) {
            console.log(cards); 

            cardsContainer.innerHTML = "";
            
            cards.forEach(card => {
                console.log(card); 
                cardsContainer.innerHTML += `
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <a href="/cards/${card.id}"><img src="${card.img}" class="card-img-top" alt="${card.title}"></a>
                            <div class="card-body text-center">
                                <h6 class="card-title">${card.title}</h6>
                            </div>
                        </div>
                    </div>`;
            });
    
            searchResultsContainer.style.display = 'flex';
        }
    </script>
@endsection
