<h1 class="nombre-pagina">Olvide el Password</h1>
<p class="descripcion-pagina"> Crea un nuevo Passwrod escribiendo tu correo de E-mail que tienes registrado</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
                <label from="email">Email</label>
                <input type="email" id="email" placeholder="Tu Email" name="email">
    </div>

    <input type="submit" value="Enviar Instrucciones" class="boton">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>

</div>
