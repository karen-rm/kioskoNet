<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Cargar jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <h1>Agregar un titulo</h1>
  <form id="agregarTituloForm">

    <label for="isbn">ISBN:</label><br>
    <input type="text" id="isbn" name="isbn" required><br><br>

    <label for="titulo">Titulo:</label><br>
    <input type="text" id="titulo" name="titulo" required><br><br>

    <label for="categoria">Categoria:</label><br>
    <input type="text" id="categoria" name="categoria" required><br><br>

    <label for="autor">Autor:</label><br>
    <input type="text" id="autor" name="autor"><br><br>

    <label for="editorial">Editorial:</label><br>
    <input type="text" id="editorial" name="editorial" required><br><br>

    <label for="revista">Revista:</label><br>
    <input type="text" id="revista" name="revista"><br><br>

    <label for="anio">Año de publicación:</label><br>
    <input type="text" id="anio" name="anio" required><br><br>

    <label for="genero">Genero</label><br>
    <input type="text" id="genero" name="genero" required><br><br>

    <label for="precio">Precio</label><br>
    <input type="text" id="precio" name="precio" required><br><br>

    <input type="submit" value="Enviar">
  </form>

  <h2>Catálogo</h2>
  <table border="1" id="tabla-catalogo">
    <thead>
      <tr>
        <th>ISBN</th>
        <th>Título</th>
        <th>Categoría</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>



  <!-- Incluir archivo JavaScript con AJAX -->
  <script src="../ajax/contenido.js"></script>
</body>

</html>