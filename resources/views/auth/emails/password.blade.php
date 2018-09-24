<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Rhemo - Mailing</title>
    <meta name="description" content="Rhemo horse care, cuidado de caballo">
    <meta name="viewport" content="width=device-width, getCurrentUser-scalable=no, initial-scale=1.0, maximun-scala=1.0, minimum-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600" rel="stylesheet">
</head>
<body style="font-family: 'Raleway', sans-serif; font-size: 1em !important;margin: 0 auto;">
<table style="width:100%;height: 150px; background: -webkit-linear-gradient(left, rgba(26,27,44,1),rgba(41,43,84,1));color: #FFF; padding: 10px;">
    <tr>
        <td align="center">
            <img style="display:block;width: 200px;" src="{{ URL::asset('images/logo_rhemo.png') }}"  />
        </td>
    </tr>
</table>
<table style="width:100%; padding: 10px 20px 10px 20px;">
    <tr>
        <td>
            <h2 style="font-family: 'Raleway', sans-serif; font-weight: 600; font-size: 2.5em; margin-bottom:0;">Hola {!!$name!!}</h2>
        </td>
    </tr>
    <tr>
        <td>
            <p style="font-size: 1.5em;color:#585757; text-align:justify;">El siguiente código te permitirá recuperar tu contraseña</p>
        </td>
    </tr>
    <tr>
        <td align="center">
            <p style="font-size: 3em;color:#E5AC29; text-align:center;">{!!$code!!}</p>
        </td>
    </tr>
</table>
<table style="background-color: #E5AC29;color:#FFF; padding: 10px 20px 10px 20px; width: 100%;">

    <tr>
        <td>
            <p>¿Tienes alguna duda?</p>
            <p>Contactanos: <a href="mailto:info@rhemo.co" style="color:inherit;">info@rhemo.co</a></p>
            <p style="text-align:justify;">Este mesaje fue enviado al correo <span style="font-weight: 600;">{!!$email!!}</span> porque se recibió una solicitud para hacer cambio de contraseña. Si no has solicitado un cambio de contraseña por favor ignorar este correo</p>
            <p>El uso de la información en Rhemo esta sujeta a nuestros <a href="http://rhemo.co/pages/terminos.html" target="_blank" style="color:inherit;">Términos de uso</a> y <a target="_blank" href="http://rhemo.co/pages/politica_datos.html" style="color:inherit;">Políticas de privacidad</a></p>
            <p>Rhemo es una marca Fechner. Todos los derechos reservados</p>
        </td>
    </tr>
    <tr>
        <td style="width: 50px;" align="center">
            <img style="width: 60px;" src="{{ URL::asset('images/r_rhemo.png') }}">
        </td>
    </tr>
</table>
</body>
</html>