<?php
    $getQuoteList = WC_es_Admin::getQuoteList();
?>

<div class="wrap">
    <div class="container-fuild" style="margin-top:30px">
        <div class="row">
            <div class="col-md-12 estimate_section">
                <div class="card">
                    <div class="card-header innovs-pe-card-header">
                        <h3>Quote Lists</h3>
                        <ul class="list-inline listMenu">
                        </ul>
                    </div>
                    <div classa="card-body">
                        <div class="table-responsive" style="margin-top:20px">
                            <table id="quoteTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Eamil</th>
                                    <th>Phone</th>
                                    <th>Quote Price</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($getQuoteList as $key => $data):
                                    ?>
                                    <tr>
                                        <td><?php echo esc_attr($data->estimate_name); ?></td>
                                        <td><?php echo esc_attr($data->user_email); ?></td>
                                        <td><?php echo esc_attr($data->user_contact); ?></td>
                                        <td class="quote-price"><?php echo esc_attr(get_option('set_currency'));
                                            echo esc_attr($data->quote_price); ?></td>
                                        <td class="quote-price"><?php echo esc_attr(get_option('set_currency'));
                                            echo esc_attr($data->total); ?></td>
                                        <td><a data-id="<?php echo esc_attr($data->quote_id); ?>" id="viewQuoteDetails" href="">View</a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Eamil</th>
                                    <th>Phone</th>
                                    <th>Quote Price</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="bundle-pakage" aria-label="Page navigation example">
                    <?php echo do_shortcode(' [products limit="4" columns="4" category="bundle-product" cat_operator="AND"] '); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade example-modal-lg mt-4" id="viewQuoteDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header es-modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Quote Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <p>Name</p>
                            </div>
                            <div class="col-md-6">
                                <p id="q_name"></p>
                            </div>
                            <div class="col-md-4">
                                <p>Email</p>
                            </div>
                            <div class="col-md-6">
                                <p id="q_email"></p>
                            </div>
                            <div class="col-md-4">
                                <p>Phone</p>
                            </div>
                            <div class="col-md-6">
                                <p id="q_phone"></p>
                            </div>
                            <div class="col-md-4">
                                <p>Price</p>
                            </div>
                            <div class="col-md-6">
                                <p id="q_price"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <p>Country</p>
                            </div>
                            <div class="col-md-6">
                                <p id="q_country"></p>
                            </div>
                            <div class="col-md-4">
                                <p>Post Code</p>
                            </div>
                            <div class="col-md-6">
                                <p id="q_postcode"></p>
                            </div>
                            <div class="col-md-4">
                                <p>Quantity</p>
                            </div>
                            <div class="col-md-6">
                                <p id="q_qunetity"></p>
                            </div>
                            <div class="col-md-4">
                                <p>Addi Info</p>
                            </div>
                            <div class="col-md-6">
                                <p id="q_addi_info"></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>