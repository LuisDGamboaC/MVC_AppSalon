<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label from="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email">
    </div>

    <div class="campo">
        <label from="password">Password</label>
        <input type="password" id="password" placeholder="Tu Password" name="password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">

</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear Cuenta</a>
    <a href="/olvide">¿Olvidaste la contraseña?</a>

</div>