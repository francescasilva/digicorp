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
    import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.11.0/firebase-auth.js";
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

    // Hacer global para funciones
    window.firebaseAuth = auth;
    window.firebaseDb = db;

    // Cargar productos desde tu API
    async function cargarProductos() {
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

        data.forEach(product => {
          const card = document.createElement('div');
          card.className = 'product-card';

          // Asegúrate que product.id sea string para evitar problemas en onclick
          card.innerHTML = `
            <img src="${product.image}" alt="${product.name}">
            <h3>${product.name}</h3>
            <p class="price">Precio: $${product.price}</p>
            <p>Stock: ${product.quantity}</p>
            <button data-product-id="${product.id}">🛒Comprar</button>
          `;

          list.appendChild(card);
        });

        // Agregar event listeners a botones después de renderizar
        document.querySelectorAll('.product-card button').forEach(button => {
          button.addEventListener('click', () => {
            const id = button.getAttribute('data-product-id');
            addToCart(id);
          });
        });

      } catch (error) {
        console.error('Error al obtener los productos:', error);
        document.getElementById('product-list').textContent = 'Error al cargar productos.';
      }
    }

    cargarProductos();

    // Función para agregar producto al carrito
    window.addToCart = async function (productId) {
      onAuthStateChanged(auth, async (user) => {
        if (user) {
          try {
            // Para simplificar: buscar el producto en la lista actual en DOM
            const productCard = [...document.querySelectorAll('.product-card')].find(card => {
              return card.querySelector('button').getAttribute('data-product-id') === productId;
            });

            if (!productCard) {
              alert('Producto no encontrado');
              return;
            }

            const name = productCard.querySelector('h3').textContent;
            const priceText = productCard.querySelector('.price').textContent;
            const price = parseFloat(priceText.replace('Precio: $', ''));

            const cartRef = doc(db, "carts", user.uid);

            await setDoc(cartRef, {
              items: arrayUnion({
                productId: productId,
                name: name,
                price: price,
                quantity: 1
              })
            }, { merge: true });

            alert('Producto agregado al carrito correctamente.');
          } catch (error) {
            console.error("Error al agregar al carrito:", error);
            alert("Hubo un error al agregar el producto al carrito.");
          }
        } else {
          alert("Debes iniciar sesión para agregar al carrito.");
        }
      });
    };

    // Mostrar carrito
    async function mostrarCarrito() {
     const user = auth.currentUser;

     if (user) {
     const cartRef = doc(db, "carts", user.uid);
     const cartSnap = await getDoc(cartRef);
     const contenedor = document.getElementById('carrito-contenido');

     if (cartSnap.exists()) {
      const items = cartSnap.data().items || [];

      if (items.length === 0) {
        contenedor.innerHTML = "<h3>Carrito:</h3><p>El carrito está vacío.</p>";
      } else {
        contenedor.innerHTML = "<h3>Carrito:</h3><ul>" +
          items.map((item, index) => `
            <li>
              ${item.name} - $${item.price} (x${item.quantity})
              <button onclick="eliminarDelCarrito('${item.productId}', ${index})">Eliminar</button>
            </li>
          `).join("") + "</ul>";
      }

      contenedor.style.display = 'block';
      } else {
      contenedor.innerHTML = "<h3>Carrito:</h3><p>Carrito vacío.</p>";
      contenedor.style.display = 'block';
      }
     } else {
      alert("Debes iniciar sesión para ver el carrito.");
    }
    }
      
    function cerrarCarrito() {
        document.getElementById('carrito-contenido').style.display = 'none';
     }

     
    window.mostrarCarrito = mostrarCarrito;
    window.eliminarDelCarrito = async function (productId, index) {
      const auth = window.firebaseAuth;
      const db = window.firebaseDb;

      onAuthStateChanged(auth, async (user) => {
      if (user) {
      const cartRef = doc(db, "carts", user.uid);
      const cartSnap = await getDoc(cartRef);

      if (cartSnap.exists()) {
        const items = cartSnap.data().items || [];

        // Filtrar el ítem específico por índice (para evitar errores con duplicados)
        items.splice(index, 1);

        await setDoc(cartRef, { items: items }, { merge: true });

        alert("Producto eliminado del carrito.");
        mostrarCarrito(); // Volver a cargar el carrito
       }
       } else {
         alert("Debes iniciar sesión para eliminar productos del carrito.");
       }
      });
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

  </script>

</body>
</html>
