<table>
    <thead>
        <tr>
            <th>Referencia</th>
            <th>Nombre Item</th>
            <th>Saldo Yeminus</th>
            <th>Costo Unitario</th>
            <th>Costo Total</th>
            <th>Conteo</th>
            <th>Diferencia</th>
            <th>Costo Diferencia</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($registros as $item)
            <tr>
                <td>{{$item->ref}}</td>
                <td>{{$item->nombre_producto}}</td>
                <td>{{$item->saldo_geminus}}</td>
                <td>{{$item->costo_unitario}}</td>
                <td>{{$item->costo_total}}</td>
                <td>{{$item->conteo}}</td>
                <td>{{$item->diferencia}}</td>
                <td>{{$item->costo_diferencia}}</td>
            </tr>
        @endforeach
    </tbody>
</table>