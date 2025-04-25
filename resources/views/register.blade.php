@extends('welcome')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header bg-success text-white">Registro de Usuario</div>
                <div class="card-body">
                    <form id="register-form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Registrarse</button>
                    </form>
                    <div class="mt-3 text-center">
                        ¿Ya tienes cuenta? <a href="/login">Inicia sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    console.log("aaaa");
    document.getElementById('register-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log("aaaa");
            register();
        });
        console.log("aaaa");
        function register() {
            console.log(document.getElementById('name').value+" "+document.getElementById('email').value+" "+document.getElementById('password').value+" "+document.getElementById('password_confirmation').value);
            if(document.getElementById('password').value != document.getElementById('password_confirmation').value) {
                alert("Las contraseñas no coinciden");
                return;
            }
            
            axios.post("/api/register", {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
                    confirm_password: document.getElementById('password_confirmation').value,
                })
                .then(response => {        
                    window.location.href = '/login';
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