<?php
	//? Constantes para la conexión a la base de datos
	const SERVER = "localhost";
	const DB = "prestamos";
	const USER = "root"; 	//!Cambair por la que el hosting te proporciona
	const PASS = "";	 //!Cambair por la que el hosting te proporciona

	const SBGD = "mysql:host=" . SERVER . ";dbname=" . DB; 	// ? Conexión a la base datos	

	//* Configuración de cifrado: método, clave secreta y vector de inicialización
	const METHOD = "AES-256-CBC";     // Método de cifrado
	const SECRET_KEY = '$PRESTAMOS@2025'; 	// Clave secreta
	const SECRET_IV = "037970";      // Vector de inicialización


