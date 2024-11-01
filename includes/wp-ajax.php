<?php
use Dompdf\Dompdf;

add_action('wp_ajax_estimate_insert', 'wc_estimate_insert');
add_action('wp_ajax_nopriv_estimate_insert', 'wc_estimate_insert');

function wc_estimate_insert()
{

    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es";

    $userId = sanitize_text_field($_POST['userId']); //string value use: %s
    $estimateName = sanitize_text_field($_POST['estimateName']); //string value use: %s
    $description = sanitize_text_field($_POST['description']); //string value use: %s
    $userName = sanitize_text_field($_POST['userName']); //numeric value use: %s
    $userEmail = sanitize_text_field($_POST['userEmail']); //numeric value use:  %s
    $userContact = sanitize_text_field($_POST['userContact']); //numeric value use: %s
    $userContactPerson = sanitize_text_field($_POST['userContactPerson']); //numeric value use: %s
    $userAddress = sanitize_text_field($_POST['userAddress']); //numeric value use:  %s

    $sql = $wpdb->prepare("INSERT INTO `$tablename` (`user_id`,`estimate_name`,`estimate_description`,`user_name`, `user_email`, `user_contact_person`, `user_contact`, `user_address`) values (%s, %s, %s, %s, %s, %s, %s, %s)", $userId, $estimateName, $description, $userName, $userEmail, $userContactPerson, $userContact, $userAddress);

    $wpdb->query($sql);

    echo $lastid = $wpdb->insert_id;

    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_estimate_clone', 'wc_estimate_clone');
add_action('wp_ajax_nopriv_estimate_clone', 'wc_estimate_clone');

function wc_estimate_clone()
{

    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es";
    $estimateId = sanitize_text_field($_POST['id']); //string value use: %s
    $estimateData = get_estimate_by_id($estimateId);

    $userId = sanitize_text_field($estimateData['user_id']); //string value use: %s
    $estimateName = sanitize_text_field($estimateData['estimate_name'] . ' copy'); //string value use: %s
    $description = sanitize_text_field($estimateData['estimate_description']); //string value use: %s
    $userName = sanitize_text_field($estimateData['user_name']); //numeric value use: %s
    $userEmail = sanitize_text_field($estimateData['user_email']); //numeric value use:  %s
    $userContact = sanitize_text_field($estimateData['user_contact_person']); //numeric value use: %s
    $userContactPerson = sanitize_text_field($estimateData['user_contact']); //numeric value use: %s
    $userAddress = sanitize_text_field($estimateData['user_address']); //numeric value use:  %s

    $sql = $wpdb->prepare("INSERT INTO `$tablename` (`user_id`,`estimate_name`,`estimate_description`,`user_name`, `user_email`, `user_contact_person`, `user_contact`, `user_address`) values (%s, %s, %s, %s, %s, %s, %s, %s)", $userId, $estimateName, $description, $userName, $userContactPerson, $userContact, $userEmail, $userAddress);

    $wpdb->query($sql);

    $lastid = $wpdb->insert_id;

    if ($lastid) {
        $allProducts = allGetProducts($estimateId);
        foreach ($allProducts as $allProduct) {
            $tablename2 = $wpdb->prefix . "innovs_wc_es_products";
            $product_id = sanitize_text_field($allProduct ['product_id']);
            $product_name = sanitize_text_field($allProduct ['product_name']);
            $qty = sanitize_text_field($allProduct ['qty']);
            $price = sanitize_text_field($allProduct ['price']);
            $total_price = sanitize_text_field($allProduct ['total_price']);

            $sql = $wpdb->prepare("INSERT INTO `$tablename2` (`estimate_id`,`product_id`, `product_name`, `qty`, `price`, `total_price`) values (%d, %d, %s, %s, %s, %s)", $lastid, $product_id, $product_name, $qty, $price, $total_price);

            $wpdb->query($sql);
        }
        echo $lastid;
    }

    wp_die(); // this is required to terminate immediately and return a proper response
}


function get_estimate_by_id($id)
{
    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es";
    $sql = "Select * from $tablename where `id` = '$id'";
    $values = $wpdb->get_row($sql, ARRAY_A);
    return $values;
}


add_action('wp_ajax_estimate_edit', 'wc_es_edit');
add_action('wp_ajax_nopriv_estimate_edit', 'innovs_wc_es_edit');

function wc_es_edit(){

    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es";

    $estimateId = sanitize_text_field($_POST['estimateId']); //string value use: %s
    $estimateName = sanitize_text_field($_POST['estimateName']); //string value use: %s
    $description = sanitize_text_field($_POST['description']); //string value use: %s
    $userName = sanitize_text_field($_POST['userName']); //numeric value use: %s
    $userEmail = sanitize_text_field($_POST['userEmail']); //numeric value use:  %s
    $userContact = sanitize_text_field($_POST['userContact']); //numeric value use: %s
    $userContactPerson = sanitize_text_field($_POST['userContactPerson']); //numeric value use: %s
    $userAddress = sanitize_text_field($_POST['userAddress']); //numeric value use:  %s

    $sql = $wpdb->prepare("UPDATE `$tablename` SET `estimate_name` = '$estimateName', `estimate_description` = '$description', `user_name` = '$userName', `user_email` = '$userEmail', `user_contact_person` = '$userContactPerson', `user_contact` = '$userContact', `user_address` = '$userAddress' WHERE  `id` = %d", $estimateId);

    $wpdb->query($sql);
    echo $estimateId;

    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_estimate_product_updateByQty', 'wc_estimate_product_updateByQty');
add_action('wp_ajax_nopriv_estimate_product_updateByQty', 'wc_estimate_product_updateByQty');

function wc_estimate_product_updateByQty(){

    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es_products";

    $id = sanitize_text_field($_POST['id']); //string value use: %s
    $qty = sanitize_text_field($_POST['quantity']); //string value use: %s
    $total_price = sanitize_text_field($_POST['totalPrice']); //string value use: %s

    $sql = $wpdb->prepare("UPDATE `$tablename` SET `qty` = '$qty', `total_price` = '$total_price' WHERE `id` = %d", $id);

    $wpdb->query($sql);

    echo $id;

    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_estimate_delete', 'wc_estimate_delete');
add_action('wp_ajax_nopriv_estimate_delete', 'wc_estimate_delete');

function wc_estimate_delete(){

    global $wpdb;

    $tablename = $wpdb->prefix . "innovs_wc_es";
    $estimateId = sanitize_text_field($_POST['estimateId']);
    $nonce = sanitize_text_field($_POST['nonce']);

    if (wp_verify_nonce($nonce, 'estimateDelete')) {
        $sql = "DELETE FROM `$tablename` WHERE id = '$estimateId'";
    }

    $wpdb->query($sql);

    echo $estimateId;

    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_estimate_product_delete', 'wc_estimate_product_delete');
add_action('wp_ajax_nopriv_estimate_product_delete', 'wc_estimate_product_delete');

function wc_estimate_product_delete(){

    global $wpdb;

    $tablename = $wpdb->prefix . "innovs_wc_es_products";
    $id = sanitize_text_field($_POST['id']);
    $productId = sanitize_text_field($_POST['productId']);
    $estimateId = sanitize_text_field($_POST['estimateId']);
    $nonce = sanitize_text_field($_POST['nonce']);

    if (wp_verify_nonce($nonce, 'productDelete')) {
        echo $sql = "DELETE FROM `$tablename` WHERE estimate_id = '$estimateId' and product_id = '$productId'";
    }

    $wpdb->query($sql);

    echo $productId;

    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_estimate_product_multiple_delete', 'wc_estimate_product_multiple_delete');
add_action('wp_ajax_nopriv_estimate_product_multiple_delete', 'wc_estimate_product_multiple_delete');

function wc_estimate_product_multiple_delete(){

    global $wpdb;

    $tablename = $wpdb->prefix . "innovs_wc_es_products";
    $id = sanitize_text_field($_POST['id']);
    $nonce = sanitize_text_field($_POST['nonce']);
    foreach ($_POST["id"] as $id) {
        $sql = "DELETE FROM `$tablename` WHERE id = '$id'";
        $wpdb->query($sql);
    }

    echo 'Success';

    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_estimate_product_converToCart', 'wc_estimate_product_converToCart');
add_action('wp_ajax_nopriv_estimate_product_converToCart', 'wc_estimate_product_converToCart');

function wc_estimate_product_converToCart(){

    global $woocommerce;
    $id = $_POST['id'];
    foreach ($_POST["id"] as $id) {
        $products = getProductsByID($id);
        $woocommerce->cart->add_to_cart($products[0]['product_id']);
    }
    echo 'Success';

    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_wc_estimate_product_Export_CSV', 'wc_estimate_product_Export_CSV');
add_action('wp_ajax_nopriv_wc_estimate_product_Export_CSV', 'wc_estimate_product_Export_CSV');

function wc_estimate_product_Export_CSV(){

    $CSVurl = plugin_dir_path(__FILE__) . 'assets/estimate.csv';

    global $woocommerce;
    $estimateId = $_POST["estimateId"];
    $estimateData = get_estimate_by_id($estimateId);
    $userId = $estimateData['user_id']; //string value use: %s

    $user = get_user_by('ID', $userId);
// Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

// Style
    $heading = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => 'FFFFFF'),
            'size' => 14,
            'name' => 'Verdana'
        ));
    $subheading = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => 'FFFFFF'),
            'size' => 12,
            'name' => 'Verdana'
        ));
    $styleArray = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => 'FF0000'),
            'size' => 10,
            'name' => 'Verdana'
        ));
    $totalSection = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '000000'),
            'size' => 8,
            'name' => 'Verdana'
        ));

    $backgroundColor = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'd5d5d5')
        ));
    $headingBGColor = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4F81BD')
        ));
    $subheadingBGColor = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'F79646')
        ));

    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($heading);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headingBGColor);
    $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($subheading);
    $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($subheadingBGColor);
    $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($subheading);
    $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($subheadingBGColor);
    $objPHPExcel->getActiveSheet()->getStyle('A10')->applyFromArray($heading);
    $objPHPExcel->getActiveSheet()->getStyle('A10')->applyFromArray($headingBGColor);

// Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Price Estimate')
        ->setCellValue('A3', 'CREATED BY')
        ->setCellValue('A4', 'Name : ' . $user->first_name . ' ' . $user->last_name)
        ->setCellValue('A5', 'Company : ' . get_user_meta($user->ID, 'company_name', true))
        ->setCellValue('A6', 'Email : ' . $user->user_email)
        ->setCellValue('A7', 'Cell : ' . get_user_meta($user->ID, 'mobile', true));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:B3');
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
    );
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
    );

    // Miscellaneous glyphs, UTF-8
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('D3', 'USER DETAILS')
        ->setCellValue('D4', 'User : ' . $estimateData['user_name'])
        ->setCellValue('D5', 'Contact Person: ' . $estimateData['user_contact_person'])
        ->setCellValue('D6', 'User Contact : ' . $estimateData['user_contact'])
        ->setCellValue('D7', 'User Email : ' . $estimateData['user_email'])
        ->setCellValue('D8', 'Address : ' . $estimateData['user_address']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:E3');
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('D3')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('D3')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
    );
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
    );


    $timestamp = strtotime($estimateData['cdate']);
    $date = date("d-M-Y", $timestamp);
    $estimate_id = '00' . $estimateId;
    $estimate_name = $estimateData['estimate_name'];
    $estimate_description = $estimateData['estimate_description'];
    $days = get_option('delete_time');
    $timestamp = strtotime($estimateData['cdate'] . $days . 'day');
    $validDate = date("d-M-Y", $timestamp);

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A10', 'Estimate Details')
        ->setCellValue('A11', 'Date : ' . $date)
        ->setCellValue('A12', 'Estimate ID : ' . $estimate_id)
        ->setCellValue('A13', 'Estimate Name : ' . $estimate_name)
        ->setCellValue('A14', 'Estimate Description : ' . $estimate_description)
        ->setCellValue('A15', 'Valid Till : ' . $validDate);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A10:E10');
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A10')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A10')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
    );
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
    );


    $rowNumber2 = 0;
    $rowNumber = 17;
// Add some data
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $rowNumber, 'Product Number')
        ->setCellValue('B' . $rowNumber, 'Product Name')
        ->setCellValue('C' . $rowNumber, 'Unit Price')
        ->setCellValue('D' . $rowNumber, 'Qty')
        ->setCellValue('E' . $rowNumber, 'Total Price');

    $objPHPExcel->getActiveSheet()->getStyle('A' . $rowNumber)->applyFromArray($backgroundColor);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $rowNumber)->applyFromArray($backgroundColor);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $rowNumber)->applyFromArray($backgroundColor);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $rowNumber)->applyFromArray($backgroundColor);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowNumber)->applyFromArray($backgroundColor);

    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $rowNumber)->getAlignment()->setWrapText(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('B' . $rowNumber)->getAlignment()->setWrapText(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('C' . $rowNumber)->getAlignment()->setWrapText(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('D' . $rowNumber)->getAlignment()->setWrapText(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('E' . $rowNumber)->getAlignment()->setWrapText(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle($rowNumber)->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
    );
    foreach ($_POST["id"] as $id) {
        if ($id == 'on') {
            continue;
        }
        $allProduct = getProductsByID($id);
        $product = wc_get_product($allProduct[0]['product_id']);

        $totalQty = getTotalQty($allProduct[0]['product_id'], $estimateId);
        $qty = $totalQty[0]['totalQty'];
        $productQty = $qty != '' ? $qty : 1;


        $with_tax = $product->get_price_including_tax();
        $without_tax = $product->get_price_excluding_tax();
        $tax_amount = $with_tax - $without_tax;
        if ($without_tax != 0) {
            $without_taxTotalPrice = $without_tax * $productQty;
            $subtotal = $subtotal + $without_taxTotalPrice;
            $totalTax = $productQty * $tax_amount;
            $subtotalTax = $subtotalTax + $totalTax;
        } else {
            $productTotalPrice = $product->get_price() * $productQty;
            $subtotal = $subtotal + $productTotalPrice;
            $totalTax = 0;
        }

// Add some data
        $rowNumber2 = $rowNumber + 1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $rowNumber2, $product->get_sku())
            ->setCellValue('B' . $rowNumber2, $product->get_name())
            ->setCellValue('C' . $rowNumber2, $without_tax != 0 ? $without_tax : $product->get_price())
            ->setCellValue('D' . $rowNumber2, $productQty)
            ->setCellValue('E' . $rowNumber2, $without_tax != 0 ? $without_taxTotalPrice : $productTotalPrice);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $rowNumber2)->getNumberFormat()->setFormatCode('@');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('B' . $rowNumber2)->getNumberFormat()->setFormatCode('#');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('C' . $rowNumber2)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('D' . $rowNumber2)->getNumberFormat()->setFormatCode('#');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('E' . $rowNumber2)->getNumberFormat()->setFormatCode('#,##0.00');

        $rowNumber++;

    }
    $grandTotal = $subtotalTax + $subtotal;
    $rowNumber3 = $rowNumber2 + 1;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('D' . $rowNumber3, 'SubTotal')
        ->setCellValue('E' . $rowNumber3, $subtotal);


    $rowNumber4 = $rowNumber2 + 2;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('D' . $rowNumber4, 'Estimated Tax')
        ->setCellValue('E' . $rowNumber4, $subtotalTax);
    $rowNumber5 = $rowNumber2 + 3;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('D' . $rowNumber5, 'Grand Total')
        ->setCellValue('E' . $rowNumber5, $grandTotal);

    $objPHPExcel->getActiveSheet()->getStyle('D' . $rowNumber3)->applyFromArray($totalSection);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $rowNumber4)->applyFromArray($totalSection);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $rowNumber5)->applyFromArray($totalSection);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowNumber3)->applyFromArray($totalSection);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowNumber4)->applyFromArray($totalSection);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $rowNumber5)->applyFromArray($totalSection);

    $objPHPExcel->setActiveSheetIndex(0)->getStyle('E' . $rowNumber3)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('E' . $rowNumber4)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('E' . $rowNumber5)->getNumberFormat()->setFormatCode('#,##0.00');

    $baseRow = 5;

    $rowNumber5 = $rowNumber2 + 5;

    $ErowNumber5 = $rowNumber5 + 3;

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $rowNumber5 . ':E' . $ErowNumber5);


    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $rowNumber5)->getAlignment()->setWrapText(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $rowNumber5)->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
    );


    $rowNumber6 = $rowNumber5 - 1;

    $companyName = get_option('company_name');

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $rowNumber6, 'Price Estimate for planning and information purposes only and is not a binding offer from ' . $companyName);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $rowNumber6 . ':E' . $rowNumber6);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $rowNumber6)->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
    );
    $objPHPExcel->getActiveSheet()->getStyle('A' . $rowNumber6)->applyFromArray($styleArray);

    $estimate_footer = get_option('estimate_export_footer');
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowNumber5, $estimate_footer);


// Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save(str_replace('.php', '.csv', $CSVurl));

    echo 'success';

    wp_die(); // this is required to terminate immediately and return a proper response
}


add_action('wp_ajax_estimate_product_Export_as_Pdf', 'estimate_product_Export_as_Pdf');
add_action('wp_ajax_nopriv_estimate_product_Export_as_Pdf', 'estimate_product_Export_as_Pdf');
function estimate_product_Export_as_Pdf()
{

    $PDFurl = plugin_dir_path(__FILE__) . 'assets/estimate.pdf';
    global $woocommerce;
    $estimateId = $_POST["estimateId"];
    $estimateData = get_estimate_by_id($estimateId);
    $userId = $estimateData['user_id']; //string value use: %s

    $user = get_user_by('ID', $userId);

    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Estimate</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            #pes-export-pdf{
                font-family: Arial, Helvetica, sans-serif;
            }
            #pes-export-pdf .title{
                text-align: center;
                font-size: 30px;
            }
           #pes-export-pdf .header-info-area::after {
                content: "";
                display: table;
                clear: both;
            }
            #pes-export-pdf .create-by-info h4,
            #pes-export-pdf .user-details h4,
            #pes-export-pdf .estimate-details h4 {
                font-size: 14px;
                line-height: 20px;
            }

            #pes-export-pdf .create-by-info,
            #pes-export-pdf .user-details,
            #pes-export-pdf .estimate-details {
                width: 33.33%; 
                float: left; 
                box-sizing: border-box;
            }
            #pes-export-pdf .create-by-info table,
            #pes-export-pdf .user-details table,
            #pes-export-pdf .estimate-details table {
                width: 100%;
                border-collapse: collapse;
            }
            
            #pes-export-pdf .create-by-info td,
            #pes-export-pdf .user-details td,
            #pes-export-pdf .estimate-details td{
                text-align: left;
                font-size: 12px;
                padding: 2px 0px;
            }
        </style>
    </head>
    <body>
    <div class="estimate" id="pes-export-pdf" style="font-size: 14px;page-break-inside: auto">
        <h3 class="title">Price Estimate</h3>


        <div class="header-info-area">

            <div class="create-by-info">
                <h4>CREATED BY</h4>
                <table>
                    <tr>
                        <td>Name</td>
                        <td>: <?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                    </tr>
                    <tr>
                        <td>Company</td>
                        <td>: <?php echo get_user_meta($user->ID, 'company_name', true); ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: <?php echo $user->user_email; ?></td>
                    </tr>
                    <tr>
                        <td>Cell</td>
                        <td>: <?php echo get_user_meta($user->ID, 'mobile', true); ?></td>
                    </tr>
                </table>
            </div>

            <div class="user-details">
                <h4>USER DETAILS</h4>
                <table>
                    <tr>
                        <td>End User</td>
                        <td>: <?php echo $estimateData['user_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Person Name</td>
                        <td>: <?php echo $estimateData['user_contact_person']; ?></td>
                    </tr>
                    <tr>
                        <td>Number</td>
                        <td>: <?php echo $estimateData['user_contact']; ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: <?php echo $estimateData['user_email']; ?></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>: <?php echo $estimateData['user_address']; ?></td>
                    </tr>
                </table>
            </div>

            <div class="estimate-details">
                <h4>ESTIMATE DETAILS</h4>
                <table>
                    <tr>
                        <td>Date</td>
                        <td>: <?php
                            $timestamp = strtotime($estimateData['cdate']);
                            echo date("d-M-Y", $timestamp);

                            ?></td>
                    </tr>
                    <tr>
                        <td>Estimate ID</td>
                        <td>: <?php echo '00' . $estimateId; ?></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>: <?php echo $estimateData['estimate_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>: <?php echo $estimateData['estimate_description']; ?></td>
                    </tr>
                   
                    <tr>
                        <td>Valid Till</td>
                        <td>: <?php $days = get_option('delete_time');
                            $timestamp = strtotime($estimateData['cdate'] . $days . 'day');
                            echo date("d-M-Y", $timestamp); ?></td>
                    </tr>
                </table>
            </div>

        </div>

        <style>
            .wc-es-product-list-pdf-table{
                width: 100%;
                margin: 20px 0px;
            }
            .wc-es-product-list-pdf-table tr,
            .wc-es-product-list-pdf-table th,
            .wc-es-product-list-pdf-table td{
                text-align: left;
                color: #000;
                padding: 10px 10px;
                font-family: Arial, Helvetica, sans-serif;
            }
            .wc-es-product-list-pdf-table th{
                background: #209CEE;
                color: #fff !important;
            }
            .wc-es-product-list-pdf-table tr.stg-tr{
                background: #209CEE;
                color: #fff !important;
            }
            #pes-export-pdf .note p{
                color: red;
                text-align: center;
                font-size: 12px;
            }
            #pes-export-pdf .footer p{
                text-align: center;
                font-size: 12px;
                color: #000;
            }
        </style>

        <!-- Show product list table -->
        <div class="products" style="width:100%; margin-top:10px">
            <table class="wc-es-product-list-pdf-table">
                <tr>
                    <th>SKU</th>
                    <th> Product Name</th>
                    <th> Unit Price</th>
                    <th>Qty</th>
                    <th>Total Price</th>
                </tr>
                <?php
                //print_r($_POST["id"]);
                foreach ($_POST["id"] as $id) {
                    if ($id == 'on') {
                        continue;
                    }
                    $allProduct = getProductsByID($id);
                    $product = wc_get_product($allProduct[0]['product_id']);
                    $totalQty = getTotalQty($allProduct[0]['product_id'], $estimateId);
                    $qty = $totalQty[0]['totalQty'];
                    $productQty = $qty != '' ? $qty : 1;

                    $with_tax = $product->get_price_including_tax();
                    $without_tax = $product->get_price_excluding_tax();
                    $tax_amount = $with_tax - $without_tax;
                    if ($without_tax != 0) {
                        $without_taxTotalPrice = $without_tax * $productQty;
                        $subtotal = $subtotal + $without_taxTotalPrice;
                        $totalTax = $productQty * $tax_amount;
                        $subtotalTax = $subtotalTax + $totalTax;
                    } else {
                        $productTotalPrice = $product->get_price() * $productQty;
                        $subtotal = $subtotal + $productTotalPrice;
                        $totalTax = 0;
                    }
                    ?>
                    <tr>
                        <td>
                            <?php echo $product->get_sku() != '' ? $product->get_sku() : ''; ?>
                        </td>

                        <td>
                            <?php echo $product->get_name(); ?>
                        </td>

                        <td>
                            <?php echo $without_tax != 0 ? number_format($without_tax, 2) : number_format($product->get_price(), 2); ?>
                        </td>
                        <td>
                            <?php echo $productQty; ?>
                        </td>
                        <td>
                            <?php echo $without_tax != 0 ? number_format($without_taxTotalPrice, 2) : number_format($productTotalPrice, 2); ?>
                        </td>
                    </tr>
                <?php } ?>

                <tr class="stg-tr">
                    <td colspan="4">Subtotal</td>
                    <td ><?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <tr class="stg-tr">
                    <td colspan="4">Estimated Tax</td>
                    <td> <?php echo number_format($subtotalTax, 2); ?></td>
                </tr>
                <tr class="stg-tr">
                    <td colspan="4">Grand Total</td>
                    <td><?php echo number_format($subtotalTax + $subtotal, 2); ?></td>
                </tr>

            </table>
        </div>
        <!-- end show product list table -->

        <div class="note">
            <p>Price Estimate for planning and information purposes only and is not a
                binding offer from <?php echo get_option('company_name'); ?></p>
        </div>
        <div class="footer">
            <p><?php echo get_option('estimate_export_footer'); ?></p>
        </div>
    </div>
    </body>
    </html>

    <?php
    $html = ob_get_clean();
    $html = stripslashes($html);

    if (isset($_POST["id"])) {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $dompdf->set_paper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        //$dompdf->stream('estimate.pdf');
        $output = $dompdf->output();
        file_put_contents($PDFurl, $output);

    }

    echo 'success';


    wp_die(); // this is required to terminate immediately and return a proper response
}


add_action('wp_ajax_wc_estimate_product_CSVEmail', 'wc_estimate_product_CSVEmail');
add_action('wp_ajax_nopriv_wc_estimate_product_CSVEmail', 'wc_estimate_product_CSVEmail');

function wc_estimate_product_CSVEmail()
{
    $downloadLink = plugin_dir_url(__FILE__) . 'assets/file.csv';
    $CSVurl = plugin_dir_path(__FILE__) . 'assets/file.csv';

    header('Content-type: text/csv');
    header('Content-disposition: attachment;filename="' . $CSVurl . '"');
    global $woocommerce;
    $id = $_POST['id'];
    if (isset($_POST["id"])) {
        $array = [];
        foreach ($_POST["id"] as $id) {
            $products = getProductsByID($id);

            $array[] = $products[0];

        }
        $fp = fopen($CSVurl, 'w');
        if ($fp === FALSE) {
            die('Failed to open temporary file');
        }
        for ($i = 0; $i < count($array); $i++) {
            fputcsv($fp, $array[$i]);
        }
        fclose($fp);
    }

    global $wpdb;
    $table = $wpdb->prefix . 'innovs_wc_es';
    $data = $wpdb->get_results("SELECT * FROM $table WHERE id='$id'");
    foreach ($data as $user_email) ;
    $u_email = $user_email->user_email;

    $attachments = array( WP_CONTENT_DIR . $downloadLink );

    //var_dump($attachments); die;


    $email = get_option('admin_email');
    //$email = 'mdrussel575@gmail.com';
    $message = "Product quote and estimate";


    //$to = 'mdrussel757@gmail.com';
    $to = $u_email;
    $subject = "Product quote and estimate";
    $head = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n";


    //Here put your Validation and send mail
    $sent = wp_mail($to, $subject, strip_tags($message), $head, $attachments);
    if ($sent) {
        echo "Success";
    } else {
        echo "Fail";
    }

    wp_die(); // this is required to terminate immediately and return a proper response

}


function getProductsByID($id)
{
    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es_products";
    $sql = "Select * from $tablename where `id` = '$id'";
    $values = $wpdb->get_results($sql, ARRAY_A);
    return $values;
}


add_action('wp_ajax_product_get_by_id', 'product_get_by_id');
add_action('wp_ajax_nopriv_product_get_by_id', 'product_get_by_id');

function product_get_by_id()
{
    global $wpdb;

    $tablename = $wpdb->prefix . "innovs_wc_es_products";

    $productID = sanitize_text_field($_POST['productID']);
    $estimateId = sanitize_text_field($_POST['estimateId']);
    $product = wc_get_product($productID);

    $productName = $product->get_name();
    $productPrice = $product->get_price();
    $getQty = getTotalQty($productID, $estimateId);
    $qty = $getQty[0]['totalQty'];
    $productQty = $qty + 1;
    $productTotalPriceByID = $productPrice * $productQty;

    if (empty(productIdCheckInEstimate($productID, $estimateId))) {
        $sql = $wpdb->prepare("INSERT INTO `$tablename` (`estimate_id`,`product_id`, `product_name`, `qty`, `price`, `total_price`) values (%d, %d, %s, %s, %s, %s)", $estimateId, $productID, $productName, $productQty, $productPrice, $productTotalPriceByID);
    } else {
        $sql = $wpdb->prepare("UPDATE `$tablename`
		SET `qty` = '$productQty',
				`total_price` = '$productTotalPriceByID'
		WHERE  `estimate_id` = %d AND `product_id` = %d", $estimateId, $productID);
    }

    $wpdb->query($sql);

    ob_start();

    $allProducts = allGetProducts($estimateId);
    $subtotal = 0;
    foreach ($allProducts as $productItem) {
        $product = wc_get_product($productItem['product_id']);
        $totalQty = getTotalQty($productItem['product_id'], $estimateId);
        $qty = $totalQty[0]['totalQty'];
        $productQty = $qty != '' ? $qty : 1;

        $with_tax = $product->get_price_including_tax();
        $without_tax = $product->get_price_excluding_tax();
        $tax_amount = $with_tax - $without_tax;
        if ($without_tax != 0) {
            $without_taxTotalPrice = $without_tax * $productQty;
            $subtotal = $subtotal + $without_taxTotalPrice;
            $totalTax = $productQty * $tax_amount;
            $subtotalTax = $subtotalTax + $totalTax;
        } else {
            $productTotalPrice = $product->get_price() * $productQty;
            $subtotal = $subtotal + $productTotalPrice;
            $totalTax = 0;
        }

        ?>
        <div class="productListBody">
        <div class="product" id="remove<?php echo $productItem['id']; ?>">
            <div class="product-removal">
                <div class="checkBox">
                    <input value="<?php echo $productItem['id']; ?>" type="checkbox">
                </div>
            </div>
            <div class="product-code text-left"><?php echo $product->get_sku() != '' ? $product->get_sku() : 'Empty'; ?></div>
            <div class="product-details">
                <div class="product-title"><?php echo $product->get_name(); ?></div>
                <p class="product-description"> It has a lightweight, breathable mesh upper with forefoot cables for a
                    locked-down fit.</p>
            </div>
            <div class="product-price text-right"><?php echo $without_tax != 0 ? number_format($without_tax, 2) : number_format($product->get_price(), 2); ?></div>
            <div class="product-quantity text-right">
                <input type="text" data-id="<?php echo $productItem['id']; ?>"
                       value="<?php echo esc_attr($productQty); ?>" min="1">
            </div>
            <input type="hidden" class="tax-amount" value="<?php echo number_format($tax_amount, 2); ?>">
            <input type="hidden" class="sub-tax-amount" value="<?php echo number_format($totalTax, 2); ?>">
            <div class="product-line-price"><?php echo $without_tax != 0 ? number_format($without_taxTotalPrice, 2) : number_format($productTotalPrice, 2); ?></div>
        </div>
    <?php } ?>
    <div class="totals">
        <div class="totals-item">
            <label>Subtotal</label>
            <div class="totals-value" id="cart-subtotal"> <?php echo number_format($subtotal, 2); ?></div>
        </div>
        <div class="totals-item">
            <label>Tax</label>
            <div class="totals-value" id="cart-tax"> <?php echo number_format($subtotalTax, 2); ?></div>
        </div>

        <div class="totals-item totals-item-total">
            <label>Grand Total</label>
            <div class="totals-value" id="cart-total"> <?php echo number_format($subtotalTax + $subtotal, 2); ?></div>
        </div>
    </div>
    </div>
    <?php
    $listCard = ob_get_clean();

    echo $listCard;

    wp_die(); // this is required to terminate immediately and return a proper response
}


function productIdCheck($id)
{
    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es_products";
    $sql = "Select * from $tablename where `id` = '$id'";
    $values = $wpdb->get_results($sql, ARRAY_A);
    return $values;
}

function productIdCheckInEstimate($product_id, $estimate_id)
{
    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es_products";
    $sql = "Select * from $tablename where `product_id` = '$product_id' AND estimate_id = '$estimate_id'";
    $values = $wpdb->get_results($sql, ARRAY_A);
    return $values;
}

function getTotalQty($productId, $estimateId)
{
    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es_products";
    $sql = "SELECT product_id,SUM(qty) as totalQty FROM $tablename Where estimate_id = '$estimateId' and  product_id = $productId GROUP BY product_id;";
    $values = $wpdb->get_results($sql, ARRAY_A);
    return $values;
}

function allGetProducts($estimateId)
{
    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es_products";
    $sql = "Select * from $tablename Where estimate_id = '$estimateId'  Group By product_id Order by id ASC";
    $values = $wpdb->get_results($sql, ARRAY_A);
    return $values;
}

add_action('wp_ajax_product_search', 'product_search');
add_action('wp_ajax_nopriv_product_search', 'product_search');
function product_search()
{
    $search = $_REQUEST['keyword'];

    if (!empty($search)) {
        global $wpdb;
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 10,
            'order' => 'DESC',
            's' => $_REQUEST['keyword'],
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'post_title',
                    'value' => $_REQUEST['keyword'],
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'post_title',
                    'compare' => 'NOT EXISTS',
                ),
            )
        );
    } else {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 10,
            'order' => 'DESC'
        );
    }
    $the_query = new WP_Query($args);

    if (!empty($the_query)) {
        $html = '';
        foreach ($the_query->posts as $product) {

            $html .= '<a data-id="' . $product->ID . '" data-estimateId = "' . $_GET['estimate-id'] . '" class="add_list cart-add-btn list-group-item list-group-item-action bg-light" href="#">' . $product->post_title . ' <span class="btn-show-hover">Add</span></a>';

        }
        echo $html;
    }

    wp_die();
}


//  Insert Quote form date
add_action('wp_ajax_qoute_insert', 'qoute_insert');
add_action('wp_ajax_nopriv_qoute_insert', 'qoute_insert');

function qoute_insert()
{

    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es_quote";

    $quote_f_name = sanitize_text_field($_POST['quote_f_name']);
    $quote_l_name = sanitize_text_field($_POST['quote_l_name']);
    $name = $quote_f_name . ' ' . $quote_l_name;

    $qoute_email = sanitize_email($_POST['qoute_email']);

    $qoute_area_code = sanitize_text_field($_POST['qoute_area_code']);
    $qoute_pn = sanitize_text_field($_POST['qoute_pn']);
    $phone = $qoute_area_code . ' ' . $qoute_pn;

    $qoute_add_1 = sanitize_text_field($_POST['qoute_add_1']);
    $qoute_add_2 = sanitize_text_field($_POST['qoute_add_2']);
    $address = $qoute_add_1 . ' ' . $qoute_add_2;

    $qoute_city = sanitize_text_field($_POST['qoute_city']);
    $qoute_state = sanitize_text_field($_POST['qoute_state']);
    $qoute_post_code = sanitize_text_field($_POST['qoute_post_code']);
    $qoute_country = sanitize_text_field($_POST['qoute_country']);
    $qoute_product = sanitize_text_field($_POST['qoute_product']);
    $qoute_quantity = sanitize_text_field($_POST['qoute_quantity']);
    $qoute_add_info = sanitize_text_field($_POST['qoute_add_info']);

    $sql = "INSERT INTO $tablename (`estimate_id`, `product_id`, `name`, `email`, `phone`, `address`, `city`, `state`, `post_code`, `country`, `product`, `quantity`, `additional_info`) VALUES ('1','1','$name','$qoute_email','$phone','$address','$qoute_city','$qoute_state','$qoute_post_code','$qoute_country','$qoute_product','$qoute_quantity','$qoute_add_info')";

    $wpdb->query($sql);

    wp_die(); // this is required to terminate immediately and return a proper response
}

//  Send Quote form date in database
add_action('wp_ajax_send_quote', 'send_quote');
add_action('wp_ajax_nopriv_send_quote', 'send_quote');

function send_quote()
{

    global $wpdb;
    $tablename = $wpdb->prefix . "innovs_wc_es_quote";
    $product_table = $wpdb->prefix . "innovs_wc_es_products";
    $quote_details = $wpdb->prefix . "innovs_product_quote_details";

    $estimate_id = sanitize_text_field($_POST['estimate_id']);
    $pe_quote_price = sanitize_text_field($_POST['pe_quote_price']);
    $pe_quote_desc = sanitize_text_field($_POST['pe_quote_desc']);

    $sql = "INSERT INTO $tablename (`estimate_id`,`quote_price`, `additional_info`) VALUES ('$estimate_id','$pe_quote_price','$pe_quote_desc')";
    $wpdb->query($sql);

    $last_id = $wpdb->insert_id;
    $products = estimateProducts($estimate_id);
    foreach ($products as $product) {
        $quote_sql = "INSERT INTO $quote_details (quote_id,product_name, qty,price,total_price) VALUES ('$last_id','$product->product_name','$product->qty','$product->price','$product->total_price')";
        $wpdb->query($quote_sql);
    }


    wp_die(); // this is required to terminate immediately and return a proper response
}

function estimateProducts($estimate_id)
{
    global $wpdb;
    $estimate_product_table = $wpdb->prefix . "innovs_wc_es_products";
    $products = $wpdb->get_results("SELECT * FROM $estimate_product_table WHERE estimate_id='$estimate_id'");
    return $products;
}


//  Send Quote form date in database
add_action('wp_ajax_quote_view_details', 'quote_view_details');
add_action('wp_ajax_nopriv_quote_view_details', 'quote_view_details');

function quote_view_details(){

    global $wpdb;
    $quote_table = $wpdb->prefix . "innovs_wc_es_quote";
    $quote_details = $wpdb->prefix . "innovs_product_quote_details";

    $id = sanitize_text_field($_POST['id']);
    $quoteData = $wpdb->get_results("SELECT * FROM $quote_details WHERE quote_id='$id'");
    $sum = 0;
    ob_start();
    ?>
    <table class="table table-bordered">
        <tr>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Sub Total</th>
        </tr>
        <?php foreach ($quoteData as $data) { ?>
            <tr>
                <td><?php echo ese_attr($data->product_name); ?></td>
                <td><?php echo ese_attr($data->qty); ?></td>
                <td><?php echo esc_attr(get_option('set_currency'));
                    echo ese_attr($data->price); ?></td>
                <td><?php echo esc_attr(get_option('set_currency'));
                    echo ese_attr($data->total_price); ?></td>
            </tr>

            <?php
            $sum += $data->total_price;
        }
        ?>
        <tr>
            <th colspan="3" class="text-right">Total Price</th>
            <td><?php echo esc_attr(get_option('set_currency')); echo $sum; ?></td>
        </tr>
    </table>
    <?php
    return $obj = ob_get_clean();
    wp_die(); // this is required to terminate immediately and return a proper response
}
?>