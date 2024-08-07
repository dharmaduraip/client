<?php

return array(
    'admin' =>array(   
        'id' => 'Id',     
        'storetype' => array(        
            'title' => 'Shop Type',
            'list' => 'ShopType List',
            'add' => 'Add Shop Type',
            'edit' => 'Update',
            'delete' => 'Delete Shop Type',
            'name' => 'Shop Type Name',
            'status' => 'Status',
            'category' => 'Shop Category'
            
        ),
        'cuisine' => array(        
            'title' => 'Cuisines',
            'list' => 'Cuisines List',
            'add' => 'Add Cuisines',
            'edit' => 'Edit Cuisines',
            'delete' => 'Delete Cuisines',
            'type' => 'Shop Type',
            'name' => 'Cuisine Name',
            'status' => 'Status',
            
        ),
        'shops' => array(        
            'title' => 'Shops',
            'list' => 'Shops List',
            'store_type' =>'Shop Type',
            'add' => 'Add Shops',
            'edit' => 'Edit Shops',
            'delete' => 'Delete Shops',
            'type' => 'Shop Type',
            'cuisname' => 'Cuisine Name',
            'name' => 'Shop Name',
            'email' => 'Email',
            'picture' => 'Picture',
            'address' => 'Address',
            'contactno' => 'Contact Number',
            'contactper' => 'Contact Person',
            'password' => 'Password',
            'confirmpassword' => 'Confirm Password',
            'veg' => 'Pure Veg',
            'nonveg' => 'Non Veg',
            'status' => 'Status',
            'minamount' => 'Min Amount',
            'offper' => 'Offer Percentage(%)',
            'estdeltime' => 'Estimated delivery time(Minutes)',
            'description' => 'Description',
            'location' => 'Location',
            'pincode' => 'Zipcode',
            'packing_charges' =>'Packing Charges',
            'shop_open_time' =>'Shops Open Timing',
            'open_time' =>'Shop Opens',
            'close_time' =>'Shop Closes',
            'commission' =>' Commission Percentage (%)',
            'gst' =>' Gst / Tax Percentage(%) ',
            'free_delivery' => 'Free Delivery',
            'zone' => 'Zone',
            'free_delivery_limit' => 'Minimum Amount',
            
            
        ),
        'addon' => array(        
            'title' => 'Add On',
            'list' => 'Add On List',
            'add' => 'Add Add On',
            'edit' => 'Edit Add On',
            'delete' => 'Delete Add On',
            'name' => 'Add On Name',
            'status' => 'Status',
            
        ),
        'category' => array(        
            'title' => 'Category',
            'list' => 'Category List',
            'add' => 'Add Category',
            'edit' => 'Edit Category',
            'delete' => 'Delete Category',
            'name' => 'Category Name',
            'description' => 'Description',
            'picture' => 'Picture',
            'status' => 'Status',
            
        ),
        'item' => array(        
            'title' => 'Items',
            'list' => 'Items List',
            'add' => 'Add Item',
            'edit' => 'Edit Item',
            'delete' => 'Delete Item',
            'name' => 'Item Name',
            'description' => 'Description',
            'picture' => 'Picture',
            'status' => 'Status',
            'category' => 'Category',
            'picture' => 'Picture',
            'price' => 'Price',
            'unit' => 'Unit',
            'quantity' => 'Quantity',
            'low_stock' => 'Low Stock Limit',
            'discount' => 'Discount',
            'discount_type' => 'Discount Type',
            'addon_list' => 'Addon List',
            
        ),
        'wallet' => array(
            'trn_alias' => 'Transaction Alias',
            'trn_des' => 'Transaction Des',
            'type' => 'Type',
            'amt' => 'Amount',
            'time' => 'Time',
        ),

        'logs' => array(
            'type' => 'Type',
            'time' => 'Time',
        ),
        'dispute' => array(
            'title' => 'Disputes',
            'title1' => 'Request Disputes',
            'add' => 'Add Dispute',
            'update' => 'Close Dispute',
            'update_dispute1' => 'Close Request Dispute',
            'dispute_type' => 'User',
            'dispute_id' => 'Id',
            'dispute_request_id' => 'Booking Id',
            'dispute_request' => 'Raised By',
            'request' => 'Request Details',
            'dispute_user' => 'User',
            'dispute_provider' => 'Provider',
            'dispute_name' => 'Dispute Name',
            'dispute_refund' => 'Refund Amount',
            'dispute_comments' => 'Comments',
            'dispute_status' => 'Status',
            'new_dispute' => 'New dispute created!',
        ),
       
    ), 
    'user' => 
        [
            'my_order' => 'My Orders',
            'order_details' => 'Order Details',
            'order_location' => 'Order Location',
            'order_type' => 'Order Type',
            'payment_mode' => 'Payment Mode',


            'booking_id' => 'Booking Id',
            'base_fare' => 'Base Fare',
            'tax_fare' => 'Tax Fare',
            'hourly_fare' => 'Hourly Fare',
            'wallet_detection' => 'Wallet Detection',
            'promocode_discount' => 'Promocode Discount',
            'get' => 'GET',
            'extra_charge' => 'Extra Charge',
            'total' => 'Total',
            'cancelled' => 'Cancelled',
            'before' => 'Before',
            'after' => 'After',


            'schedule_date' => 'Schedule Date',
            'schedule_time' => 'Schedule Time',
            'cancel' => 'CANCEL',
            'dispute_details' => 'Dispute Details',
            'dispute_name' => 'Dispute Name',
            'date' => 'Date',
            'status' => 'Status',
            'commented_by' => 'Comments By',
            'comments' => 'Comments',
            'select' => 'Select',
            'user_details' => 'User Details',
            'grand_total' => 'GRAND TOTAL',
            'packing_charges' => 'Packing Charges',
            'basefare_commision' => 'Basefare/Commission',
            'tax_amount' => 'Tax Amount(GST)',
            'delivery_charge' => 'Delivery Charge',
            'shipping_handling' => 'Shipping & Handling',
            'cart_subtotal' => 'Cart Subtotal',
            'order_date' => 'Order Date',
            'order_items' => 'Order Items',
            'food_service' => 'Food Service',
            'shop_service' => 'Shop Service',
            'shop_discount' => 'Shop Discount'
            


            




        ],
        'submit' => 'Submit'                  
);
