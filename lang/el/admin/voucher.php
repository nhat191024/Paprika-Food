<?php

return [
    'navigation' => [
        'label' => 'Κουπόνια',
    ],

    'model' => [
        'singular' => 'Κουπόνι',
        'plural' => 'Κουπόνια',
    ],

    'states' => [
        'active' => 'Ενεργό',
        'inactive' => 'Ανενεργό',
        'expired' => 'Ληγμένο',
    ],

    'discount_types' => [
        'fixed' => 'Σταθερό ποσό',
        'percent' => 'Ποσοστό',
    ],

    'form' => [
        'sections' => [
            'general' => 'Γενικές πληροφορίες',
            'discount' => 'Ρύθμιση έκπτωσης',
            'validity' => 'Ισχύς & Όριο χρήσης',
        ],
        'fields' => [
            'code' => 'Κωδικός κουπονιού',
            'status' => 'Κατάσταση',
            'discount_type' => 'Τύπος έκπτωσης',
            'discount_value' => 'Αξία έκπτωσης',
            'min_order_amount' => 'Ελάχιστο ποσό παραγγελίας',
            'max_discount' => 'Μέγιστη έκπτωση',
            'start_date' => 'Ημερομηνία έναρξης',
            'end_date' => 'Ημερομηνία λήξης',
            'is_unlimited' => 'Απεριόριστη χρήση',
            'usage_limit' => 'Όριο χρήσης',
        ],
    ],

    'table' => [
        'code' => 'Κωδικός',
        'discount_type' => 'Τύπος',
        'discount_value' => 'Αξία',
        'min_order_amount' => 'Ελάχ. παραγγελία',
        'start_date' => 'Έναρξη',
        'end_date' => 'Λήξη',
        'is_unlimited' => 'Απεριόριστο',
        'usage' => 'Χρήσεις / Όριο',
        'status' => 'Κατάσταση',
    ],

    'filters' => [
        'status' => 'Κατάσταση',
        'discount_type' => 'Τύπος έκπτωσης',
    ],
];
