<?php
    use Dompdf\Dompdf;

    /**
     * The public-facing functionality of the plugin.
     *
     * @link       http://example.com
     * @since      1.0.0
     *
     * @package    product_innovs_wc_es
     * @subpackage product_innovs_wc_es/public
     */

    /**
     * The public-facing functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the public-facing stylesheet and JavaScript.
     *
     * @package    product_innovs_wc_es
     * @subpackage product_innovs_wc_es/public
     * @author     Your Name <email@example.com>
     */
    class WC_es_Public{

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $product_innovs_wc_es The ID of this plugin.
         */
        private $product_innovs_wc_es;

        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $version The current version of this plugin.
         */
        private $version;

        /**
         * Initialize the class and set its properties.
         *
         * @param string $product_innovs_wc_es The name of the plugin.
         * @param string $version The version of this plugin.
         * @since    1.0.0
         */
        public function __construct($product_innovs_wc_es, $version){

            $this->product_innovs_wc_es = $product_innovs_wc_es;
            $this->version = $version;
        }

        /**
         * Register the stylesheets for the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function enqueue_styles(){

            /**
             * This function is provided for demonstration purposes only.
             *
             * An instance of this class should be passed to the run() function
             * defined in product_innovs_wc_es_Loader as all of the hooks are defined
             * in that particular class.
             *
             * The product_innovs_wc_es_Loader will then create the relationship
             * between the defined hooks and the functions defined in this
             * class.
             */
            wp_enqueue_style($this->product_innovs_wc_es . '_bootstrap.min.js.map', plugin_dir_url(__FILE__) . 'css/bootstrap.min.js.map', array(), $this->version, '');
            wp_enqueue_style($this->product_innovs_wc_es . '_product-estimate-bootstrap', plugin_dir_url(__FILE__) . 'css/product-estimate-bootstrap.min.css', array(), $this->version, '');
            wp_enqueue_style($this->product_innovs_wc_es . '_product-estimate-font-awosome', plugin_dir_url(__FILE__) . 'css/product-estimate-font-awosome.css', array(), $this->version, '');
            wp_enqueue_style($this->product_innovs_wc_es . '_product-innovs-estimate-public', plugin_dir_url(__FILE__) . 'css/product-estimate-public.css', array(), $this->version, 'all');
            wp_enqueue_style($this->product_innovs_wc_es . '_product-estimate-print', plugin_dir_url(__FILE__) . 'css/product-estimate-print.css', array(), $this->version, 'all');
            wp_enqueue_style($this->product_innovs_wc_es . '_print-styles', plugin_dir_url(__FILE__) . 'css/product-estimate-print.css', array(), null, 'print');

        }

        /**
         * Register the JavaScript for the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts(){

            /**
             * This function is provided for demonstration purposes only.
             *
             * An instance of this class should be passed to the run() function
             * defined in product_innovs_wc_es_Loader as all of the hooks are defined
             * in that particular class.
             *
             * The product_innovs_wc_es_Loader will then create the relationship
             * between the defined hooks and the functions defined in this
             * class.
             */

            wp_enqueue_script('jquery');
            wp_enqueue_script($this->product_innovs_wc_es . '_estimate-proper-js', plugin_dir_url(__FILE__) . 'js/estimate-proper-js.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->product_innovs_wc_es . '_estimate-bootstrap.min', plugin_dir_url(__FILE__) . 'js/estimate-bootstrap.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->product_innovs_wc_es . '_public', plugin_dir_url(__FILE__) . 'js/estimate-public.js', array('jquery'), $this->version, false);
            wp_localize_script($this->product_innovs_wc_es . '_public', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        }

        public function baseUrl(){
            ?>
            <script>
                var base_url = '<?php echo home_url(); ?>';
            </script>
            <?php
        }

        public function pluginUrl(){
            ?>
            <script>
                var plugin_url = '<?php echo plugin_dir_url('') . '/' . $this->product_innovs_wc_es; ?>';
            </script>
            <?php
        }

        public function get_product_list(){
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 10,
            );

            $loop = new WP_Query($args);

            while ($loop->have_posts()) : $loop->the_post();
                global $product;
                if (isset($_GET['estimate-id'])) {
                    echo '<a data-id="' . get_the_ID() . '" data-estimateId = "' . $_GET['estimate-id'] . '" class="add_list cart-add-btn list-group-item list-group-item-action bg-light" href="#">' . get_the_title() . ' <span class="btn-show-hover">Add</span></a>';
                } else {
                    echo '<a   class="cart-add-btn list-group-item list-group-item-action bg-light" href="#">' . get_the_title() . '</a>';
                }

            endwhile;

            wp_reset_query();
        }


        public function get_sensore_list(){

            $category = get_option('innovs_wc_es_category2');

            $taxonomy = 'product_cat';
            $orderby = 'name';
            $show_count = 0; // 1 for yes, 0 for no
            $pad_counts = 0; // 1 for yes, 0 for no
            $hierarchical = 1; // 1 for yes, 0 for no
            $title = '';
            $empty = 0;

            $cat_id = get_term_by('slug', $category, 'product_cat');

            $args = array(
                'taxonomy' => $taxonomy,
                'orderby' => $orderby,
                'parent' => $cat_id->term_id,
                'show_count' => $show_count,
                'pad_counts' => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li' => $title,
                'hide_empty' => $empty
            ); 
            
            ?>

            <div class="list-group list-group-flush">
                <div id="accordion">
                    <?php
                    $categories = get_categories($args);
                    foreach ($categories as $term) {

                        ?>

                        <div class="card">
                            <div class="card-header">
                                <a class="card-link" data-toggle="collapse"
                                href="#collapseOne<?php echo esc_attr($term->term_id); ?>">
                                    <?php echo esc_attr($term->name); ?>
                                    <img class="arrow_icon"
                                        src="<?php echo get_template_directory_uri() . '/img/arrow_down.svg' ?>" alt="">
                                </a>
                            </div>
                            <div id="collapseOne<?php echo esc_attr($term->term_id); ?>" class="collapse"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <?php
                                    $args = array(
                                        'post_type' => 'product',
                                        'posts_per_page' => 10,
                                        'product_cat' => $term->slug
                                    );

                                    $loop = new WP_Query($args);

                                    while ($loop->have_posts()) : $loop->the_post();
                                        global $product;


                                        if (isset($_GET['estimate-id'])) {
                                            echo '<a data-id="' . get_the_ID() . '" data-innovs_wc_esId = "' . $_GET['estimate-id'] . '" class="add_list cart-add-btn list-group-item list-group-item-action bg-light" href="#">' . get_the_title() . ' <span class="btn-show-hover">Add</span></a>';
                                        } else {
                                            echo '<a data-id="' . get_the_ID() . '"  class="cart-add-btn list-group-item list-group-item-action bg-light" href="#">' . get_the_title() . '</a>';
                                        }

                                    endwhile;

                                    wp_reset_query();
                                    ?>
                                </div>
                            </div>
                        </div>

                        <?php

                    }
                    ?>
                </div>
            </div>
            <?php

        }

        public static function get_all_innovs_wc_es_for_shortCode($limit){
            global $wpdb;
            $current_user = get_current_user_id();
            $tablename = $wpdb->prefix . "innovs_wc_es";
            $ls_innovs_wc_es = $wpdb->get_results("SELECT * FROM $tablename WHERE  user_id = '$current_user' LIMIT $limit");

            return $ls_innovs_wc_es;
        }

        public static function get_all_innovs_wc_es(){
            global $wpdb;
            $current_user = get_current_user_id();
            $tablename = $wpdb->prefix . "innovs_wc_es";
            $ls_innovs_wc_es = $wpdb->get_results("SELECT * FROM $tablename WHERE  user_id = '$current_user'");

            return $ls_innovs_wc_es;
        }

        public static function get_details_innovs_wc_es($innovs_wc_esId){
            global $wpdb;
            $current_user = get_current_user_id();
            $tablename = $wpdb->prefix . "innovs_wc_es";
            $ls_innovs_wc_es = $wpdb->get_results("SELECT * FROM $tablename WHERE  user_id = '$current_user' AND id= '$innovs_wc_esId'");

            return $ls_innovs_wc_es;
        }

        public static function allGetProducts($innovs_wc_esId){
            global $wpdb;
            $id = isset($innovs_wc_esId) ? $innovs_wc_esId : 0;
            $tablename = $wpdb->prefix . "innovs_wc_es_products";
            $sql = "Select * from $tablename Where estimate_id = '$id'  Group By product_id Order by id ASC";
            $values = $wpdb->get_results($sql, ARRAY_A);
            return $values;
        }

        public static function getTotalQty($productId, $innovs_wc_esId){
            global $wpdb;
            $tablename = $wpdb->prefix . "innovs_wc_es_products";
            $sql = "SELECT product_id,SUM(qty) as totalQty FROM $tablename Where estimate_id = '$innovs_wc_esId' and  product_id = $productId GROUP BY product_id;";
            $values = $wpdb->get_results($sql, ARRAY_A);
            return $values;
        }

        public function wc_es_redirect_users_by_role(){

            $current_user = wp_get_current_user();
            $role_name = $current_user->roles[0];
            $return_url = esc_url(home_url('/my-account/'));
            if ('innovs_wc_es-admin' === $role_name) {
                wp_redirect($return_url);
            }

        }

        public function wc_es_user_nav_visibility(){

            if (is_user_logged_in()) {
                $output = "<style> .nav-login { display: none; } </style>";
            } else {
                $output = "<style> .nav-account { display: none; } </style>";
            }

            echo $output;
        }

        function wc_es_csv(){

            if (isset($_GET['innovs_wc_es-id']) && isset($_GET['csv'])) {
                // Create new PHPExcel object
                $objPHPExcel = new PHPExcel();

                // Set document properties
                $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                    ->setLastModifiedBy("Maarten Balliauw")
                    ->setTitle("Office 2007 XLSX Test Document")
                    ->setSubject("Office 2007 XLSX Test Document")
                    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Test result file");


                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Hello')
                    ->setCellValue('B2', 'world!')
                    ->setCellValue('C1', 'Hello')
                    ->setCellValue('D2', 'world!');

                // Miscellaneous glyphs, UTF-8
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A4', 'Miscellaneous glyphs')
                    ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

                // Rename worksheet
                $objPHPExcel->getActiveSheet()->setTitle('Simple');


                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $objPHPExcel->setActiveSheetIndex(0);


                // Redirect output to a client’s web browser (OpenDocument)
                header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
                header('Content-Disposition: attachment;filename="01simple.ods"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
                $objWriter->save('php://output');
                exit;

            }

        }

        public static function get_all_estimate_for_shortCode($limit = 8){

        }
    }

    function es_css(){
        ?>

        <style>
            .product .product-price:before, .product .product-line-price:before, .totals-value:before {
                content: '<?php echo esc_attr(get_option('set_currency'));?>' !important;
            }
        </style>

        <?php
    }

    add_action('wp_head', 'es_css');
?>