<?php

    add_shortcode('estimateList', 'frontend_estimate_shortcode');
    /**
     * Shortcode to display a CMB2 form for a post ID.
     * @param  array  $atts Shortcode attributes
     * @return string       Form HTML markup
     */
    function frontend_estimate_shortcode($atts = array() , $content = null){
        $shortAtts = shortcode_atts([
            'limit' => 5,
        ], $atts);

    $estimateList = WC_es_Public::get_all_estimate_for_shortCode($shortAtts['limit']);
?> 

    <div class="card home-card">
        <h6 class="estimate-title">Estimate List</h6>
        <div class="table-responsive">
            <table class="table table-hover">
                    <thead>
                        <tr> 
                            <th scope="col">Estimate ID</th>
                            <th scope="col">Estimate Name</th>
                            <th scope="col">End User Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if (!empty($estimateList)) {  
                        foreach ($estimateList as $key => $value) { ?>    
                            <tr> 
                                <td>#NS00<?php echo $value->id; ?></td>
                                <td><?php echo ese_attr($value->estimate_name); ?></td>
                                <td><?php echo ese_attr($value->user_name); ?></td>
                                <td> <a href="<?php echo home_url(); ?>/estimate_edit?estimate-id=<?php echo ese_attr($value->id); ?>">Edit</a> | <a class="estimateDelete" data-nonce="<?php echo wp_create_nonce( 'estimateDelete' ); ?>" data-id="<?php echo ese_attr($value->id); ?>" href="#">Delete</a> </td>
                            </tr>
                    <?php  }   
                        }else{
                            echo 'No product';
                        } ?> 
            
                </tbody>
            </table>
        </div>
    </div>
 
<?php
    }
?>
