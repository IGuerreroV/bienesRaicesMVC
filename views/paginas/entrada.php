<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $articulo->titulo; ?></h1>

    <img class="imagen" loading="lazy" src="/imagenes/articulos/<?php echo $articulo->imagen; ?>" alt="imagen del articulo">

    <p class="informacion-meta">Escrito el: <span><?php echo $articulo->creado; ?></span> por: <span><?php echo $articulo->autor; ?></span></p>

    <div class="resumen-propiedad">
        <p><?php echo $articulo->descripcion; ?></p>

    </div>
</main>