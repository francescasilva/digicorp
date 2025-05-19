<!DOCTYPE html>
<html>
<head>
  <title>Lista de Productos</title>
</head>
<body>

  <h2>Lista de Productos</h2>
  <div id="product-list"></div>

  <script>
    fetch('/api/products')
      .then(response => response.json())
      .then(data => {
        const list = document.getElementById('product-list');
        list.innerHTML = ''; // Limpia antes de agregar

        if (data.length === 0) {
          list.textContent = 'No hay productos disponibles.';
        } else {
          data.forEach(product => {
            const item = document.createElement('div');
            item.textContent = `${product.name} - $${product.price} - Stock: ${product.quantity}`;
            list.appendChild(item);
          });
        }
      })
      .catch(error => {
        console.error('Error al obtener los productos:', error);
      });
  </script>

</body>
</html>
