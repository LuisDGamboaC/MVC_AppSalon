<h1 class="nombre-pagina"> Recuperar mi Password </h1>
<p class="descripcion-pagina"> Coloca tu nuevo password a continuación</p>

<?php  include_once __DIR__ . '/../templates/alertas.php'; ?>
<?php if($error) return; ?> <!-- no muestra el formulario si el token no es valido  -->

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Ingresa tu nuevo password"/>
    </div>
    <input type="submit" class="boton" value="Guardar nuevo password" >

    <div class="acciones">
        <a href="/"> ¿Ya tienes cuenta? Iniciar sesión</a>
        <a href="/crear-cuenta"> ¿Aún no tienes cuenta? Crear Cuenta</a>
    </div>

</form>