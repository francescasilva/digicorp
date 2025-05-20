<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Mini E-commerce</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f3f3;
      margin: 0;
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #4a148c;
    }
    #product-list {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    .product-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      width: 260px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: transform 0.2s;
    }
    .product-card:hover {
      transform: translateY(-5px);
    }
    .product-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .product-card h3 {
      margin: 16px;
      font-size: 18px;
    }
    .product-card p {
      margin: 0 16px 8px;
      color: #555;
    }
    .product-card .price {
      font-weight: bold;
      color: #4a148c;
    }
    .product-card button {
      margin: 16px;
      padding: 10px;
      background-color: #4a148c;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.2s;
    }
    .product-card button:hover {
      background-color: #6a1b9a;
    }

    #carrito-contenido {
     background: #fff;
     max-width: 400px;
    margin: 20px auto;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    padding: 20px;
    font-family: Arial, sans-serif;
}

#carrito-contenido h3 {
  color: #4a148c;
  margin-bottom: 15px;
  text-align: center;
}

#carrito-contenido ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#carrito-contenido ul li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #ddd;
  padding: 8px 0;
  font-size: 16px;
  color: #333;
}

#carrito-contenido ul li:last-child {
  border-bottom: none;
}

/* Botón de eliminar producto (opcional) */
#carrito-contenido ul li button {
  background-color: #d32f2f;
  border: none;
  color: white;
  padding: 5px 8px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.2s;
}

#carrito-contenido ul li button:hover {
  background-color: #b71c1c;
}

  </style>
</head>
<body>

  <h2>Mini E-commerce</h2>
<div class="container mt-4">
  <div class="row">
    <!-- Productos -->
    <div class="col-md-8">
      <div id="product-list">Cargando productos...</div>
    </div>

    <!-- Carrito -->
    <div class="col-md-4">
      <div id="carrito-contenido" style="display: none;"></div>
      <button onclick="mostrarCarrito()" type="button" class="btn btn-primary">
       <i class="bi bi-cart"></i> Ver carrito
      </button>
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
            <button data-product-id="${product.id}">Agregar al carrito</button>
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

  </script>

</body>
</html>
