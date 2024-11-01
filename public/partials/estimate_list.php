<?php
  /* Template Name: Product Estimate Page */
    if ( !is_user_logged_in() ) {
      header('Location: ' . wp_login_url());
    } 
    //wp_head();

    get_header();
    global $current_user;
    wp_get_current_user();
    $userId =  $current_user->ID;
    $estimateList = WC_es_Public::get_all_innovs_wc_es();
?>

<div class="container pe-container" style="margin-top:100px">
  <div class="row">
  <div class="col-md-3">
  <?php  require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/part/sidebar.php'; ?>
  </div>
  <div class="col-md-9 estimate_section"> 
    
    <div class="card">
        <div class="card-header innovs-pe-card-header">
         <span><i class="far fa-list-alt"></i> Estimate List</span> 
          <span class="see-es-list-title"><a class="social-icon text-xs-center"  href="<?php echo home_url(); ?>/estimate"><i class="far fa-plus-square"></i> Create Estimate</a></span>
        </div>
        <div class="card-body innovs-pe-card-body">
        <div class="table-responsive">          
          <table class="table table-hover innovs-pe-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Estimate Name</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Date</th>
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
                <td><?php echo  esc_attr($value->user_contact); ?></td>
                 <td><?php echo  esc_attr($value->cdate); ?></td>
                <td>
                  <a href="<?php echo home_url(); ?>/estimate?estimate-id=<?php echo esc_attr($value->id); ?>"><i class="far fa-edit"></i></a> | <a class="estimateDelete" data-nonce="<?php echo wp_create_nonce( 'estimateDelete' ); ?>" data-id="<?php echo $value->id; ?>" href="#"><i class="far fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php   } ?>
            </tbody>
          </table>
          </div>
        </div>
     </div>

    <div class="bundle-pakage">
    </div>
  </div>
  </div>
</div>

<?php
  get_footer();
?>
