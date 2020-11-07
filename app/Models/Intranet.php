<?php namespace App\Models;

use CodeIgniter\Model;

class Intranet
{
    public function validarLogin($user,$pass){
        $user = strtolower($user);
        $pass = md5($pass);
        $lista = query_database("SELECT * FROM Intranet.Usuario WHERE estado = 1 and usuario = '$user' and pass = '$pass'");
        return count($lista) ? $lista[0] : [];
    }
}
