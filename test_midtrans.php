<?php
require 'vendor/autoload.php';
try {
    if (class_exists(\Midtrans\Config::class)) {
        echo "YES: Midtrans\\Config exists\n";
    } else {
        echo "NO: Midtrans\\Config NOT found\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
