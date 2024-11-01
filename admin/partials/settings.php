
<h1>Estimate Settings</h1>
<div class="wrap">
    <h1>Settings</h1>
    <form method="post" action="options.php">
		<?php settings_fields( 'get_estimate_settings_group' ); ?>
		<?php do_settings_sections( 'get_estimate_settings_group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Primary Color :</th>
                <td>
                    <div class="chose-color " style="width:130px;">
                        <input id="barColor" name="primary_color"
                               value="<?php echo esc_attr( get_option( 'primary_color' ) ); ?>"/>
                    </div>
                </td>
                <th scope="row">Button Color :</th>
                <td>
                    <div class="chose-color " style="width:130px;">
                        <input id="button_color" name="button_color"
                               value="<?php echo esc_attr( get_option( 'button_color' ) ); ?>"/>
                    </div>
                </td> 
            </tr>
            <tr valign="top">
            <th scope="row">Secondary Color :</th>
                <td>
                    <div class="chose-color " style="width:130px;">
                        <input id="font_color" name="seccondary_color"
                               value="<?php echo esc_attr( get_option( 'seccondary_color' ) ); ?>"/>
                    </div>
                </td>
                <th scope="row">Hover Color :</th>
                <td>
                    <div class="chose-color" style="width:130px;">
                        <input id="hover_color" name="hover_color"
                               value="<?php echo esc_attr( get_option( 'hover_color' ) ); ?>"/>
                    </div>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Company Name</th>
                <td><input type="text" name="company_name"
                           value="<?php echo esc_attr( get_option( 'company_name' ) ); ?>"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Estimate Expaire </th>
                <td><input type="text" name="delete_time"
                           value="<?php echo esc_attr( get_option( 'delete_time' ) ); ?>"/> Days.
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Estimate Products Limit</th>
                <td><input type="text" name="estimate_limit"
                           value="<?php echo esc_attr( get_option( 'estimate_limit' ) ); ?>"/>  
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Estimate Export Footer Text</th>
                <td><textarea cols="5"  rows="5" class="form-control" name="estimate_export_footer"
                           value="<?php echo esc_attr( get_option( 'estimate_export_footer' ) ); ?>"><?php echo esc_attr( get_option( 'estimate_export_footer' ) ); ?> </textarea> 
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Estimate Menu Show</th>
                <td><input type="checkbox"
                           name="estimate_menu" <?php echo checked( get_option( 'estimate_menu' ), 1 ); ?>
                           value="1"/></td>
            </tr>

            <tr valign="top">
                <th scope="row">Set Currency</th>
                <td>
                   <input type="text" name="set_currency" value="<?php echo esc_attr( get_option( 'set_currency' ) ); ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Estimate Show Per Page</th>
                <td>
                    <select name="per_page" id="">
                        <option value="10" <?php echo selected( get_option( 'per_page' ), 10 ); ?>>10</option>
                        <option value="25" <?php echo selected( get_option( 'per_page' ), 25 ); ?>>25</option>
                        <option value="50" <?php echo selected( get_option( 'per_page' ), 50 ); ?>>50</option>
                        <option value="100" <?php echo selected( get_option( 'per_page' ), 100 ); ?>>100</option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">All innovs-wc-es Page</th>
                <td>
                    <input type="text" name="estimate_list" readonly value="<?php echo isset($show_notifications_post->post_title) ?  $show_notifications_post->post_title  : 'estimate_list'; ?>"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Create New innovs-wc-es Page</th>
                <td><input type="text" name="create_estimate" readonly value="<?php echo isset($view_notifications_post->post_title) ?  $view_notifications_post->post_title  : 'estimate'; ?>"/></td>
            </tr> 
        </table>
		<?php submit_button(); ?>
    </form>
    <div class="others">
        <h2>Short Documentation</h2>
        <h4>Create new page and add those ShortCode: </h4>
        <p><b>All innovs-wc-es ShortCode :</b> [estimateList] </p>
    </div>
</div>