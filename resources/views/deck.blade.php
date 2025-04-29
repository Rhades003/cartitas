@extends('welcome')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Gestión de Mazo</h1>


                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Añadir Cartas al Mazo</h5>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" id="card-search" class="form-control" placeholder="Buscar cartas...">
                            <button class="btn btn-primary" type="button" id="search-button">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                        <div id="search-results" class="mt-3 row" style="display: none;">

                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Cartas en el Mazo</h5>
                    </div>
                    <div class="card-body">
                        </div>
                        <div id="deck-cards" class="row">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const deckId = window.location.pathname.split('/').pop();
        const token = localStorage.getItem('token');
    
      
        const deckCardsContainer = document.getElementById('deck-cards');
        const searchResultsContainer = document.getElementById('search-results');
        const searchButton = document.getElementById('search-button');
        const cardSearch = document.getElementById('card-search');
        const loadingIndicator = document.getElementById('loading-cards');
    
     
        document.addEventListener('DOMContentLoaded', () => {
            loadDeckCards();
            searchButton.addEventListener('click', searchCards);
            cardSearch.addEventListener('keypress', (e) => e.key === 'Enter' && searchCards());
        });
    
    
        async function loadDeckCards() {
    
            axios.get(`/api/decks/${deckId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                renderDeckCards(response.data.cards);
            })
            .catch(error => {
                console.error("Error completo:", {
                    status: error.response?.status,
                    data: error.response?.data,
                    headers: error.response?.headers
                });
            })

        }
    
        function renderDeckCards(cards) {
            deckCardsContainer.innerHTML = cards.length ? '' : '<div class="col-12"><p>No hay cartas en este mazo</p></div>';
            
            cards.forEach(card => {
                deckCardsContainer.innerHTML += `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="${card.img || '/images/card-back.jpg'}" class="card-img-top" alt="${card.title}">
                            <div class="card-body text-center">
                                <h6 class="card-title">${card.title}</h6>
                            </div>
                            <div class="card-footer bg-transparent">
                                <button class="btn btn-sm btn-danger remove-card w-100" onclick="removeFromDeck(${card.id})">
                                    <i class="bi bi-trash"></i> Quitar
                                </button>
                            </div>
                        </div>
                    </div>`;
            });
        }


        function searchCards() {
            const card = cardSearch.value.trim();
            if (!card) return;
    
            axios.get(`/api/cards?title=${card}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                displaySearchResults(response.data.data);
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
            searchResultsContainer.innerHTML = cards.length ? '' : '<div class="col-12"><p>No se encontraron cartas</p></div>';
            
            cards.forEach(card => {
                searchResultsContainer.innerHTML += `
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <img src="${card.img}" class="card-img-top" alt="${card.title}">
                            <div class="card-body text-center">
                                <h6 class="card-title">${card.title}</h6>
                            </div>
                            <div class="card-footer bg-transparent">
                                <button class="btn btn-sm btn-success add-card w-100" onclick="addToDeck(${card.id})">
                                    <i class="bi bi-plus"></i> Añadir
                                </button>
                            </div>
                        </div>
                    </div>`;
            });
    
            searchResultsContainer.style.display = 'flex';
        }
    

        function addToDeck(cardId) {
            axios.post(`/api/decks/${deckId}/cards`, 
                { card_id: cardId },
                {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                }
            )
            .then(response => {
                cardSearch.value = '';
                searchResultsContainer.style.display = 'none';
                loadDeckCards();
            })
            .catch(error => {
                console.error("Error completo:", {
                    status: error.response?.status,
                    data: error.response?.data,
                    headers: error.response?.headers
                });
            });
        }
    

        function removeFromDeck(cardId) {
            if (!confirm('¿Quitar esta carta del mazo?')) return;
            
            axios.delete(`/api/decks/${deckId}/cards/${cardId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                loadDeckCards();
            })
            .catch(error => {
                console.error("Error completo:", {
                    status: error.response?.status,
                    data: error.response?.data,
                    headers: error.response?.headers
                });
            });
        }
    </script>

    <style>
        .deck-card .card-img-top {
            height: 200px;
            object-fit: contain;
        }

        #search-results .card-img-top {
            height: 150px;
            object-fit: contain;
        }
    </style>
@endsection
