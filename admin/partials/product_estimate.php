<?php
    global $current_user;
    wp_get_current_user();
    $userId = $current_user->ID;
    $estimateList = WC_es_Admin::get_all_innovs_wc_es();
?>
<div class="wrap">
    <div class="container-fuild" style="margin-top:30px">
        <div class="row">
            <div class="col-md-12 estimate_section">
                <div class="card">
                    <div class="card-header innovs-pe-card-header">
                        <h3>Estimate List</h3>
                        <ul class="list-inline listMenu">
                            <!-- <li class="list-inline-item"><a class="social-icon text-xs-center" href="<?php echo home_url(); ?>/estimate">Create Estimate</a></li> -->
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="estimate" class="display table table-border" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Estimate Name</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($estimateList as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo esc_attr($value->id); ?></td>
                                        <td><?php echo esc_attr($value->estimate_name); ?></td>
                                        <td><?php echo esc_attr($value->user_name); ?></td>
                                        <td><?php echo esc_attr($value->user_email); ?></td>
                                        <td><?php echo esc_attr($value->user_contact); ?></td>
                                        <td><?php echo esc_attr($value->user_address); ?></td>
                                        <td><?php echo esc_attr($value->cdate); ?></td>
                                        <td>
                                            <a target=_blank
                                            href="<?php echo home_url(); ?>/estimate_edit?estimate-id=<?php echo esc_attr($value->id); ?>">Edit</a>
                                            | <a class="estimateDelete"
                                                data-nonce="<?php echo wp_create_nonce('estimateDelete'); ?>"
                                                data-id="<?php echo $value->id; ?>" href="#">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Estimate Name</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Created Date</th>
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