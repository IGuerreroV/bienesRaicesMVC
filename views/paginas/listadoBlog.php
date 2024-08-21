<main class="contenedor seccion contenido-centrado">
    <?php foreach($articulos as $articulo) : ?>
    <article class="entrada-blog">

        <img class="imagen" loading="lazy" src="/imagenes/articulos/<?php echo $articulo->imagen; ?>" alt="imagen del articulo">

        <div class="texto-entrada">
            <a href="/entrada?id=<?php echo $articulo->id ?>">
                <h4><?php echo $articulo->titulo; ?></h4>
                <p>Escrito el: <span><?php echo $articulo->creado; ?></span> por: <span><?php echo $articulo->autor; ?></span></p>

                <p><?php echo $articulo->descripcion; ?></p>
            </a>
        </div>
    </article>
    <?php endforeach; ?>
</main>