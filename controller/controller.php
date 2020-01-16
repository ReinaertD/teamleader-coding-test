<?php
include 'controller/discountCalculator.php';
// Executes if a POST method of order has been executed 
if (isset($_POST['order'])) {

    // Gets the request and decodes the json
    $requestedOrder = $_POST['order'] . ".json";
    $request = file_get_contents("example-orders/" . $requestedOrder);
    $order = json_decode($request, true);
    $order = calculateDiscount($order);
    saveData($order);
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
