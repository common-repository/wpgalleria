<?php
/* 
    Plugin Name: Wordpress Galleria Plugin 
    Description: Simple implementation of Galleria 1.9 into WordPress (<a href="http://galleria.io">Galleria.io</a>) 
    Author: Kenneth Rapp
    Version: 1.0.1 
*/  
class Galleria{

    private $Settings = array();

    function __set($key, $value){
        if(!array_key_exists($key, $this->Settings)){
            $this->Settings[$key] = $value;
        }
    }

    function __get($key){
        if(array_key_exists($key, $this->Settings)){
            return $this->Settings[$key];
        }
        return null;
    }

    function __construct(){
        $this->plugin_name = plugin_basename(__FILE__);
        $this->whitelist = array(
            'display' => array ('thumbnail', 'medium', 'large' ,'full') 
        );
    }

    function register_plugin_styles(){
        wp_register_script('js_galleria', plugins_url('js/galleria/galleria-1.2.9.min.js', __FILE__ ), array('jquery'));
        wp_register_script('js_galleria_main', plugins_url('js/main.js', __FILE__), array('js_galleria'));
        wp_register_script('js_galleria_theme', plugins_url('js/galleria/themes/classic/galleria.classic.min.js', __FILE__), array('js_galleria_main'));
        wp_register_style('css_galleria_theme', plugins_url('js/galleria/themes/classic/galleria.classic.css', __FILE__ ));
        
        wp_enqueue_script('js_galleria');
        wp_enqueue_script('js_galleria_theme');
        wp_enqueue_script('js_galleria_main');
        wp_enqueue_style('css_galleria_theme');
        
        add_shortcode('wpgalleria', array($this, 'Display'));
        add_shortcode('wpgalleria-index', array($this, 'Index'));
    }

    // [wpgalleria-index title="title of the page"]
    function Index($atts){

        // extract() is of the devil.
        $shortcode_index_atts = shortcode_atts(array(
            'index'       => 0,
            'page-id'     => 0,
            'title'       => 'gallery',
            'caption'     => false
        ), $atts, 'wpgalleria-index');

        // attempt to get either the page id or title
        if(ctype_digit($shortcode_index_atts['page-id'])){ 
            $post = get_post($shortcode_index_atts['page-id']);
        }
        else if (ctype_alnum($shortcode_index_atts['title'])){
            $post = get_page_by_title( $shortcode_index_atts['title']);
        }

        if(is_object($post) && $images = get_children( array(
            'post_parent'   => $post->ID,
            'post_type'     => 'attachment',
            'post_mime_type'=> 'image' 
        ))){
            
            $images = array_values($images);
            $count  = count($images);
            $index = $shortcode_index_atts['index'];
            
            // get numeric index
            if(ctype_digit($index) && isset($images[$index])){
                $image = $images[$index];
                
            }

            // random
            else if(strtolower(trim($index)) === 'random'){
                shuffle($images);
                $image = array_shift($images);
                
            }
            
            // match the title
            else if(isset($index)){
                foreach($images as $image){
                    if($image->post_title === $index){
                        break(1);
                    }
                }
            }
            
            // just get the one on top.
            else{
                $image = array_shift($images);
            }

            ob_start();
            ?>
            <span class="wp-galleria-thumbnail">     
                <a href="<?php echo esc_attr($post->guid); ?>">
                    <img width="250" src="<?php echo esc_attr($image->guid); ?>">
                </a>
                <?php if(strtolower(trim($shortcode_index_atts['caption'])) === "true"){
                    ?><span class="caption"><br><?php
                    echo esc_attr($image->post_excerpt);
                    ?></span><?php
                }?>
                <br>
                <a href="<?php echo esc_attr($post->guid); ?>">
                <?php echo esc_attr($post->post_title.' - '.((int)$count).' images'); ?></a>            
            </span>
            <?php
            $the_content = ob_get_contents();
            ob_end_clean();
            return $the_content;
        }

    }

    /* display a gallery of photos attached to the current page */
    function Display(){
        global $post;
        $args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'posts_per_page' => -1, 
            'post_status'    => 'published', 
            'post_parent'    => $post->ID
        );
        ob_start();
        ?>

        <div id="galleria" style="height:450px"><?php
        
        $loop = new WP_Query($args);
        if($loop->have_posts()){ 
            while($loop->have_posts()){
                $loop->the_post();
                if($the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full')){ 
                ?><img title = "<?php echo esc_attr(get_the_title()); ?>" src = "<?php echo esc_attr($the_url[0]); ?>" data-thumb = "<?php echo esc_attr($the_url[0]); ?>" data-title = "<?php echo esc_attr(get_the_title()); ?>" alt = ""><?php 
                }
            }
        }
        wp_reset_postdata();
        $content = ob_get_contents();
       
        ?></div><?php
        ob_end_clean();
        return $content;
    }

}

// don't show the plugin if they're either logged in or on a login page.
// otherwise galleria throws up this massively ugly error box.
if(!(is_admin() || in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php') ))){
    $WPGalleria = new Galleria();
    add_action( 'wp_enqueue_scripts', array( &$WPGalleria, 'register_plugin_styles' ) );
}