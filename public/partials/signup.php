<?php
	/*
	Template Name: Login Page
	*/
	//wp_head();

	get_header();
?> 
	<div class="signup-wrapper">
		<?php
		
			$error= '';
			$success = '';

			global $wpdb, $PasswordHash, $current_user, $user_ID;

			if(isset($_POST['task']) && $_POST['task'] == 'register' ) {

				$password1 = $wpdb->esc_sql(trim($_POST['password1']));
				$first_name = $wpdb->esc_sql(trim($_POST['first_name']));
				$last_name = $wpdb->esc_sql(trim($_POST['last_name']));
				$email = $wpdb->esc_sql(trim($_POST['email']));
				$username = $wpdb->esc_sql(trim($_POST['username']));
				$company_name = $wpdb->esc_sql(trim($_POST['company_name']));
				$mobile = $wpdb->esc_sql(trim($_POST['mobile']));

				if( $company_name == "" || $email == "" || $password1 == "" || $username == "" || $first_name == "" || $last_name == "") {
					$error= 'Please don\'t leave the required fields.';
				} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$error= 'Invalid email address.';
				} else if(email_exists($email) ) {
					$error= 'Email already exist.';
				}

				else {

					$user_id = wp_insert_user( array ('first_name' => apply_filters('pre_user_first_name', $first_name), 'last_name' => apply_filters('pre_user_last_name', $last_name), 'user_pass' => apply_filters('pre_user_user_pass', $password1), 'user_login' => apply_filters('pre_user_user_login', $username), 'user_email' => apply_filters('pre_user_user_email', $email), 'role' => 'Estimate-admin' ) );

					if ($user_id){
						add_user_meta( $user_id, 'company_name', $company_name);
						add_user_meta( $user_id, 'mobile', $mobile);
					}

					if( is_wp_error($user_id) ) {
						$error= 'Error on user creation.';
					} else {
						do_action('user_register', $user_id);

						$success = 'You\'re successfully register';
					}
				}
			}
		?>

	<div class="container" style="margin-top: 50px; margin-bottom:50px">
		<div class="row justify-content-center">
			<h3>User Signup</h3>
		</div>
		<div class="row justify-content-center"> 
			<div class="col-md-5 sign-up">
				<div id="message">
					<?php
					if(! empty($err) ) :
						echo '<p class="error">'.$err.'';
					endif;
					?>

					<?php
					if(! empty($success) ) :
						echo '<p class="error">'.$success.'';
					endif;
					?>
				</div>

				<form method="post"> 
					<div class="row">
						<div class="col-md-6">
							<label>Last Name</label>
							<input class="form-control" type="text" value="" name="last_name" id="last_name" />
						</div>
						<div class="col-md-6">
							<label>First Name</label>
							<input class="form-control" type="text" value="" name="first_name" id="first_name" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Company Name</label>
							<input class="form-control" type="text" value="" name="company_name" id="company_name" />
						</div>
						<div class="col-md-12">
							<label>Mobile</label>
							<input class="form-control" type="text" value="" name="mobile" id="mobile" />
						</div>
						<div class="col-md-12">
							<label>Email</label>
							<input class="form-control" type="text" value="" name="email" id="email" />
						</div>
						<div class="col-md-12">
							<label>Username</label>
							<input class="form-control" type="text" value="" name="username" id="username" />
						</div>
						<div class="col-md-12">
							<label>Password</label>
							<input class="form-control" type="password" value="" name="password1" id="password1" />
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="text-left"><p><?php if(isset($sucess) && $sucess != "") { echo $sucess; } ?> <?php if($error!= "") { echo $error; } ?></p></div>
								<button type="submit" name="btnregister" class="btn btn-primary" >Submit</button>
								<input type="hidden" name="task" value="register" />
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