<h1 class="nombre-pagina">Panel de Administración</h1>
<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>"> 
        </div>
    </form>
</div>

<?php 
    if(count($citas) === 0) {
        echo "<h2>No hay citas en esa fecha </h2>";
    }?>


<div id="citas-admin">
    <ul class="citas">
    <?php
        $idCita = 0;
        foreach( $citas as $key => $cita) {

            if($idCita !== $cita->id){ // !== es diferente
                $total = 0;           
    ?>
    <li>
        <p> ID: <span> <?php echo $cita->id; ?></span></p>
        <p> HORA: <span> <?php echo $cita->hora; ?></span></p>
        <p> CLIENTE: <span> <?php echo $cita->cliente; ?></span></p>
        <p> EMAIL: <span> <?php echo $cita->email; ?></span></p>
        <p> TELEFONO: <span> <?php echo $cita->telefono; ?></span></p>
        <h3>Servicios</h3>
        <?php 
            $idCita = $cita->id;
            } // Fin de IF 
            $total += $cita->precio;
        ?>
        <p class="servicio"><?php echo $cita->servicio . " " . $cita->precio; ?> </p>
 <!-- Eliminamos el </li> para que no haya espacio entre los servicios -->
    <?php 
        $actual = $cita->id;
        $proximo = $citas[$key + 1]->id ?? 0; // detecta cual es el ultimo id con el mismo numero de id 

        if(esUltimo($actual, $proximo)) { ?>
            <p class ="total">Total: <span>$ <?php echo $total; ?></span></p>

            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                <input type="submit" class="boton-eliminar" value="Eliminar">
            </form>
        <?php } 
        } // Fin de FOREACH ?>
    </ul>
</div>

<?php 
    $script = "<script src='build/js/buscador.js'></script>"
?>