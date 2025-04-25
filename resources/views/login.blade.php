@extends('welcome')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">Iniciar Sesión</div>
                    <div class="card-body">
                        <form id="login-form">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                        <div class="mt-3 text-center">
                            ¿No tienes cuenta? <a href="/register">Regístrate</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            login();
        });

        function login() {
            console.log(document.getElementById('email').value+" "+document.getElementById('password').value);
            axios.post("/api/login", {
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value

                })
                .then(response => {
                    console.log(response.data);
                    localStorage.setItem('token', response.data.token);
                    window.location.href = '/decks';
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
