<x-mail::message>
# Parece que no estás al día en tus pagos

<x-mail::panel>Estimado usuario, desafortunadamente en el momento no es posible concederle acceso al nuestras instalaciones ya que no encontramos un registro del pago de su suscripción del mes en curso, por favor lo invitamos a que se ponga al dia en ello.</x-mail::panel>

A continuación encontrará sus ultimos 3 pagos registrados
<x-mail::table>
| Monto| Periodo|
| :-------------: |:-------------:|
@foreach ($data['pagos'] as $cliente)
{{$cliente}}
@endforeach
</x-mail::table>

Si tiene alguna inquietud con la información registrada acerquese a nuestro establecimiento.

</x-mail::message>