@extends('welcome')

@section('content')
<div class="container">
    <div class="row-md-04">
        <div class="card" id="cardContainer">

        </div>
    </div>
</div>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    let container = document.getElementById("cardContainer");
    searchCard();
    function searchCard() {
            let token = localStorage.getItem('token');

            let idCard = window.location.pathname.split('/').pop();

            
            console.log(idCard);

            axios.get("/api/cards/"+idCard, {
                    headers: {
                        'Authorization': token,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log(response.data);
                    console.log("-------------------");
                    displaySearchResults(response.data);
                    //window.location.href = '/decks';
                });
        }

        

        function displaySearchResults(card) {
            console.log(card); 

            container.innerHTML = "";
            
            
                console.log(card); 
                container.innerHTML += `
                    
                        <div class="card h-10">
                            <img src="${card.card.img}" class="card-img-top" alt="${card.card.title}">
                            <div class="card-body text-center">
                                <h6 class="card-title">${card.card.title}</h6>
                            </div>
                            <h1>${card.card.title}</h1>
                        <h1>${card.card.mana_cost}</h1>
                        <h1>${card.card.pasive}</h1>
                        </div>`;
            
        }
</script>
@endsection