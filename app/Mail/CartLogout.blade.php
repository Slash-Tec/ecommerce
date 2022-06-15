<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>¡El carrito sigue lleno!</title>
</head>
<body>
    <p>¡Hola! Hemos visto que hoy has abandonado sesión a las {{ $cartlogout->created_at }}.</p>
    <p>Tambien nos hemos dado cuenta de que te has dejado objetos en el carrito, ¡Nosotros te los guardamos!, pero... Es posible que alguien los compre en tu ausencia y que debas esperar a que repongamos productos...</p>
    <ul>
        <li>Nombre: {{ $cartlogout->user->name }}</li>
        <li>Teléfono: {{ $cartlogout->user->phone }}</li>
    </ul>
</body>
</html>