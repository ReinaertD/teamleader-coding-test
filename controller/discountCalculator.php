<?php
include_once "controller/discounts.php";

// Calculates all the discounts
function calculateDiscount($order)
{
    // Variable to see how many different items of serie 1/A there are
    $differentSeriesAAmount = 0;
    $differentSeriesA = array();
    // Assigns recalculated total to the array
    $order['recalculated-total'] = $order['total'];

    // Checks the order for which items ordered. Products starting with serial 'A' or 'B'
    // If new discounts added add them to the right order
    // Adds amount of free items for serial 2/B
    // Also checks how many different items there are in the 1/A series
    foreach ($order['items'] as &$product) {
        switch (substr($product['product-id'], 0, 1)) {
            case 'A':
                $differentSeriesAAmount++;
                array_push($differentSeriesA, $product);
                break;
            case 'B':
                $discounts = discountProductB($product);
                $product = $discounts[0];
                break;
            default:
                var_dump("Item does not exist");
                break;
        }
    }
    // Executes discount for Series 1/A if more than 2 different items
    if ($differentSeriesAAmount >= 2) {
        $order['discount-series-A'] = discountProductA($differentSeriesA);
        $order['recalculated-total'] = $order['total'] - $order['discount-series-A']['0'];
    }
    // Executes company discount if applicable
    $order['discount-company'] = valuedCustomer($order['customer-id']);
    if($order['discount-company']['discount'] === true){
        $order = valuedCustomerDiscount($order);
    }

    return $order;
}

// Saves data
// Commented because of permission issues
function saveData($order){
    // try{
    //     file_put_contents('controller/orderDiscounted.json', json_encode($order, JSON_PRETTY_PRINT));
    // } catch(Exception $e){
    //     echo "<div class=\"alert alert-warning\">Failed to save data on server!". $e . "</div>";
    // }
}
    

    
?>