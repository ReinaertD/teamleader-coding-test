# Teamleader PHP Coding Test

## Tools
Visual Studio Code
Bootstrap framework for quick design

## Sidenotes
Not optimal at all.

## Logic

1- Import orders
    - Choose order(scandir?)

2- Recieve order and acquire the company and product data
    - Retrieve order data
    - Retrieve the rest of the relevant data related to that order
    - Send relevant data to next task

3- Check for discounts  (which one takes precedence?)

    - If order contains switches(id 2), then get 1 free per 5.
        Needs product data!
        Needs products of order!
        For each 5 of same product, 1 free!
        

    - If order contains 2 different orders of screwdrivers(id 1), then get 20% on the cheapest product(only 1)
        Needs product data!
        Needs products of order!
        Check if there are 2 or more different items.
        Add different items and serial ids of items bought to an array
        Cycle to array to find the cheapest product
        Give cheapest 20%
        Recalculate total price

    - If company has revenue > 1000 euro, 10% on new orders
        Needs company data!
        Needs company of order!
        Checks if above 1000
        If so, recalculate total price with 10% discount
        

4- Display final price


 