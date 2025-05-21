<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Mini E-commerce</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/product.css') }}">
</head>
<body>
    <div class="titulo"><h2>Mini E-commerce</h2></div>
    <div class="d-flex justify-content-end p-3">
    <button id="logout-btn" class="btn btn-danger">Cerrar sesión</button>
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
      <div id="overlay" class="overlay"></div>
       <div id="carrito-contenido" class="carrito-flotante"></div>
     </div>
    </div>
  </div>
 <script type="module" src="{{ asset('js/product.js') }}"></script>
</body>
</html>