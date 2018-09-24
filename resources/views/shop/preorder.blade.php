<!doctype html>
<html lang="es">
    <head>
		<meta charset="utf-8">
		<title>Rhemo - Preorden</title>
		<meta name="description" content="Rhemo horse care, cuidado de caballo">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scala=1.0, minimum-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,600" rel="stylesheet">
        <style type="text/css">

            /***************Clases generales*****************/
            body{
                font-family: 'Raleway', sans-serif;
                font-size: 1em !important;
                margin: 0 auto;
            }
            p{
               font-family: 'Raleway', sans-serif;
            }
            h1, h2, h3, h4, h5{
                font-family: 'Raleway', sans-serif;
                font-weight: 600;
            }
            h2{
                font-size: 2.5em;
            }
            a{
                color:inherit;

            }
            .centrar{
                display: flex;
                justify-content:center;
                align-items:center;
            }
            .centrar-columna{
                flex-direction:column;
            }
            .centrar-espaciado-entre{
                justify-content:space-between;
            }
            .centrar-espaciado-alrededor{
                justify-content:space-around;
            }
            .centrar-espaciado-inicio{
                justify-content:flex-start;
            }
            .centrar-espaciado-fin{
                justify-content:flex-end;
            }
            .centrar-align-left{
                align-items:flex-start;
            }
            .centrar-align-right{
                align-items:flex-end;
            }
            .width-100{
                width: 100%;
            }
            .width-100-50{
                width: 100%;
                height: 140px;
            }
            .width-100-25{
                width: 100%;
                height: 120px;
            }
            .text-activado{
                color:#E5AC29;
            }
            .text-desactivado{
                color:#FFF;
            }
            .padding{
                padding: 10px 20px 10px 20px;
            }
            .cancelar-estilos{
                padding: 0px !important;
                height: inherit;
                margin: 0;
            }
            .margin-20{
                margin: 20px;
            }
            .margin-top{
                margin-top: 85px;
            }
            .margin-right {
                margin-right: 10px;
            }
            .margin-bottom{
                margin-bottom: 10px;
            }
            .margin-top-15{
                margin-top: 15px;
            }
            .content{
                width: 600px;
                height: auto;
            }

            /**************************************/

            header{
                height: 100px;
                background: -webkit-linear-gradient(left, rgba(26,27,44,1),rgba(41,43,84,1));
                color: #FFF;
                justify-content:space-between;
                padding: 10px;
            }
            header div{
                width: 200px;
            }
            header div img{
                width: 100%;
            }
            section{
                color:#585757;
            }
            section p{
                font-size: 1.5em;
            }
            button{
                width: 230px;
                height: 50px;
                border: 1px solid #FFF;
            }
            .btn-confirm{
                color:#FFF;
                background-color:rgba(41,43,84,1);
                font-size: 1.5em;
            }
            footer{
                background-color: #E5AC29;
                color:#FFF;
            }
            .logo-footer{
                width: 50px;
            }
            .logo-footer img{
                width: 100%;
            }
            #correo_usuario{
                font-weight: 600;
            }
            @media screen and (max-width: 480px) {

               .content{
                    width: 100%;
                    height: auto;
                }

            }
        </style>
	</head>
    <body class="centrar centrar-columna">
        <div class="content">
            <header class="centrar">
                <div>
                    <img src="{{ URL::asset('images/logo_rhemo.png')}}" alt="">
                </div>
            </header>
            <section class="padding">
                <div class="centrar centrar-columna centrar-align-left">
                    <h2>Nueva orden de compra</h2>
                    <p>Nombre: {{ $subscription['name'] }}</p>
                    <p>Teléfono: {{ $subscription['phone'] }}</p>
                    <p>Correo: {{ $subscription['email'] }}</p>
                    <p>Dirección y ciudad: {{ $subscription['location'] }}</p>
                    <p style="text-align: center;">Comentario: {{$subscription['comment'] }}</p>
                </div>
            </section>
            <footer class="padding centrar centrar-columna">
                <div>
                    <p>Rhemo es una marca Fechner. Todos los derechos reservados</p>
                </div>
                <div class="margin-20 centrar logo-footer">
                    <img src="{{URL::asset('images/r_rhemo.png') }}">
                </div>
            </footer>
        </div>
    </body>
</html>