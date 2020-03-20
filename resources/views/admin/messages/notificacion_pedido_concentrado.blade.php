<!DOCTYPE html>
<html>
<head>
	<title>Nuevo Pedido de Concentrados</title>
	<style type="text/css">
	#customers {
	  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	  border-collapse: collapse;
	  width: 100%;
	}
	#customers td, #customers th {
	  border: 1px solid #ddd;
	  padding: 8px;
	}
	#customers tr:nth-child(even){background-color: #f2f2f2;}

	#customers tr:hover {background-color: #ddd;}

	#customers th {
	  padding-top: 12px;
	  padding-bottom: 12px;
	  text-align: center;
	  background-color: red;
	  color: white;
	}
</style>
</head>
<body>
	<h2>Pedido de Concentrados | Cercafe</h2>
	<p><strong>Saludos</strong>, a continuación se describe la cantidad solicitada:</p>
	<p>Consecutivo: <strong>PCO{{$cons}}</strong></p>
	<p>Fecha Estimada: <strong>{{$concentrados[0]['fecha_estimada']}}</strong></p>
	<p>Solicitado por: <strong>{{$concentrados[0]['granja_id']}}</strong></p>

	<table id="customers">
		
			<tr style="text-align: center;">
				<td><strong>Código</strong></td>
				<td><strong>Concentrado</strong></td>
				<td><strong># Bultos</strong></td>
				<td><strong># Kilos</strong></td>
			</tr>
			@foreach($concentrados as $concentrado)
				<tr style="text-align: center;">
					<td class="datos">{{$concentrado['consecutivo_pedido']}}</td>
					<td class="datos">{{$concentrado['concentrado_id']}}</td>
					<td class="datos">{{$concentrado['no_bultos']}}</td>
					<td class="datos">{{$concentrado['no_kilos']}}</td>
				</tr>
			@endforeach
	</table>
	
	<p>Esta es una notificación generada automáticamente por <strong><a href="http://201.236.212.130:82/intranetcercafe/">Intranet Cercafe</a></strong>, por favor no responder.</p>
</body>
</html>