<?php

// Executes if a POST method of order has been executed 
if (isset($_POST['order'])) {

    // Gets the request and decodes the json
    $requestedOrder = $_POST['order'] . ".json";
    $request = file_get_contents("example-orders/" . $requestedOrder);
    $order = json_decode($request, true);
    calculateDiscount($order);
}

//////////////////////// FUNCTIONS
// FRONTEND
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


// BACKEND
// Calculates all the discounts
function calculateDiscount($order)
{
    // Checks how many different items of serie 1/A there are
    $differentSeriesAAmount = 0;
    $differentSeriesA = array();
    // Assigns recalculated total to the array
    $order['recalculated-total'] = $order['total'];

    // Checks the order for which items ordered. Products starting with serial 'A' or 'B'
    // Adds amount of free items for serial 2/B
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
    var_dump($order);
}



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



// Retrieves the relevant json file.
function retrieveJSON($json)
{
    switch ($json) {
        case 'products':
            $request = file_get_contents("data/products.json");
            $products = json_decode($request, true);
            return $products;
            break;
        case 'customers':
            // Gets the customer data
            $request = file_get_contents("data/customers.json");
            $customers = json_decode($request, true);
            return $customers;
            break;
        case 'default':
            var_dump("Error retrieveJSON");
            break;
    }
}
