<?php

$peticionAjax = true;
require_once("../config/app.php");

$id = (isset($_GET["id"])) ? $_GET["id"] : 0;

//*--------------Instancia al controlador préstamo------------//

require_once("../controller/prestamoController.php");
$insPrestamo = new prestamosControlador();

$datos_prestamo = $insPrestamo->seleccionarDatosCampos("UnicoFactura", "prestamo", "prestamo_id", $id, "");

if ($datos_prestamo->rowCount() == 1) {

	$datos_prestamo = $datos_prestamo->fetch();

	//*--------------Instancia al controlador empresa------------//
	require_once("../controller/empresaController.php");
	$ins_empresa = new EmpresaController();

	$datos_empresa = $ins_empresa->datosEmpresaControlador();
	$datos_empresa = $datos_empresa->fetch();


	//*--------------Instancia al controlador usuario------------//
	require_once("../controller/userController.php");
	$ins_usuario = new userController();

	$datos_usuario = $ins_usuario->datosUsuarioControlador("Unico", $ins_usuario->encryption($datos_prestamo["usuario_id"]));
	$datos_usuario = $datos_usuario->fetch();


	//*--------------Instancia al controlador cliente------------//
	require_once("../controller/clienteController.php");
	$ins_cliente = new ClienteController();

	$datos_cliente = $ins_cliente->datosClienteControlador("Unico", $ins_usuario->encryption($datos_prestamo["cliente_id"]));
	$datos_cliente = $datos_cliente->fetch();





	require "./fpdf.php";

	$pdf = new FPDF('P', 'mm', 'Letter');
	$pdf->SetMargins(17, 17, 17);
	$pdf->AddPage();
	$pdf->Image('../views/assets/img/admin/logo.png', 10, 10, 30, 30, 'PNG');

	$pdf->SetFont('Arial', 'B', 18);
	$pdf->SetTextColor(0, 107, 181);
	$pdf->Cell(0, 10, utf8_decode(strtoupper($datos_empresa["empresa_nombre"])), 0, 0, 'C');
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(-35, 10, utf8_decode('N. de factura'), '', 0, 'C');

	$pdf->Ln(10);

	$pdf->SetFont('Arial', '', 15);
	$pdf->SetTextColor(0, 107, 181);
	$pdf->Cell(0, 10, utf8_decode(""), 0, 0, 'C');
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(-35, 10, utf8_decode($datos_prestamo["prestamo_id"]), '', 0, 'C');

	$pdf->Ln(25);

	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(36, 8, utf8_decode('Fecha de emisión:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(27, 8, utf8_decode(date("d/m/Y", strtotime($datos_prestamo["prestamo_fecha_inicio"]))), 0, 0);
	$pdf->Ln(8);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(27, 8, utf8_decode('Atendido por:'), "", 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(13, 8, utf8_decode($datos_usuario["usuario_nombre"] . " " . $datos_usuario["usuario_apellido"]), 0, 0);

	$pdf->Ln(15);

	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(15, 8, utf8_decode('Cliente:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(65, 8, utf8_decode($datos_cliente["cliente_nombre"] . " " . $datos_cliente["cliente_apellido"]), 0, 0);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(10, 8, utf8_decode('DNI:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(40, 8, utf8_decode($datos_cliente["cliente_dni"]), 0, 0);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(19, 8, utf8_decode('Teléfono:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(35, 8, utf8_decode($datos_cliente["cliente_telefono"]), 0, 0);
	$pdf->SetTextColor(33, 33, 33);

	$pdf->Ln(8);

	$pdf->Cell(8, 8, utf8_decode('Dir:'), 0, 0);
	$pdf->SetTextColor(97, 97, 97);
	$pdf->Cell(109, 8, utf8_decode($datos_cliente["cliente_direccion"]), 0, 0);

	$pdf->Ln(15);


	$pdf->SetFillColor(38, 198, 208);
	$pdf->SetDrawColor(38, 198, 208);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(15, 10, utf8_decode('Cant.'), 1, 0, 'C', true);
	$pdf->Cell(90, 10, utf8_decode('Descripción'), 1, 0, 'C', true);
	$pdf->Cell(51, 10, utf8_decode('Tiempo - Costo'), 1, 0, 'C', true);
	$pdf->Cell(25, 10, utf8_decode('Subtotal'), 1, 0, 'C', true);

	$pdf->Ln(10);

	$pdf->SetTextColor(97, 97, 97);

	$codigo = $datos_prestamo["prestamo_codigo"];
	//*-----------------Detales del préstamo--------------------//
	$datos_detale = $insPrestamo->seleccionarDatos("Unico", "detalle", "prestamo_codigo", $codigo);
	$datos_detale = $datos_detale->fetchAll();

	$total = 0;

	foreach ($datos_detale as $row) {
		$subTotal = $row["detalle_cantidad"] * $row["detalle_costo_tiempo"] * $row["detalle_tiempo"];
		$subTotal = number_format($subTotal, 2, ".", "");


		$pdf->Cell(15, 10, utf8_decode(string: $row["detalle_cantidad"]), 'L', 0, 'C');
		$pdf->Cell(90, 10, utf8_decode($row["detalle_descripcion"]), 'L', 0, 'C');
		$pdf->Cell(51, 10, utf8_decode($row["detalle_tiempo"] . " " . $row["detalle_formato"] . " (" . MONEDA . $row["detalle_costo_tiempo"] . " c/u)"), 'L', 0, 'C');
		$pdf->Cell(25, 10, utf8_decode(MONEDA . $subTotal), 'LR', 0, 'C');

		$pdf->Ln(10);

		$total += $subTotal;
	}

	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(15, 10, utf8_decode(''), 'T', 0, 'C');
	$pdf->Cell(90, 10, utf8_decode(''), 'T', 0, 'C');
	$pdf->Cell(51, 10, utf8_decode('TOTAL'), 'LTB', 0, 'C');
	$pdf->Cell(25, 10, utf8_decode(MONEDA . number_format($total, "2", ".", "")), 'LRTB', 0, 'C');

	$pdf->Ln(15);

	$pdf->MultiCell(0, 9, utf8_decode("OBSERVACIÓN: " . $datos_prestamo["prestamo_observacion"]), 0, 'J', false);

	$pdf->SetFont('Arial', '', 12);
	if ($datos_prestamo["prestamo_pagado"] < $datos_prestamo["prestamo_total"]) {
		$pdf->Ln(12);

		$pdf->SetTextColor(97, 97, 97);
		$pdf->MultiCell(0, 9, utf8_decode("NOTA IMPORTANTE: \nEsta factura presenta un saldo pendiente de pago por la cantidad de " . MONEDA . number_format(($datos_prestamo["prestamo_total"] - $datos_prestamo["prestamo_pagado"]), "2", ".", "")), 0, 'J', false);
	}

	$pdf->Ln(25);

	/*----------  INFO. EMPRESA  ----------*/
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(33, 33, 33);
	$pdf->Cell(0, 6, utf8_decode($datos_empresa["empresa_nombre"]), 0, 0, 'C');
	$pdf->Ln(6);
	$pdf->SetFont('Arial', '', 9);
	$pdf->Cell(0, 6, utf8_decode($datos_empresa["empresa_direccion"]), 0, 0, 'C');
	$pdf->Ln(6);
	$pdf->Cell(0, 6, utf8_decode("Teléfono: " . $datos_empresa["empresa_telefono"]), 0, 0, 'C');
	$pdf->Ln(6);
	$pdf->Cell(0, 6, utf8_decode("Correo: " . $datos_empresa["empresa_email"]), 0, 0, 'C');


	$pdf->Output("I", "Factura_" . $datos_prestamo["prestamo_id"] . ".pdf", true);
} else { ?>
	<!DOCTYPE html>
	<html lang="es">

	<?php require_once("../views/inc/admin/head.php") ?>


	<body>

		<div class="conetendor-siin-wifi">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" id="no-internet-connection">
				<g>
					<path fill="#ccd3eb" d="M8 24.88a2.78 2.78 0 0 1-2-.83l-.2-.25a2.85 2.85 0 0 1-.8-2.12 2.69 2.69 0 0 1 1-2 39.92 39.92 0 0 1 52-.15 2.71 2.71 0 0 1 1 1.91 2.8 2.8 0 0 1-.7 2.08l-.23.26a2.77 2.77 0 0 1-2.1 1 3 3 0 0 1-1.89-.7 33.93 33.93 0 0 0-44 .11 2.88 2.88 0 0 1-2.08.69Z"></path>
					<path fill="#ccd3eb" d="M47.42 33.41a2.66 2.66 0 0 1-1.69-.59 22 22 0 0 0-27.46 0 2.66 2.66 0 0 1-1.69.59 2.84 2.84 0 0 1-2-.84l-.25-.25a2.85 2.85 0 0 1-.82-2.15 2.89 2.89 0 0 1 1.07-2.07 28 28 0 0 1 34.86 0 2.89 2.89 0 0 1 1.07 2.07 2.85 2.85 0 0 1-.82 2.15l-.25.25a2.84 2.84 0 0 1-2.02.84Z"></path>
					<path fill="#ccd3eb" d="M38.87 42a3.06 3.06 0 0 1-1.6-.46 10.18 10.18 0 0 0-10.54 0 3.06 3.06 0 0 1-1.6.46 2.76 2.76 0 0 1-2-.8l-.25-.25a2.84 2.84 0 0 1 .48-4.39 16 16 0 0 1 17.22 0 2.84 2.84 0 0 1 .48 4.39l-.25.25a2.76 2.76 0 0 1-2 .8Z"></path>
					<circle cx="32" cy="50" r="4" fill="#0074ff"></circle>
					<path fill="#033c59" d="M58.56 18.79a41.19 41.19 0 0 0-13.39-7.6l2.2-3.8a1 1 0 0 0-1.74-1l-2.42 4.19a40.81 40.81 0 0 0-22.49 0 1 1 0 0 0-.72 1.23 1 1 0 0 0 1.24.69 38.92 38.92 0 0 1 20.9-.14L40.1 16a34.88 34.88 0 0 0-30.84 7.41 1.84 1.84 0 0 1-2.5-.06l-.25-.26A1.85 1.85 0 0 1 6 21.72a1.75 1.75 0 0 1 .6-1.27 40.17 40.17 0 0 1 4.91-3.6 1 1 0 1 0-1.06-1.7 41.35 41.35 0 0 0-5.15 3.79 3.72 3.72 0 0 0-1.3 2.7 3.89 3.89 0 0 0 1.12 2.87l.26.25A3.79 3.79 0 0 0 8 25.88a3.91 3.91 0 0 0 2.53-.95 32.9 32.9 0 0 1 28.5-7.16L37 21.42a29 29 0 0 0-5-.42 28.67 28.67 0 0 0-18 6.32 3.82 3.82 0 0 0-.38 5.68l.24.25a3.8 3.8 0 0 0 5 .32A20.75 20.75 0 0 1 32 29h.56l-2.35 4.09a16.81 16.81 0 0 0-7.35 2.56 3.84 3.84 0 0 0-.66 5.95l.25.24a3.7 3.7 0 0 0 2.1 1l-7.92 13.7a1 1 0 0 0 .87 1.5 1 1 0 0 0 .87-.5l8.78-15.2.11-.06a9.13 9.13 0 0 1 9.48 0 3.88 3.88 0 0 0 4.81-.49l.25-.24a3.85 3.85 0 0 0 1.1-3.12 3.89 3.89 0 0 0-1.75-2.83 17 17 0 0 0-8.58-2.6l2.2-3.82A20.69 20.69 0 0 1 45.1 33.6a3.72 3.72 0 0 0 2.32.81 3.85 3.85 0 0 0 2.72-1.13l.24-.25a3.82 3.82 0 0 0-.33-5.71 28.59 28.59 0 0 0-11-5.46l2.06-3.57a33.06 33.06 0 0 1 12.24 6.53 3.83 3.83 0 0 0 5.38-.35l.23-.27a3.86 3.86 0 0 0 .95-2.81 3.78 3.78 0 0 0-1.35-2.6Zm-34.7 21.66-.24-.25a1.79 1.79 0 0 1-.53-1.49 1.84 1.84 0 0 1 .84-1.35 14.83 14.83 0 0 1 5-2l-3.19 5.52a1.84 1.84 0 0 1-1.88-.43ZM32 35a15 15 0 0 1 8.07 2.36 1.84 1.84 0 0 1 .84 1.35 1.79 1.79 0 0 1-.53 1.49l-.24.25a1.9 1.9 0 0 1-2.35.2 11.18 11.18 0 0 0-9-1.16L31.41 35Zm0-8a23 23 0 0 0-14.35 5 1.79 1.79 0 0 1-2.37-.18l-.28-.2a1.83 1.83 0 0 1-.53-1.4 1.86 1.86 0 0 1 .69-1.34A26.7 26.7 0 0 1 32 23a27.54 27.54 0 0 1 3.87.29l-2.18 3.78C33.13 27 32.57 27 32 27Zm16.81 1.88a1.86 1.86 0 0 1 .69 1.34 1.83 1.83 0 0 1-.53 1.4l-.25.24a1.8 1.8 0 0 1-2.37.18 23 23 0 0 0-10.5-4.71L38 23.68a26.69 26.69 0 0 1 10.81 5.2Zm8.61-6-.23.26a1.84 1.84 0 0 1-2.59.15 35.21 35.21 0 0 0-12.5-6.79l2-3.54a38.92 38.92 0 0 1 13.11 7.35 1.74 1.74 0 0 1 .61 1.22 1.79 1.79 0 0 1-.4 1.35Z"></path>
					<path fill="#033c59" d="M15 14.79a1.11 1.11 0 0 0 .43-.09c.64-.3 1.29-.59 1.95-.86a1 1 0 1 0-.76-1.84c-.69.28-1.37.58-2.05.9a1 1 0 0 0 .43 1.9zM32 45a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3z"></path>
				</g>
			</svg>
			<span class="sinconexion"></span>
			<a href="">Reintentar</a>
		</div>
		<div class="container-404">
			<div class="img404">
				<img src="<?php echo SERVERURL ?>views/assets/img/admin/404.png" alt="404">
			</div>
			<div class="text-boton">
				<span class="loader404"></span>
				<h2>¡UPS! PÁGINA NO ENCONTRADA</h2>
				<span class="loaderlibro"></span>
				<p>Debes haber elegido la puerta equivocada porque no he podido poner el ojo en la página que estabas buscando.</p>
				<a href="<?php echo SERVERURL ?>index">VOLVER A INICIO</a>

			</div>
		</div>

		<script src="<?php echo SERVERURL ?>views/js/admin/comprobarConexion.js"></script>


	</body>

	</html>
<?php } ?>