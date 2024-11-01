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
    $estimateId =  isset($_GET['estimate-id']) ? $_GET['estimate-id'] : '';
    $details =  WC_es_Public::get_details_innovs_wc_es($estimateId); 
?>

<div class="container pe-container" style="margin-top:100px">
    <div class="row">

        <div class="col-md-3">
            <?php  require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/part/sidebar.php'; ?>
        </div>

        <div class="col-md-9 estimate_section"> 
            <div class="card">
              
              <div class="card-header innovs-pe-card-header">
                <span class="create-es-title"><i class="far fa-plus-square"></i> Edit Estimate</span> 
                <span class="see-es-list-title"><a class="social-icon text-xs-center"  href="<?php echo home_url(); ?>/estimate_list"><i class="far fa-list-alt"></i> Estimate List</a></span>
              </div>

              <div class="card-body">

                <form action="" method="post">
                <div class="row">
                  <div class="col-md-6">

                      <div class="form-group">
                        <label for="email">Estimate Name</label>
                        <input type="hidden" class="form-control pe-form-input" name="estimateId" id="estimateIdEdit" value="<?php echo isset( $details[0]->id ) ?  $details[0]->id : ''; ?>">
                        <input type="text" class="form-control pe-form-input" value="<?php echo isset( $details[0]->estimate_name ) ?  $details[0]->estimate_name : ''; ?>" name="estimateName" id="estimateNameEdit">
                      </div>
                      <div class="form-group">
                          <label for="pwd">Estimate Description</label>
                          <textarea name="description" id="descriptionEdit" cols="30" rows="7"><?php echo  isset( $details[0]->estimate_description ) ?  $details[0]->estimate_description : ''; ?></textarea>
                      </div> 
                      
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="pwd">Name</label>
                        <input type="text" class="form-control pe-form-input" value="<?php echo  isset( $details[0]->user_name ) ?  $details[0]->user_name : ''; ?>" name="UserName" id="UserNameEdit">
                      </div> 

                      <div class="form-group">
                          <label for="pwd">Contact Person</label>
                          <input type="text" class="form-control pe-form-input" name="UserContactPerson" id="UserContactPersonEdit" value="<?php echo isset(  $details[0]->user_contact_person ) ?   $details[0]->user_contact_person : ''; ?>">
                      </div>

                      <div class="form-group">
                          <label for="pwd">Contact Number</label>
                          <input type="text" class="form-control pe-form-input" name="UserContact" id="UserContactEdit" value="<?php echo isset(  $details[0]->user_contact ) ?   $details[0]->user_contact : ''; ?>">
                      </div> 
                      
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control pe-form-input" value="<?php echo isset(  $details[0]->user_email ) ?   $details[0]->user_email : ''; ?>" name="UserEmail" id="UserEmailEdit">
                      </div>

                      <div class="form-group">
                          <label for="pwd">Address</label>
                          <textarea name="UserAddress" value="<?php echo  isset( $details[0]->user_address ) ?  $details[0]->user_address  : ''; ?>" id="UserAddressEdit" cols="30" rows="2"><?php echo  isset( $details[0]->user_address ) ?  $details[0]->user_address : ''; ?></textarea>
                      </div>

                    </div>
                </div>

                <div class="col-md-12  text-right p0">
                  <button type="submit" id="estimateEdit" class="btn btn-primary">Save</button>
                </div>

                </form>
              </div>

            </div>
            <?php require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/part/estimate_cart.php'; ?>
        </div> <!-- end col-md-9 -->

    </div> <!-- end row -->
</div> <!-- end container -->

<?php
  get_footer();
?>
