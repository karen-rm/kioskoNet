<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Agregar un titulo</h1>
  <form  method="POST" action="agregarTitulo">
    <label for="isbn">ISBN:</label><br>
    <input type="text" id="isbn" name="isbn" required><br><br>

    <label for="titulo">Titulo:</label><br>
    <input type="text" id="titulo" name="titulo" required><br><br>

    <label for="autor">Autor:</label><br>
    <input type="text" id="autor" name="autor" required><br><br>

    <label for="editorial">Editorial:</label><br>
    <input type="text" id="editorial" name="editorial" required><br><br>

    <label for="anio">Año de publicación:</label><br>
    <input type="text" id="anio" name="anio" required><br><br>

    <label for="genero">Genero</label><br>
    <input type="text" id="genero" name="genero" required><br><br>

    <label for="precio">Precio</label><br>
    <input type="text" id="precio" name="precio" required><br><br>

    <input type="submit" value="Enviar">
  </form>
</body>
</html>