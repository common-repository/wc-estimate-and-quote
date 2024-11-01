<div class="estimate-cart">
    <div class="card innovs-pe-card">
        <div class="card-header innovs-pe-card-header">
            <span class="titleList"><i class="far fa-list-alt"></i> List Products</span>
            <ul class="list-inline listMenu innovs-pe-decec-menu">
                <li class="list-inline-item"><a id="btn_delete" class="social-icon text-xs-center" href="#"><i class="fas fa-times"></i> Delete</a></li>
                <li class="list-inline-item nav-item innovs-pe-export-dropdown dropdown">
                    <a class="social-icon text-xs-center nav-link dropdown-toggle " data-toggle="dropdown" href="#"><i class="fas fa-external-link-alt"></i> Export</a>
                    <div class="dropdown-menu innovs-pe-dropdown">
                        <a class="dropdown-item"
                           data-id="<?php echo isset($_GET['estimate-id']) ? $_GET['estimate-id'] : ''; ?>" id="btn_export_pdf" href="#">Export as pdf</a>
                        <a class="dropdown-item" data-id="<?php echo isset($_GET['estimate-id']) ? $_GET['estimate-id'] : ''; ?>" id="btn_export_csv" href="#">Export as csv</a>
                    </div>
                </li>
                <li class="list-inline-item"><a id="estimate_clone" data-id="<?php echo isset($_GET['estimate-id']) ? $_GET['estimate-id'] : ''; ?>" class="social-icon text-xs-center" target="_blank" href="#"><i class="far fa-clone"></i> Clone</a></li>
                <li class="list-inline-item"><a id="wc_btn_email" data-id="<?php echo isset($_GET['estimate-id']) ? $_GET['estimate-id'] : ''; ?>" class="social-icon text-xs-center" target="_blank" href="#"><i class="far fa-envelope"></i> Email</a></li>
                <li class="list-inline-item"><a id="btn_convert" class="social-icon text-xs-center" href="#"><i class="fas fa-recycle"></i> Convert To Cart</a></li>
                <li class="list-inline-item"><a id="btn_quote" class="social-icon text-xs-center" href="#pe_quote_frm"><i class="fas fa-dollar-sign"></i> Quote</a></li>
            </ul>
        </div>
        <div class="card-body innovs-pe-card-body">

            <div class="shopping-cart innovs-pe-shoppin-cart">
                <?php
                $estimateId = isset($_GET['estimate-id']) ? $_GET['estimate-id'] : '';
                $allProducts = WC_es_Public::allGetProducts($estimateId);

                ?>
                <div class="column-labels innovs-pe-colums-labels">
                    <label class="product-removal"><input id="checkAll" type="checkbox" class="innovs-pe-checkall"></label>
                    <label class="product-code">SKU</label>
                    <label class="product-details text-left">Product Name</label>
                    <label class="product-price text-right">Unit Price</label>
                    <label class="product-quantity text-right">Quantity</label>
                    <label class="product-line-price text-right">Total</label>
                </div>

                <div class="productListBody">
                    <?php
                    if (!empty($allProducts)){
                    $subtotal = 0;
                    $totalTax = 0;
                    $subtotalTax = 0;
                    foreach ($allProducts as $productItem) {
                        $product = wc_get_product($productItem['product_id']);
                        $totalQty = WC_es_Public::getTotalQty($productItem['product_id'], $estimateId);
                        $qty = $totalQty[0]['totalQty'];
                        $productQty = $qty != '' ? $qty : 1;
                        $with_tax = wc_get_price_including_tax($product);
                        $without_tax = wc_get_price_excluding_tax($product);
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

                        <div id="remove<?php echo $productItem['id']; ?>" class="product">
                            <div class="product-removal">
                                <div class="checkBox">
                                    <input name="products_id[]" id="checkboxes-0"
                                        value="<?php echo $productItem['id']; ?>" type="checkbox"
                                        data-id="<?php echo $productItem['id']; ?>"
                                        data-estimateId="<?php echo $estimateId; ?>"
                                        data-productId="<?php echo $productItem['product_id']; ?>"
                                        data-nonce="<?php echo wp_create_nonce('productDelete'); ?>">
                                </div>
                            </div>
                            <div class="product-code text-left"><?php echo $product->get_sku() != '' ? $product->get_sku() : 'Empty'; ?></div>
                            <div class="product-details">
                                <div class="product-title"><?php echo $product->get_name(); ?></div>
                                <p class="product-description"> It has a lightweight, breathable mesh upper with
                                    forefoot cables for a locked-down fit.</p>
                            </div>
                            <div class="product-price text-right"><?php echo $without_tax != 0 ? number_format($without_tax, 2) : number_format($product->get_price(), 2); ?></div>
                            <div class="product-quantity text-right">
                                <input type="text" data-id="<?php echo $productItem['id']; ?>" value="<?php echo $productQty; ?>" min="1">
                            </div>
                            <input type="hidden" class="tax-amount" value="<?php echo number_format($tax_amount, 2); ?>">
                            <input type="hidden" class="sub-tax-amount" value="<?php echo number_format($totalTax, 2); ?>">
                            <div class="product-line-price"><?php echo $without_tax != 0 ? number_format($without_taxTotalPrice, 2) : number_format($productTotalPrice, 2); ?></div>
                        </div>

                    <?php } ?>
                    <div class="totals">
                        <div class="totals-item">
                            <label>Subtotal</label>
                            <div class="totals-value"
                                 id="cart-subtotal"> <?php echo number_format($subtotal, 2); ?></div>
                        </div>
                        <div class="totals-item">
                            <label>Estimated Tax</label>
                            <div class="totals-value" id="cart-tax"> <?php echo number_format($subtotalTax, 2); ?></div>
                        </div>

                        <div class="totals-item totals-item-total">
                            <label>Grand Total</label>
                            <div class="totals-value"
                                 id="cart-total"> <?php echo number_format($subtotalTax + $subtotal, 2); ?></div>
                        </div>
                    </div>
                </div>
                <!-- <button class="btn btn-primary float-right">Export</button> -->
            <?php } else {
                 echo 'No Products';
            } ?>
            </div>
            <div class="pe-quote-input" id="pe_quote_frm" style="display:none">
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <form action="" class="pe-quote-frm">
                            <div class="row">
                                <div class="col-md-5">
                                    <p>Set quote price</p>
                                </div>
                                <div class="col-md-7">
                                    <p>
                                        <input type="hidden" id="estimate_id" value="<?php echo esc_attr($estimateId); ?>">
                                        <input type="hidden" id="quote_product_id" value="<?php echo esc_attr($productItem['id']); ?>">
                                        <input type="text" id="pe_quote_price" class="form-control pe-form-input" placeholder="10">

                                    <div class=" my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend pe-form-input">
                                                <div class="input-group-text"><?php echo esc_attr(get_option('set_currency')); ?></div>
                                            </div>
                                            <input type="text" class="form-control pe-form-input" id="pe_quote_price" placeholder="50">
                                        </div>
                                    </div>
                                    </p>
                                </div>
                            </div>
                            <p>
                                <textarea name="" id="pe_quote_desc" placeholder="Description" cols="5" rows="8" class=""></textarea>
                            </p>
                            <p>
                                <input type="submit" id="pe_quote_send_btn" class="btn btn-primary pe-quote-send-btn" value="Send Quote">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>