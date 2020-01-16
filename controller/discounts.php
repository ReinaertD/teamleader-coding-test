<?php

// Discount for 1/A series products
function discountProductA($productsBought)
{
    // Gets the price per unit of the first product and declares the discount in PERCENTAGE
    $discountItem = array($productsBought[0]['unit-price'],$productsBought[0]['product-id']);
    $discount = 20;
    // Compares which has the lowest price and assigns the lowest price and product-id to an array
    foreach ($productsBought as &$product) {
        if ($discountItem[0] > $product['unit-price']) {
            $discountItem[0] = $product['unit-price'];
            $discountItem[1] = $product['product-id'];
        }
    }
    // Calculates the discount
    $discountItem[0] = ($discountItem[0] / 100) * $discount;
    // Returns the discount and the item-id the discount is on
    return $discountItem;
}

// Discount for 2/B series products
function discountProductB($product)
{
    $discountCategory2 = array();
    $products = retrieveJSON('products');

    foreach ($products as $item) {
        if ($item['id'] === $product['product-id']) {
            $quantity = $product['quantity'];
            $quantity /= 5;
            array_push($discountCategory2, $product);
            $discountCategory2[0]['free'] = $quantity;
        }
    }
    return $discountCategory2;
}

// Checks if it is a valued customer 
function valuedCustomer($customerID)
{
    $clients = retrieveJSON('customers');
    $customer = array();
    // Checks if the client has got the company more than 1000 revenue and adds them to the array
    foreach($clients as $client){
        if ($client['id'] === $customerID && $client['revenue'] >= 1000){
            $customer['customer'] = $client;
            $customer['discount'] = true;
        } else if($client['id'] === $customerID) {
            $customer['customer'] = $client;
            $customer['discount'] = false;
        }
    }
    // Returns the array with the company and with a bool whether it gets the discount or not
    return $customer;
}

function valuedCustomerDiscount($order){
    // Discount in PERCENTAGE
    $discount = 10;
    $finalPrice = $order['recalculated-total']-(($order['recalculated-total'] /100) * $discount);
    $order['recalculated-total'] =  round($finalPrice,2);

    return $order;
}
?>