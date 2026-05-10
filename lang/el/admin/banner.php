<?php

return [
    'model' => [
        'singular' => 'Banner',
        'plural' => 'Banners',
    ],
    'table' => [
        'image' => 'Εικόνα',
        'title' => 'Τίτλος',
        'link' => 'Σύνδεσμος',
        'sort_order' => 'Σειρά',
        'status' => 'Κατάσταση',
        'created_at' => 'Δημιουργήθηκε',
    ],
    'form' => [
        'sections' => [
            'general' => 'Γενικά',
            'settings' => 'Ρυθμίσεις',
            'image' => 'Εικόνα',
        ],
        'fields' => [
            'title' => 'Τίτλος',
            'link' => 'Σύνδεσμος',
            'sort_order' => 'Σειρά ταξινόμησης',
            'status' => 'Ενεργό',
            'image' => 'Εικόνα banner',
        ],
    ],
];
