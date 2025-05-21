 
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

    