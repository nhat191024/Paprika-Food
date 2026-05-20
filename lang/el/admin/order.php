<?php

return [
    'model' => [
        'singular' => 'Παραγγελία',
        'plural' => 'Παραγγελίες',
    ],

    'new_orders' => [
        'plural' => 'Νέες Παραγγελίες',
    ],

    'table' => [
        'order_number' => 'Παραγγελία #',
        'customer' => 'Πελάτης',
        'status' => 'Κατάσταση',
        'order_type' => 'Τύπος',
        'payment_method' => 'Πληρωμή',
        'items_count' => 'Στοιχεία',
        'final_amount' => 'Σύνολο',
        'created_at' => 'Παραγγέλθηκε στις',
    ],

    'filters' => [
        'status' => 'Κατάσταση',
        'order_type' => 'Τύπος παραγγελίας',
        'payment_method' => 'Τρόπος πληρωμής',
        'date_from' => 'Από ημερομηνία',
        'date_to' => 'Έως ημερομηνία',
        'date' => 'Ημερομηνία παραγγελίας',
    ],

    'infolist' => [
        'sections' => [
            'order_info' => 'Πληροφορίες Παραγγελίας',
            'customer_info' => 'Πελάτης',
            'delivery_info' => 'Πληροφορίες Παράδοσης',
            'payment_info' => 'Πληρωμή',
            'items' => 'Παραγγελθέντα Στοιχεία',
            'selections' => 'Πρόσθετα',
        ],
        'fields' => [
            'order_number' => 'Παραγγελία #',
            'status' => 'Κατάσταση',
            'order_type' => 'Τύπος',
            'scheduled_delivery_time' => 'Χρόνος Παράδοσης',
            'asap' => 'Το συντομότερο δυνατό',
            'payment_method' => 'Τρόπος πληρωμής',
            'created_at' => 'Παραγγέλθηκε στις',
            'customer_name' => 'Όνομα πελάτη',
            'customer_email' => 'Email',
            'recipient_name' => 'Παραλήπτης',
            'delivery_phone' => 'Τηλέφωνο',
            'delivery_address' => 'Διεύθυνση παράδοσης',
            'total_amount' => 'Μερικό σύνολο',
            'discount_amount' => 'Έκπτωση',
            'voucher_code' => 'Εφαρμοσμένο κουπόνι',
            'final_amount' => 'Σύνολο',
            'product_name' => 'Προϊόν',
            'variant' => 'Παραλλαγή',
            'quantity' => 'Ποσότητα',
            'price' => 'Τιμή μονάδας',
            'subtotal' => 'Μερικό σύνολο',
            'selection_product' => 'Επιλογή',
            'extra_price' => 'Επιπλέον τιμή',
        ],
    ],

    'incoming' => [
        'no_pending' => 'Δεν υπάρχουν νέες παραγγελίες αυτή τη στιγμή.',
        'no_processing' => 'Δεν υπάρχουν παραγγελίες σε επεξεργασία.',
    ],

    'actions' => [
        'confirm' => 'Επιβεβαίωση Παραγγελίας',
        'ready' => 'Σήμανση ως Έτοιμη',
        'complete' => 'Ολοκλήρωση',
        'cancel' => 'Ακύρωση Παραγγελίας',
        'cancel_confirm' => 'Είστε σίγουροι ότι θέλετε να ακυρώσετε αυτήν την παραγγελία;',
        'cancel_confirm_button' => 'Ακύρωση Παραγγελίας',
        'view' => 'Προβολή',
        'back' => 'Πίσω',
    ],

    'status' => [
        'pending' => 'Σε εκκρεμότητα',
        'processing' => 'Σε επεξεργασία',
        'ready' => 'Έτοιμη',
        'completed' => 'Ολοκληρώθηκε',
        'cancelled' => 'Ακυρώθηκε',
    ],

    'order_type' => [
        'online' => 'Online',
        'dine_in' => 'Εντός καταστήματος',
    ],

    'payment_method' => [
        'cash' => 'Μετρητά',
        'credit_card' => 'Πιστωτική Κάρτα',
    ],
];
