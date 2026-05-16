<?php

return [
    'category' => [
        'model' => [
            'singular' => 'Κατηγορία',
            'plural' => 'Κατηγορίες',
        ],
        'table' => [
            'name' => 'Όνομα',
            'slug' => 'Slug',
            'parent' => 'Γονέας',
            'order' => 'Σειρά',
            'children_count' => 'Υποκατηγορίες',
            'products_count' => 'Προϊόντα',
            'created_at' => 'Δημιουργήθηκε στις',
        ],
        'form' => [
            'sections' => [
                'general' => 'Γενικά',
                'settings' => 'Ρυθμίσεις',
            ],
            'fields' => [
                'name_en' => 'Όνομα (Αγγλικά)',
                'name_el' => 'Όνομα (Ελληνικά)',
                'slug' => 'Slug',
                'parent_id' => 'Γονική κατηγορία',
                'order' => 'Σειρά ταξινόμησης',
            ],
        ],
        'filters' => [
            'trashed' => 'Διαγραμμένες εγγραφές',
        ],
        'relation' => [
            'children' => [
                'title' => 'Υποκατηγορίες',
            ],
        ],
    ],

    'product' => [
        'model' => [
            'singular' => 'Προϊόν',
            'plural' => 'Προϊόντα',
        ],
        'table' => [
            'thumbnail' => 'Μικρογραφία',
            'name' => 'Όνομα',
            'category' => 'Κατηγορία',
            'price' => 'Τιμή',
            'is_combo' => 'Combo',
            'status' => 'Κατάσταση',
            'created_at' => 'Δημιουργήθηκε στις',
        ],
        'form' => [
            'sections' => [
                'general' => 'Γενικά',
                'pricing' => 'Τιμολόγηση & Κατάσταση',
                'thumbnail' => 'Μικρογραφία',
                'variants' => 'Παραλλαγές',
                'combo_groups' => 'Ομάδες Combo',
            ],
            'fields' => [
                'name_en' => 'Όνομα (Αγγλικά)',
                'name_el' => 'Όνομα (Ελληνικά)',
                'description_en' => 'Περιγραφή (Αγγλικά)',
                'description_el' => 'Περιγραφή (Ελληνικά)',
                'slug' => 'Slug',
                'category_id' => 'Κατηγορία',
                'price' => 'Τιμή (EUR)',
                'is_combo' => 'Είναι προϊόν combo',
                'status' => 'Κατάσταση',
                'thumbnail' => 'Μικρογραφία',
                'variant_name_en' => 'Όνομα παραλλαγής (Αγγλικά)',
                'variant_name_el' => 'Όνομα παραλλαγής (Ελληνικά)',
                'price_adjustment' => 'Προσαρμογή τιμής (EUR)',
                'variant_sort_order' => 'Σειρά ταξινόμησης',
                'variant_is_active' => 'Ενεργό',
                'combo_group_name_en' => 'Όνομα ομάδας (Αγγλικά)',
                'combo_group_name_el' => 'Όνομα ομάδας (Ελληνικά)',
                'min_select' => 'Ελάχιστες επιλογές',
                'max_select' => 'Μέγιστες επιλογές',
                'is_required' => 'Απαιτείται',
                'items' => 'Στοιχεία',
                'item_type' => 'Τύπος στοιχείου',
                'item_type_product' => 'Προϊόν',
                'item_type_variant' => 'Παραλλαγή',
                'item_product_id' => 'Προϊόν',
                'item_variant_id' => 'Παραλλαγή',
                'extra_price' => 'Επιπλέον τιμή (EUR)',
            ],
        ],
        'filters' => [
            'category' => 'Κατηγορία',
            'is_combo' => 'Combo',
            'status' => 'Κατάσταση',
        ],
        'bulk_actions' => [
            'change_status' => 'Αλλαγή κατάστασης',
            'change_status_modal_heading' => 'Αλλαγή κατάστασης για επιλεγμένα προϊόντα',
            'status' => 'Νέα κατάσταση',
        ],
        'status' => [
            'active' => 'Ενεργό',
            'inactive' => 'Ανενεργό',
            'out_of_stock' => 'Εκτός αποθέματος',
        ],
        'notifications' => [
            'change_status_success' => 'Η κατάσταση άλλαξε επιτυχώς',
            'change_status_failure' => 'Αποτυχία αλλαγής κατάστασης',
        ],
    ],
];
