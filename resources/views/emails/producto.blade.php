<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Factura - Green Food Market</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #2e2e2e;
            background-color: #ffffff;
            padding: 20px;
        }

        .factura-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            max-width: 700px;
            margin: 0 auto;
            border: 1px solid #e0e0e0;
        }

        .factura-header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 3px solid #4CAF50; /* verde naturaleza */
        }

        .factura-header h1 {
            margin: 0;
            color: #4CAF50;
            font-size: 28px;
        }

        .factura-header p {
            margin: 4px 0;
            font-size: 14px;
            color: #555;
        }

        .factura-info {
            margin: 20px 0;
        }

        .factura-info p {
            margin: 5px 0;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 15px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #2c2c2c;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #777;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .footer strong {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="factura-container">
        <div class="factura-header">
            <h1>Factura</h1>
            <p><strong>Green Food Market</strong><br>Tu tienda de productos saludables</p>
        </div>

        <div class="factura-info">
            <p><strong>Cliente:</strong> {{ $productos->nombre_cliente }}</p>
            <p><strong>Fecha:</strong> {{ $productos->fecha }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos->datos_productos as $producto)
                    <tr>
                        <td>{{ $producto['nombre'] }}</td>
                        <td>{{ $producto['cantidad'] }}</td>
                        <td>${{ number_format($producto['precio'], 0, ',', '.') }}</td>
                        <td>${{ number_format($producto['cantidad'] * $producto['precio'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Total a pagar: ${{ number_format($productos->valor_total, 0, ',', '.') }}</p>

        <div class="footer">
            <p>Gracias por elegir <strong>Green Food Market</strong>.<br>Promoviendo una vida saludable 🍃</p>
        </div>
    </div>
</body>
</html>
