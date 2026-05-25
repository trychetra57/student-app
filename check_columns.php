<?php
use Illuminate\Support\Facades\Schema;

$columns = Schema::getColumnListing('users');
print_r($columns);

if (!in_array('is_active', $columns)) {
    echo "ERROR: is_active column is missing from users table!\n";
} else {
    echo "SUCCESS: is_active column exists.\n";
}
