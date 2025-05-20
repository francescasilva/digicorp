<!DOCTYPE html>
<html>
<head>
  <title>Login - Mini E-commerce</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right,rgb(141, 59, 228),rgb(99, 152, 243));
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
    }
    h3 {
    color: #6a11cb; /* Cambia aquí al color que quieras */

    
  }
  </style>
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

  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";
    import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/9.22.0/firebase-auth.js";

    const firebaseConfig = {
      apiKey: "AIzaSyBxhXmBeSZgy3wdl22-c-E6tM4fwRuzxgs",
      authDomain: "digicorp-d641f.firebaseapp.com",
      projectId: "digicorp-d641f",
      storageBucket: "digicorp-d641f.firebasestorage.app",
      messagingSenderId: "88068059144",
      appId: "1:88068059144:web:395ab96a00dd8aae42e1bd",
      measurementId: "G-KZ5Q0GGZN1"
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);

   window.login = function() {
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value.trim();
  const mensajeError = document.getElementById("mensaje-error-login");

  // Verifica si faltan credenciales
  if (!email || !password) {
    mensajeError.style.display = "block"; // Muestra el mensaje de error
    mensajeError.textContent = "Por favor, ingresa tus credenciales";
    return; // Detiene el proceso
  }

  // Si hay credenciales, oculta el mensaje de error
  mensajeError.style.display = "none";

  signInWithEmailAndPassword(auth, email, password)
    .then((userCredential) => {
      alert('Login exitoso: ' + userCredential.user.email);
      window.location.href = "/products";
    })
    .catch((error) => {
      // Muestra mensaje si Firebase da error (credenciales incorrectas, etc.)
      mensajeError.style.display = "block";
      mensajeError.textContent = "Credenciales incorrectas o usuario no registrado.";
      console.error(error);
    });
    }

    
  </script>

</body>
</html>
