<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda - Productos Caros con GET</title>
</head>
<body>
    <h1>Catálogo de Electrónica y Línea Blanca</h1>

    <?php
    
    $catalogo = [
        "Smart TV 55 Pulgadas" => 6500.00,
        "Consola de Videojuegos" => 8900.00,
        "Laptop Gamer" => 14500.00,
        "Refrigerador" => 7200.00,
        "Audífonos Inalámbricos" => 850.00,
        "Teclado Mecánico" => 600.00,
        "Mouse Gamer" => 450.00
    ];
    ?>

    <form method="GET">
        <label for="cliente">Nombre del Cliente:</label>
        <input type="text" id="cliente" name="cliente" required>
        <br><br>

        <p><strong>Selecciona los productos que deseas comprar:</strong></p>
        <?php foreach ($catalogo as $nombreProducto => $precioProducto): ?>
            <label>
                
                <input type="checkbox" name="productos[]" value="<?php echo $nombreProducto; ?>">
                <?php echo $nombreProducto . " - $" . number_format($precioProducto, 2); ?>
            </label>
            <br><br>
        <?php endforeach; ?>

        <button type="submit">Calcular Compra</button>
    </form>
    
    <?php
  
    if (isset($_GET['cliente'])) {
        $cliente = trim((string) $_GET['cliente']);
        $productosSeleccionados = $_GET['productos'] ?? [];

        if ($cliente === "" || empty($productosSeleccionados)) {
            echo "<p style='color: red;'>Por favor, ingresa tu nombre y selecciona al menos un producto.</p>";
        } else {
            $subtotalGeneral = 0;

            echo "<h2>Resumen de la Compra</h2>";
            echo "<p><strong>Cliente:</strong> " . htmlspecialchars($cliente, ENT_QUOTES, "UTF-8") . "</p>";
            echo "<ul>";

            
            foreach ($productosSeleccionados as $prod) {
               
                if (array_key_exists($prod, $catalogo)) {
                    $precioUnitario = $catalogo[$prod];
                    $subtotalGeneral += $precioUnitario;
                    
                    echo "<li>" . htmlspecialchars($prod, ENT_QUOTES, "UTF-8") . " - $" . number_format($precioUnitario, 2) . "</li>";
                }
            }
            echo "</ul>";

            $descuento = 0;

            
            if ($subtotalGeneral > 500) {
                $descuento = $subtotalGeneral * 0.10;
            }

            $total = $subtotalGeneral - $descuento;

            echo "<p><strong>Subtotal:</strong> $" . number_format($subtotalGeneral, 2) . "</p>";
            
            if ($descuento > 0) {
                echo "<p style='color: green;'><strong>Descuento aplicado (10%):</strong> -$" . number_format($descuento, 2) . "</p>";
            } else {
                echo "<p><strong>Descuento:</strong> $0.00 <small>(El 10% de descuento aplica a partir de $500)</small></p>";
            }

            echo "<h3>Total a pagar: $" . number_format($total, 2) . "</h3>";
        }
    }
    ?>
</body>
</html>