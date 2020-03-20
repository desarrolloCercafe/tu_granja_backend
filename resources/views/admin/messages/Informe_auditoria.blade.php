<!DOCTYPE html>
<html>
<head>
	<title>Nueva Auditoria</title>
</head>
<body>

    <div>
        <h1>Granja: {{$nombre_granja}}</h1>
        <h3>Fecha: {{$fecha}}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre Proceso</th>
                <th>Calificación</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($calificaciones as $calificacion)
                <tr>
                    <td>{{$calificacion->nombre}}</td>
                    <td>{{$calificacion->calificacion}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

	<h2>Se ha creado un nuevo informe de visita técnica | Cercafe</h2>
	<p>Esta es una notificación generada Automaticamente por <strong><a href="http://201.236.212.130:82/intranetcercafe/">Tu Granja</a></strong>, por favor no responder</p>
</body>
</html>