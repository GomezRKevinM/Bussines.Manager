<?php

	const APP_URL="http://localhost/bussines.manager/";
	const APP_NAME="Bussines Manager";
	const APP_SESSION_NAME="POS";

	/*----------  Tipos de documentos  ----------*/
	const DOCUMENTOS_USUARIOS=["DUI","DNI","Cedula","Licencia","Pasaporte","NIT","Otro"];

	/*----------  Configuración de moneda  ----------*/
	const MONEDA_SIMBOLO="$";
	const MONEDA_NOMBRE="COP";
	const MONEDA_DECIMALES="2";
	const MONEDA_SEPARADOR_MILLAR=",";
	const MONEDA_SEPARADOR_DECIMAL=".";


	/*----------  Marcador de campos obligatorios (Font Awesome) ----------*/
	const CAMPO_OBLIGATORIO='&nbsp; <i class="fas fa-edit"></i> &nbsp;';

	/*----------  Zona horaria  ----------*/
	date_default_timezone_set("America/Bogota");

	/*
		Configuración de zona horaria de tu país, para más información visita
		http://php.net/manual/es/function.date-default-timezone-set.php
		http://php.net/manual/es/timezones.php
	*/