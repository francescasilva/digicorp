<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <h2>Login con Firebase</h2>

  <input type="email" id="email" placeholder="Correo" />
  <input type="password" id="password" placeholder="Contraseña" />
  <button onclick="login()">Iniciar sesión</button>

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
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      signInWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
          alert('Login exitoso: ' + userCredential.user.email);
          window.location.href = "/products";
        })
        .catch((error) => {
          alert('Error: ' + error.message);
        });
    }
  </script>

</body>
</html>
