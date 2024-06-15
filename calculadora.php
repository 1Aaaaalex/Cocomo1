<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora COCOMO 1</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eceff1;
            color: #37474f;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 90%;
            max-width: 600px;
            text-align: center;
            box-sizing: border-box;
        }
        h1 {
            color: #00796b;
            font-size: 1.8em;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 1em;
        }
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #b0bec5;
            border-radius: 8px;
            background-color: #f0f4c3;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #00796b;
            color: white;
            border: none;
            padding: 12px 20px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            width: 100%;
            font-size: 1em;
            box-sizing: border-box;
        }
        input[type="submit"]:hover {
            background-color: #004d40;
        }
        .results {
            margin-top: 30px;
            text-align: left;
        }
        .results p {
            background-color: #e0f7fa;
            padding: 12px;
            border: 1px solid #80deea;
            border-radius: 8px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Calculadora COCOMO 1</h1>
        <form action="" method="post">
            <label for="tipoProyecto">Tipo de Proyecto:</label>
            <select name="tipoProyecto" id="tipoProyecto" required>
                <option value="1">Orgánico (50 - 80)</option>
                <option value="2">Semi-acoplado (81 - 100)</option>
                <option value="3">Acoplado (101 - 150)</option>
            </select><br><br>

            <label for="p">Parámetro:</label>
            <input type="number" name="p" id="p" required><br><br>

            <label for="entrada">Entradas:</label>
            <input type="number" name="entrada" id="entrada" required><br><br>

            <label for="salida">Salidas:</label>
            <input type="number" name="salida" id="salida" required><br><br>

            <label for="CH">Sueldo:</label>
            <input type="number" name="CH" id="CH" required><br><br>

            <input type="submit" value="Calcular">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $a = 0; $b = 0; $c = 0; $d = 0;
            $entrada = $_POST['entrada']; 
            $salida = $_POST['salida'];
            $p = $_POST['p'];
            $CH = $_POST['CH'];
            $tipoProyecto = $_POST['tipoProyecto'];

            $isValid = false;

            switch ($tipoProyecto) {
                case 1: // Orgánico
                    $a = 2.4; $b = 1.05; $c = 2.5; $d = 0.38;
                    $isValid = ($p >= 50 && $p <= 80);
                    break;
                case 2: // Semi-acoplado
                    $a = 3.0; $b = 1.12; $c = 2.5; $d = 0.35;
                    $isValid = ($p >= 81 && $p <= 100);
                    break;
                case 3: // Acoplado
                    $a = 3.6; $b = 1.20; $c = 2.5; $d = 0.32;
                    $isValid = ($p >= 101 && $p <= 150);
                    break;
                default:
                    echo "<p>Tipo de proyecto no válido</p>";
                    break;
            }

            if ($isValid) {
                $LDC = ($entrada + $salida) * $p;
                $LDC = round($LDC);

                $MLDC = $LDC / 1000;

                $Ei = pow($a * $MLDC, $b);
                $Ei = round($Ei);
                
                $Td = $c *  pow($Ei, $d);
                $Td = round($Td);

                $Pn = $Ei / $Td;
                $Pn = round($Pn);

                $Prod = $LDC / $Ei;
                $Prod = round($Prod);

                //$CH = 2500; // Salario mínimo nacional (en la moneda local)

                $C = $CH * $Ei;
                $C = round($C, 2);

                $CLDC = $C / $LDC;
                $CLDC = round($CLDC, 2);

                echo "<div class='results'>";
                echo "<h2>Resultados:</h2>";
                echo "<p>LDC: $LDC líneas de código</p>";
                echo "<p>MLDC: $MLDC miles de líneas de código</p>";
                echo "<p>Esfuerzo nominal (Ei): $Ei personas-meses</p>";
                echo "<p>Tiempo de desarrollo (Td): $Td meses</p>";
                echo "<p>Personal necesario (Pn): $Pn personas</p>";
                echo "<p>Productividad (P): $Prod líneas de código por persona-mes</p>";
                echo "<p>Costo total (C): $C Bs.</p>";
                echo "<p>Costo por línea de código (CLDC): $$CLDC Bs.</p>";
                echo "</div>";
            } else {
                echo "<p>Ingrese un Número dentro del rango adecuado para el tipo de proyecto seleccionado en Parametro.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
