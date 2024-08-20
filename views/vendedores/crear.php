<main class="contenedor seccion">
    <h1>Registrar Vendedor(a)</h1>

    <a class="boton boton-verde" href="/admin">Volver</a>

    <?php foreach($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/vendedores/crear" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario.php'; ?>

        <input class="boton boton-verde" type="submit" value="Registrar Vendedor(a)">
    </form>
</main>