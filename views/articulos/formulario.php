<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="articulo[titulo]" placeholder="Ingrese el Titulo" value="<?php echo s($articulo->titulo); ?>">

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="articulo[descripcion]" placeholder=""><?php echo s($articulo->descripcion); ?></textarea>

    <label for="autor">Autor:</label>
    <input type="text" id="autor" name="articulo[autor]" placeholder="Ingrese el Autor" value="<?php echo s($articulo->autor); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="articulo[imagen]">
    <?php if($articulo->imagen): ?>
        <img class="imagen-small" src="/imagenes/articulos/<?php echo $articulo->imagen; ?>" >
    <?php endif; ?>

</fieldset>