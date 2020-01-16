<?php


// Puts all the filenames of the example-orders folder into an array
function arrayTheOrders()
{
    $customerOrders = 'example-orders';
    $orders = array_diff(scandir($customerOrders), array('..', '.'));
    return $orders;
}

// Returns the customer orders array in SELECT options
function listTheOrders()
{
    $orders = arrayTheOrders();
    foreach ($orders as $order) {
        $frmtOrder = str_replace(".json", "", $order);
        echo "<option value=\"$frmtOrder\">" . $frmtOrder . "</option>";
    }
}

function showData($order)
{
    $client = $order['discount-company']['customer']['name'];
    $totalPrice = $order['recalculated-total'];
    $originalPrice = $order['total'];



    // Echoed into HTML
    // I use variables to see 
    echo $sWelcome = "<div>" . "Welcome <b>" . $client . "</b></div>";
    echo $sTotalPrice = "<div>" . "Your <b>final price</b> is <b>" . $totalPrice . " euro</b>." . "</div>";
    if ($originalPrice != $totalPrice) {
        echo $sOriginalPrice = "<div>" . "You originally where supposed to pay " . $originalPrice . " euro." . "</div>";
    }
    // Discount Company
    if ($order['discount-company']['discount'] == true) {
        echo $loyalCustomer = "<div>" . "But because you are a <b>loyal customer</b> you got a discount! wooow...." . "</div>";
    }
    // Discount 1/A series
    if(isset($order['discount-series-A'])){
        echo $discount1A = "<div>". "You get a discount on <b>" . $order['discount-series-A'][1] . "</b> because your ordered more than 1 different item in the A series." .  "</div>";
    }
    // Discount 2/B series
    foreach ($order['items'] as $item) {
        if (isset($item['free'])) {
            echo $discount2B = "<div>" . "You receive <b>" . $item['free'] . " unit(s) of " . $item['product-id'] . " for free</b>." . "</div>";
        }
    }
}
