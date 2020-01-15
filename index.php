<?php
include_once 'controller/controller.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Discount Calculator</title>
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <h1> Choose which discount to calculate!</h1>
        </div>
        <div class="row d-flex justify-content-center">
            <form class="form" method="POST">
                <!-- Displays the orders -->
                <div class="form-group d-flex justify-content-center">
                    <select name="order" required>
                        <option value="" disabled selected hidden>Select your order</option>
                        <?php 
                        // lists the orders
                        listTheOrders();
                        ?>
                    </select>
                </div>
                <!-- Posts data and calculates -->
                <button class="btn btn-light">Calculate your discount</button>
            </form>
        </div>
    </div>
</body>

</html>