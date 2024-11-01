<?php
    /* Template Name: Product Estimate Quote Page */
    if ( !is_user_logged_in() ) {
        header('Location: ' . wp_login_url());
    }
    //wp_head();

    get_header();
    global $current_user;
    wp_get_current_user();

    $userId =  $current_user->ID;
    $estimateId =  isset($_GET['estimate-id']) ? $_GET['estimate-id'] : '';
    $details =  WC_es_Public::get_details_innovs_wc_es($estimateId);
?>

<div class="container pe-container"  style="margin-top:50px; margin-bottom:50px">
    <div class="row">
        <div class="pe-qoute-form">
            <h4 class="pe-quote-title">Get A Qoute</h4>
            <hr>
            <form action="" method="post">
                <div class="pe-quote-name-field">
                    <div class="row">
                        <div class="col-md-4">
                            <p>Name <span>*</span></p>
                        </div>
                        <div class="col-md-4">
                            <p><input type="text" name="first_name" id="quote_f_name" class="form-control pe-firstname"><small>First Name</small></p>
                        </div>
                        <div class="col-md-4">
                            <p><input type="text" name="last_name" id="quote_l_name" class="form-control pe-lastname"><small>Last Name</small></p>
                        </div>
                    </div>
                </div>
                <div class="pe-quote-email-field">
                    <div class="row">
                        <div class="col-md-4">
                            <p>E-mail <span>*</span></p>
                        </div>
                        <div class="col-md-8">
                            <p><input type="email" name="email" id="qoute_email" class="form-control pe-email pe-form-input"><small></small></p>
                        </div>
                    </div>
                </div>
                <div class="pe-quote-phone-field">
                    <div class="row">
                        <div class="col-md-4">
                            <p>Phone Number <span>*</span></p>
                        </div>
                        <div class="col-md-2">
                            <p><input type="text" name="area_code" id="qoute_area_code" class="form-control pe-area-code"><small>Area code</small></p>
                        </div>
                        <div class="col-md-1">
                            <p>-</p>
                        </div>
                        <div class="col-md-5">
                            <p><input type="text" name="phone" id="qoute_pn" class="form-control pe-phone"><small>Phone Number</small></p>
                        </div>
                    </div>
                </div>
                <div class="pe-quote-address-field">
                    <div class="row">
                        <div class="col-md-4">
                            <p>Address <span>*</span></p>
                        </div>
                        <div class="col-md-8">
                            <p><input type="text" name="address_1" id="qoute_add_1" class="form-control pe-address-1"><small>Address 1</small></p>
                            <p><input type="text" name="address_2" id="qoute_add_2" class="form-control pe-address-2"><small>Address 2</small></p>
                            <div class="row">
                                <div class="col-md-6">
                                <p><input type="text" name="city" id="qoute_city" class="form-control pe-city"><small>City</small></p>
                                </div>
                                <div class="col-md-6">
                                <p><input type="text" name="state" id="qoute_state" class="form-control pe-state"><small>State</small></p>
                                </div>
                                <div class="col-md-6">
                                <p><input type="text" name="post_code" id="qoute_post_code" class="form-control pe-postcode"><small>Post code</small></p>
                                </div>
                                <div class="col-md-6">
                                <p><input type="text" name="country" id="qoute_country" class="form-control pe-country"><small>Country</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pe-quote-which-product-field">
                    <div class="row">
                        <div class="col-md-4">
                            <p>Which Product? <span>*</span></p>
                        </div>
                        <div class="col-md-8">
                            <p><input type="text" name="product" id="qoute_product" class="form-control"><small></small></p>
                        </div>
                    </div>
                </div>
                <div class="pe-quote-quantitly-field">
                    <div class="row">
                        <div class="col-md-4">
                            <p>Quantitly <span>*</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><input type="Number" id="qoute_quantity" name="quantity" class="form-control pe-number pe-form-input"><small></small></p>
                        </div>
                    </div>
                </div>
                <div class="pe-quote-additional-info-field">
                    <div class="row">
                        <div class="col-md-4">
                            <p>Additional Info <span></span></p>
                        </div>
                        <div class="col-md-8">
                            <p><textarea class="form-control pe-additional" id="qoute_add_info" name="additional_info" id="" cols="30" rows="3"></textarea><small></small></p>
                        </div>
                    </div>
                </div>
                <div class="pe-quote-submit-button">
                    <div class="row">
                        <div class="col-md-8 offset-md-4">
                            <p><input type="submit" class="" value="Send qoute" id="insert_qoute" name="quote_submit"></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    get_footer();
?>
