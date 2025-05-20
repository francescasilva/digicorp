<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Mini E-commerce</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/product.css') }}">

</head>
<body>

  <h2>Mini E-commerce</h2>
   <div class="d-flex justify-content-end p-3">
  <button id="logout-btn" class="btn btn-outline-danger">Cerrar sesión</button>
 </div>
  <div class="container mt-4">
      <div class="row">
      <!-- Productos -->
      <div class="col-12 col-md-12">
      <div id="product-list">Cargando productos...</div>
     </div>
     <!-- Carrito -->
     <div class="col-md-4">
      <button id="boton-carrito" onclick="mostrarCarrito()">🛒</button>
       <div id="carrito-contenido" class="carrito-flotante"></div>
     </div>
    </div>
   
  </div>

  <!-- Firebase -->
  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.0/firebase-app.js";
    import { getAuth, onAuthStateChanged,signOut} from "https://www.gstatic.com/firebasejs/10.11.0/firebase-auth.js";
    import { getFirestore, doc, setDoc, arrayUnion, getDoc } from "https://www.gstatic.com/firebasejs/10.11.0/firebase-firestore.js";

    // Configuración de Firebase
    const firebaseConfig = {
      apiKey: "AIzaSyBxhXmBeSZgy3wdl22-c-E6tM4fwRuzxgs",
      authDomain: "digicorp-d641f.firebaseapp.com",
      projectId: "digicorp-d641f",
      storageBucket: "digicorp-d641f.appspot.com",
      messagingSenderId: "88068059144",
      appId: "1:88068059144:web:395ab96a00dd8aae42e1bd",
      measurementId: "G-KZ5Q0GGZN1"
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const db = getFirestore(app);
    let cerrandoSesion = false;
    
    auth.onAuthStateChanged((user) => {
      if (user) {
    cargarProductos(user); // vuelve a pintar todos los botones correctamente
       }
      });

    // Hacer global para funciones
    window.firebaseAuth = auth;
    window.firebaseDb = db;

    // Cargar productos desde tu API
   async function cargarProductos(user) {
     try {
    const response = await fetch('http://localhost:8000/api/products');
    if (!response.ok) throw new Error('No se pudo obtener los productos');
    const data = await response.json();

    const list = document.getElementById('product-list');
    list.innerHTML = '';

    if (data.length === 0) {
      list.textContent = 'No hay productos disponibles.';
      return;
    }

    let cartItems = [];
    if (user) {
      const cartRef = doc(db, "carts", user.uid);
      const cartSnap = await getDoc(cartRef);
      if (cartSnap.exists()) {
        cartItems = cartSnap.data().items || [];
      }
    }

    data.forEach(product => {
      const card = document.createElement('div');
      card.className = 'product-card';

      const inCart = cartItems.some(item => item.productId === String(product.id));


      card.innerHTML = `
      <img src="${product.image}" alt="${product.name}">
      <h3>${product.name}</h3>
       <p class="price">Precio: $${product.price}</p>
      <p>Stock: ${product.quantity}</p>
      <button data-product-id="${product.id}" class="${inCart ? 'btn-quitar' : ''}">
      ${inCart ? '🛒Quitar' : '🛒Comprar'}
      </button>`;


      list.appendChild(card);
    });

    document.querySelectorAll('.product-card button').forEach(button => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-product-id');
        toggleCart(id, button);
      });
    });

  } catch (error) {
    console.error('Error al obtener los productos:', error);
    document.getElementById('product-list').textContent = 'Error al cargar productos.';
  }
}
     
    async function toggleCart(productId, button) {
  const user = auth.currentUser;
  const db = window.firebaseDb;

  if (!user) {
    alert("Debes iniciar sesión para agregar o quitar productos.");
    return;
  }

  const cartRef = doc(db, "carts", user.uid);
  const cartSnap = await getDoc(cartRef);
  let items = [];

  if (cartSnap.exists()) {
    items = cartSnap.data().items || [];
  }

  const index = items.findIndex(item => item.productId === productId);

  if (index !== -1) {
    // Ya está en carrito -> quitar
    items.splice(index, 1);
    await setDoc(cartRef, { items }, { merge: true });
    alert("Producto eliminado del carrito.");
    button.textContent = "🛒Comprar";
    button.classList.remove("btn-quitar");
  } else {
    // No está en carrito -> agregar
    const card = button.closest('.product-card');
    const name = card.querySelector('h3').textContent;
    const priceText = card.querySelector('.price').textContent;
    const price = parseFloat(priceText.replace('Precio: $', ''));

    await setDoc(cartRef, {
      items: arrayUnion({
        productId: String(productId), // <- Asegúrate que es string
        name: name,
        price: price,
        quantity: 1
      })
    }, { merge: true });

    alert("Producto agregado al carrito.");
    button.textContent = "🛒Quitar";
    button.classList.add("btn-quitar");
  }
}

 window.toggleCart = toggleCart;

    // Mostrar carrito
   // Modificar mostrarCarrito para agregar total y botón finalizar compra
async function mostrarCarrito() {
  const user = auth.currentUser;
  const contenedor = document.getElementById('carrito-contenido');

  if (!user) {
    alert("Debes iniciar sesión para ver el carrito.");
    return;
  }

  const cartRef = doc(db, "carts", user.uid);
  const cartSnap = await getDoc(cartRef);

  if (cartSnap.exists()) {
    const items = cartSnap.data().items || [];

    if (items.length === 0) {
      contenedor.innerHTML = "<h3>Carrito:</h3><p>El carrito está vacío.</p>";
    } else {
      // Calcular total
      const total = items.reduce((acc, item) => acc + (item.price * item.quantity), 0);

      contenedor.innerHTML = `
        <h3>Carrito:</h3>
        <ul>
          ${items.map((item, index) => `
            <li>
              ${item.name} - $${item.price} (x${item.quantity})
              <button onclick="eliminarDelCarrito('${item.productId}', ${index})" class="btn btn-danger" aria-label="Eliminar producto" ><i class="bi bi-trash"></i></button>
            </li>
          `).join("")}
        </ul>
        <p><strong>Total: $${total.toFixed(2)}</strong></p>
        <button id="finalizar-compra-btn" class="btn btn-success">Finalizar compra</button>
      `;

      // Agregar evento al botón finalizar compra
      document.getElementById('finalizar-compra-btn').addEventListener('click', finalizarCompra);
    }

    contenedor.style.display = 'block';
  } else {
    contenedor.innerHTML = "<h3>Carrito:</h3><p>Carrito vacío.</p>";
    contenedor.style.display = 'block';
  }
}

// Función para finalizar compra y vaciar carrito
window.finalizarCompra = async function () {
  const user = auth.currentUser;
  const db = window.firebaseDb;

  if (!user) {
    alert("Debes iniciar sesión para finalizar la compra.");
    return;
  }

  try {
    const cartRef = doc(db, "carts", user.uid);
    await setDoc(cartRef, { items: [] }, { merge: true });

    alert("¡Gracias por tu compra!");

    // Ocultar carrito
    document.getElementById("carrito-contenido").style.display = "none";

    // Cambiar todos los botones de productos a "Comprar"
    const botones = document.querySelectorAll('.product-card button');
    botones.forEach((boton) => {
      boton.textContent = "🛒Comprar";
      boton.classList.remove("btn-quitar");
    });
  } catch (error) {
    console.error("Error al finalizar la compra:", error);
    alert("Ocurrió un error al finalizar la compra.");
  }
};


window.finalizarCompra = finalizarCompra;

      
    function cerrarCarrito() {
        document.getElementById('carrito-contenido').style.display = 'none';
     }

     
    window.mostrarCarrito = mostrarCarrito;

    window.eliminarDelCarrito = async function (productId, index) {
  const user = auth.currentUser;
  const db = window.firebaseDb;

  if (!user) {
    alert("Debes iniciar sesión para eliminar productos del carrito.");
    return;
  }

  try {
    const cartRef = doc(db, "carts", user.uid);
    const cartSnap = await getDoc(cartRef);

    if (cartSnap.exists()) {
      const items = cartSnap.data().items || [];

      // Eliminar por índice para evitar problemas con productos duplicados
      items.splice(index, 1);

      await setDoc(cartRef, { items }, { merge: true });

      alert("Producto eliminado del carrito.");
      mostrarCarrito(); // Recarga el contenido del carrito

      // Actualizar el botón específico
      const botones = document.querySelectorAll(`.product-card button[data-product-id="${productId}"]`);
      botones.forEach((boton) => {
        boton.textContent = "🛒Comprar";
        boton.classList.remove("btn-quitar");
      });
    } else {
      alert("No se encontró el carrito del usuario.");
    }
  } catch (error) {
    console.error("Error al eliminar del carrito:", error);
    alert("Ocurrió un error al eliminar el producto del carrito.");
  }
};

    
     document.addEventListener("click", function (event) {
       const carrito = document.getElementById("carrito-contenido");
       const boton = document.getElementById("boton-carrito"); // tu botón para mostrar el carrito
       if (
         carrito.style.display === "block" &&
        !carrito.contains(event.target) &&
         !boton.contains(event.target) )
        {
          carrito.style.display = "none";
         }
   });
    // Cerrar sesión
     document.getElementById('logout-btn').addEventListener('click', async () => {
  cerrandoSesion = true;  // Evita que se ejecuten cosas cuando se desloguea

  try {
    await signOut(auth);
    alert("Sesión cerrada exitosamente.");
    window.location.href = "/login";
  } catch (error) {
    console.error("Error al cerrar sesión:", error);
    alert("Ocurrió un error al cerrar sesión.");
  }
});

  </script>

</body>
</html>