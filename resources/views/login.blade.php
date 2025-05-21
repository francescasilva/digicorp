<!DOCTYPE html>
<html>
<head>
  <title>Login - Mini E-commerce</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
  <div class="login-container col-md-3 col-sm-8 col-10">
    <h3 class="text-center mb-2">Mini E-commerce</h3>
    <p id="mensaje-error-login" class="text-center mt-1 mb-3 text-danger fw-bold" style="font-size: 0.9rem; display: none;">
    </p>
    <div class="mb-3">
      <input type="email" id="email" class="form-control" placeholder="Usuario" />
    </div>
    
    <div class="mb-3">
      <input type="password" id="password" class="form-control" placeholder="Contraseña" />
    </div>
    
    <div class="d-grid">
      <button 
       onclick="login()" 
       class="btn text-white" 
       style="background-color:rgb(116, 38, 199); border-color: #6a11cb; transition: background-color 0.3s, border-color 0.3s;" 
       onmouseover="this.style.backgroundColor='#5a0fba';" 
       onmouseout="this.style.backgroundColor='#6a11cb';">
        Iniciar Sesión
    </button>

    </div>
  </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 <script type="module" src="{{ asset('js/login.js') }}"></script>

</body>
</html>
