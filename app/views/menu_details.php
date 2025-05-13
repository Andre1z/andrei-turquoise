<?php
// app/views/menu_details.php

// Verifica que exista la variable $menu con los datos del menú.
if (!isset($menu)) {
    echo "No se encontró el menú.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Menú - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* Estilos básicos personalizados para la vista de detalles del menú */
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 2em auto;
            background: #fff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 1em;
        }
        .menu-info {
            margin-bottom: 1em;
        }
        .menu-info h2 {
            margin: 0 0 0.5em;
        }
        .menu-info p {
            font-size: 1.1em;
            line-height: 1.5em;
        }
        .actions {
            text-align: center;
            margin-top: 2em;
        }
        .actions a {
            text-decoration: none;
            margin: 0 1em;
            padding: 0.5em 1em;
            background: #333;
            color: #fff;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .actions a:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detalles del Menú</h1>
        <div class="menu-info">
            <h2><?php echo htmlspecialchars($menu->name); ?></h2>
            <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($menu->description)); ?></p>
            <?php if (isset($menu->created_at)): ?>
                <p><strong>Creado el:</strong> <?php echo htmlspecialchars($menu->created_at); ?></p>
            <?php endif; ?>
        </div>
        <div class="actions">
            <a href="/restaurants">Volver a Restaurantes</a>
            <a href="/menus/edit/<?php echo htmlspecialchars($menu->id); ?>">Editar Menú</a>
        </div>
    </div>
</body>
</html>