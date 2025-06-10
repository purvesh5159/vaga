<?php
// to fetch uom custom field from product extra field 

require '../../../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';

$product_id = GETPOST('product_id', 'int');
//dol_syslog("inside get_uom " .$product_id);


if ($product_id > 0) {
    $product = new Product($db);
    if ($product->fetch($product_id) > 0) {
        $product->fetch_optionals($product->id);
        $uom = $product->array_options['options_uom'];
       // dol_syslog("uom get_uom " .$uom);

        if (!empty($uom)) {
            echo json_encode(array('success' => true, 'uom' => $uom));
        } else {
            echo json_encode(array('success' => false));
        }
    } else {
        echo json_encode(array('success' => false));
    }
} else {
    echo json_encode(array('success' => false));
}

?>
