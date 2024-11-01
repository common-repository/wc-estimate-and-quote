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


<div class="container pe-container"  style="margin-top:50px; margin-bottom:50px">
  <div class="row">

    <div class="col-md-3">
      <?php  require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/part/sidebar.php'; ?>
    </div>

    <div class="col-md-9 estimate_section"> 
        <div class="card innovs-pe-card">
            <div class="estimateDetails" style="<?php echo $estimateId ?  'display:block' : 'display:none'   ?>" >
              <div class="card-header innovs-pe-card-header">
                <span><img style="width: 16px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/details.svg'; ?>" alt=""> Details Estimate</span> 
                <span class="see-es-list-title"><a class="social-icon text-xs-center" href="<?php echo home_url(); ?>/estimate"><i class="far fa-plus-square"></i> Create Estimate</a></span>
              </div>

              <div class="card-body innovs-pe-card-body"> 
                <div class="row">
                  <div class="col-md-6">
                    <p>Estimate ID : <span>#NS00<?php echo isset($details[0]->id) ?  $details[0]->id : ''  ?></span></p>
                    <p>Estimate Name : <span><?php echo  isset($details[0]->estimate_name) ?  $details[0]->estimate_name : '' ?></span></p>
                    <p>Estimate Description : <span><?php echo  isset($details[0]->estimate_description) ?  $details[0]->estimate_description : '' ?></span></p>
                  </div>
                  <div class="col-md-6">
                    <a class="float-right" href="estimate_edit?estimate-id=<?php echo  isset($details[0]->id) ?  $details[0]->id : '' ?>"><img style="width: 16px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/edit.svg'; ?>" alt=""></a>
                    <p>Name : <span><?php echo  isset($details[0]->user_name) ?  $details[0]->user_name : '' ?></span></p>
                    <p>Email : <span><?php echo  isset($details[0]->user_email) ?  $details[0]->user_email : '' ?></span></p>
                    <p>Contact Person : <span><?php echo  isset($details[0]->user_contact_person) ?  $details[0]->user_contact_person : '' ?></span></p>
                    <p>Contact Number : <span><?php echo  isset($details[0]->user_contact) ?  $details[0]->user_contact : '' ?></span></p>
                    <p>Address : <span><?php echo  isset($details[0]->user_address) ?  $details[0]->user_address : '' ?></span></p>
                  </div>
                </div>
              </div>
            </div>
        </div>

        <div class="estimateForm" style="<?php echo $estimateId ?  'display:none' : 'display:block'   ?>">
          <div class="card-header innovs-pe-card-header">
            <span class="create-es-title"><i class="far fa-plus-square"></i> Create Estimate</span> 
            <span class="see-es-list-title"><a class="social-icon text-xs-center"  href="<?php echo home_url(); ?>/estimate_list"><i class="far fa-list-alt"></i> Estimate List</a></span>
          </div>

          <div class="card-body innovs-pe-card-body"> 
            <form  class="pb-4 innovs-pe-frm" action="">
              <div class="row">

                  <div class="col-md-6">
                      <div class="form-group ">
                          <label for="">Estimate Name</label>
                          <input type="hidden" class="form-control" name="userId" id="userId" value="<?php echo  $userId; ?>">
                          <input type="text" class="form-control pe-form-input" name="estimateName" id="estimateName">
                      </div>
                      <div class="form-group">
                          <label for="">Estimate Description</label>
                          <textarea name="description" class="form-control" rows="20" id="description"></textarea>
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control pe-form-input" name="UserName" id="UserName">
                      </div> 
                      <div class="form-group">
                        <label for=""> Contact Person</label>
                        <input type="text" class="form-control pe-form-input" name="UserContactPerson" id="UserContactPerson">
                      </div> 
                      <div class="form-group">
                        <label for=""> Contact Number</label>
                        <input type="text" class="form-control pe-form-input" name="UserContact" id="UserContact">
                      </div> 
                    
                      <div class="form-group">
                        <label for="email"> Email</label>
                        <input type="email" class="form-control pe-form-input" name="UserEmail" id="UserEmail">
                      </div> 
                      <div class="form-group">
                        <label for=""> Address</label>
                        <textarea name="UserAddress" class="form-control pe-form-input" rows="10" id="UserAddress"></textarea>
                      </div>
                  </div>

              </div>

              <div class="col-md-12  text-right mt-4 p0">
                <button type="submit" id="estimateInsert" class="btn btn-primary">Create</button>
              </div>

            </form>
            
          </div>
        </div>

    </div>

  </div>
</div>

<?php
  get_footer();
?>
