# Teamleader PHP Coding Test

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
        If 2 different products, cheapest 20% off!
        Adds to price!

    - If company has revenue > 1000 euro, 10% on new orders
        Needs company data!
        Needs company of order!
        Returns true if above 1000, false if below

4- Display final price with calculations

 