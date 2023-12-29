<?php
require_once('db_conn.php');

// Intentar conectar
$conexion = conectarDB();

// Si la conexión es exitosa, mostrar un mensaje
echo "Conexión exitosa a la base de datos.";

// Cerrar la conexión
$conexion->close();
