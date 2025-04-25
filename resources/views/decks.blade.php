@extends('welcome')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Mis Mazos</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newDeckModal">
                Crear Nuevo Mazo
            </button>
        </div>

        <div id="decks-container" class="row">
        </div>
    </div>
    <div class="modal fade" id="newDeckModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Mazo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="new-deck-form">
                        <div class="mb-3">
                            <label for="deck-name" class="form-label">Nombre del Mazo</label>
                            <input type="text" class="form-control" id="deck-name" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="deck-public">
                            <label class="form-check-label" for="deck-public">Mazo público</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('token');
        const fullToken = token.startsWith('Bearer ') ? token : `Bearer ${token}`;
        

        document.getElementById('new-deck-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            createDeck();
        });

        function createDeck() {
            let nameDeck = document.getElementById("deck-name");
            let public = document.getElementById("deck-public");

            console.log(nameDeck.value + " " + public.checked);

            axios.post("/api/decks", {
                    name: nameDeck.value,
                    public: public.checked,
                    cards: []
                }, {
                    headers: {
                        'Authorization': fullToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log("Mazo creado:", response.data);
                })
                .catch(error => {
                    console.error("Error completo:", {
                        status: error.response?.status,
                        data: error.response?.data,
                        headers: error.response?.headers
                    });
                });
        }

        async function loadDecks() {

            const response = await fetch('/api/decks', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (response.ok) {
                const decks = await response.json();
                renderDecks(decks);
            }
        }

        function renderDecks(decks) {
            const container = document.getElementById('decks-container');
            container.innerHTML = decks.map(deck => `
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">${deck.name}</h5>
                        <p class="card-text">${deck.public ? 'Público' : 'Privado'}</p>
                        <p class="card-text">${deck.cards_count} cartas</p>
                        <a href="/decks/${deck.id}" class="btn btn-sm btn-primary">Ver Mazo</a>
                        <button class="btn btn-sm btn-danger" onclick="deleteDeck(${deck.id})">Eliminar</button>
                    </div>
                </div>
            </div>
        `).join('');
        }

        async function deleteDeck(deckId) {
            if (!confirm('¿Seguro que quieres eliminar este mazo?')) return;

            const token = localStorage.getItem('token');
            const response = await fetch(`/api/decks/${deckId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (response.ok) {
                await loadDecks();
            }
        }
    </script>
@endsection
