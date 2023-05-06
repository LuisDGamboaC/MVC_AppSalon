<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                // cOMPORBAR QUE EXISTA EL USUARIO
                $usuario = Usuario::where('email', $auth->email);

                if($usuario) {
                    // Verificar el password
                   if( $usuario->comprobarPasswordAndVerificado($auth->password)) {
                    // Autenticar el susuario
                    session_start();
                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login'] = true;

                    // Redireccionamiento
                    if($usuario->admin === "1") {
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        header('Location: /admin');
                    }else {
                        header('Location: /cita');
                    }

                   }

                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }

        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $auth->validarEmail();

            if(empty($alertas)){ 
                $usuario =Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === "1"){
                    // GENERAR TOKEN
                    $usuario->creartoken();
                    $usuario->guardar();

                    // Enviarl el correo con las instrucciones
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Alerta exito
                    Usuario::setAlerta('exito', 'Revisa to Email');

                }else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                    
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router) {
        
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        // Buscar ususario por su token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null; // borra el password

                $usuario->password = $password->password; // lo hacemos parte del objeto porque usuario tiene toda la info en la DB
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /');
                }

            }
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password',[
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router) {
        $usuario = new Usuario;
        // alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que la alerta este vacio
            if(empty($alertas)) {
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Generar un token unico
                    $usuario->creartoken();

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email ->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }
        

        $router->render('auth/crear-cuenta', [
            'usuario' =>$usuario,
            'alertas' =>$alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router) {

        $alertas = [];

        $token = s($_GET['token']);
        
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            // Mostar mensaje de error
            Usuario::setAlerta('error', 'Token no Valído');
        }else {
            // Fue confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Confirmada');           
        }
        // Obtener alertas
        $alertas = Usuario::getAlertas();
        // Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);

    }

}