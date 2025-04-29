@extends('welcome')

@section('content')
    <div class="row">
        <!-- Filtros -->
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

        function searchCard() {
            let token = localStorage.getItem('token');

            let nameCard = document.getElementById("name-card");


            console.log(nameCard.value);

            axios.get("/api/cards/", {
                    params: {
                        name: nameCard.value
                    },
                }, {
                    headers: {
                        'Authorization': token,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log(response.data);
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
    </script>
@endsection
