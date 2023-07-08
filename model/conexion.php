<?php

class Conexion
{
  static public function conn()
  {
    $link = new PDO("mysql:host=localhost;dbname=db_joyeriasimoni","root","");
    //$link = new PDO("mysql:host=localhost;dbname=id21010350_pruebasubidadedatos","id21010350_user","Contra.123Nueva");
		$link->exec("set names utf8");
		return $link;
  }
}