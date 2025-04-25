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
                        <input type="text" class="form-control" id="title-filter" placeholder="Nombre de carta">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="type-filter" placeholder="Tipo">
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
@endsection