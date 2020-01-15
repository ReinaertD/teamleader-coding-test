<?php

// Executes if a POST method of order has been executed 
if (isset($_POST['order'])) {

    // Gets the request and turns the order into an object array
    $requestedOrder = $_POST['order'] . ".json";
    $request = file_get_contents("example-orders/" . $requestedOrder);
    $order = json_decode($request, true);
    /*     var_dump($order); */
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
    var_dump($differentSeriesA);
    // Executes discount for Series 1/A if more than 2 different items
    if ($differentSeriesAAmount >= 2) {
        discountProductA($differentSeriesA);
    }

    // Executes company discount if applicable
    // discountTotal();
/*     var_dump($order);
 */}

// Discount for 1/A series products
function discountProductA($productsBought)
{
    // COMPARE WHICH HAS THE LOWEST UNIT PRICE!!!
   foreach($productsBought as $product){

   } 

    

        /* var_dump($products); */
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

// Discount for great customers
function discountTotal()
{
    $customers = retrieveJSON('customers');
    // Returns bool true or false.
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
