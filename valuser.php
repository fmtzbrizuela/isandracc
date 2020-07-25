<?php
session_name('valuser');
session_start();
// Pone que se despliegue todo tipo de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Si metodo = POST
//    Validar usuario Si OK retornamos que SI es valido
//        Si error, retornamos NO valido

$data = file_get_contents('php://input');   // Obtenemos el json enviado

$data = json_decode( $data, true );         // Los convertimos en un array
logx(01, 'input Modo: ' . $data['modo'] . ' Email: ' . $data['email'] . ' PW: ' . $data['pw']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['email'] = $data['email'];
    $_SESSION['pw'] = $data['pw'];
    if ($data['modo'] == 1) {
        $idUser = validaCliente(htmlentities($data['email']), htmlentities($data['pw']));
    } elseif ($data['modo'] == 2) {
        $idUser = altaCliente(htmlentities($data['name']), htmlentities($data['email']), htmlentities($data['pw']));
    }
    if ($idUser > 0) {                      // Usuario es valido
        $_SESSION['iduser'] = $idUser;
        echo '{"valido": "SI", "iduser": ' . $idUser . '}';
    } else {
        echo '{"valido": "NO", "iduser": ' . $idUser . '}';
    }
}

function validaCliente($email, $pw) {
    return 1;                               // Retorna idUser -1 si no valido
}

function altaCliente($name, $email, $pw) {
    return 1;                               // Retorna idUser -1 si falla alta
}

function logx($numero,$texto){ 
    $ddf = fopen('error.log','a'); 
    fwrite($ddf,"[".date("r")."] Error $numero: $texto\r\n"); 
    fclose($ddf); 
   } 

?>