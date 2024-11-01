<?php 
// Update counter Start
add_action('wp_head', 'spcd_update_count');
function spcd_update_count()
{
	
		global $post;
		$post_id = $post->ID;
		if(!empty($post_id))
		{
			$spcd_post_type = json_decode(get_option('spcd_post_type'));
			$html = '';
			if(in_array($post->post_type,$spcd_post_type) && is_singular())
			{
				$spcd_count = get_post_meta($post_id, 'spcd_count',true );

				if(!empty( $spcd_count) && ($spcd_count != ''))
				{
					$spcd_count = $spcd_count+1;
				}else{
					$spcd_count = 1;
				}
				update_post_meta($post_id, 'spcd_count',$spcd_count);
			}
		}
}
// Update counter End

// Count Display Start
function spcd_display() {
	global $post;
	$post_id = $post->ID;
	
	$spcd_count = '';
	if(!empty($post_id))
	{
	$spcd_count = get_post_meta($post_id, 'spcd_count',true );
	}
	if(!empty( $spcd_count) && ($spcd_count != ''))
	{
		$spcd_post_type = json_decode(get_option('spcd_post_type'));
		$html = '';
		if(in_array($post->post_type,$spcd_post_type) && is_singular())
		{
		$html .= '<div class="cls_'.$post->post_type.' spcd_count_dis">';
		
		$count_code = '<span>';
		$count_code .= $spcd_count;
		$count_code .= '</span>';
		
		
		$spcd_count_text = get_option('spcd_count_text');
		$count_code = str_replace('[count_text]',$count_code,$spcd_count_text);
		$html .= $count_code;
		$html .= '</div>';
		}
		return $html;
	}
}
add_shortcode( 'spcd_display', 'spcd_display' );
// Count Display End

// setting menu 
add_action('admin_menu', 'spcd_register_submenu_page');
function spcd_register_submenu_page() {
    
	//add_submenu_page('edit.php', 'MPT Order ' . $i, 'MPT Order ' . $i, 'manage_options', 'mpto_list_post' . '-' . $i, 'mpto_list');
                      
    add_options_page('SPCD Options', 'SPCD Options', 'manage_options', 'spcd-options', 'spcd_plugin_options');
}

// Plugin Options
function spcd_plugin_options()
{		
	$spcd_frontend_css = get_option('spcd_frontend_css');
	$spcd_count_text = get_option('spcd_count_text');
	$spcd_can_you_dvc = get_option('spcd_can_you_dvc');
	$spcd_position_pvd = get_option('spcd_position_pvd');
	
	$spcd_post_type = json_decode(get_option('spcd_post_type'));
	if($spcd_post_type == '')
	{
	$spcd_post_type = array();
	}
	?>
	<div id="cpto" class="wrap"> 
        <div id="icon-settings" class="icon32"></div>
        <h2><?php _e('General Settings', 'simple-post-counter-display') ?></h2>
        <form id="form_data" name="form" method="post">   
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row" ><label><?php _e('CSS', 'simple-post-counter-display') ?></label></th>
                        <td scope="row" ><textarea name="spcd_frontend_css" id="spcd_frontend_css"> <?php echo $spcd_frontend_css;?> </textarea></td>
                    </tr>
					<tr valign="top">
                        <th scope="row" ><label><?php _e('Display Count Text <br> Code : count_text', 'simple-post-counter-display') ?></label></th>
                        <td scope="row" ><textarea name="spcd_count_text" id="spcd_count_text"> <?php echo $spcd_count_text;?> </textarea></td>
                    </tr>
					<tr valign="top">
                        <th scope="row" ><label><?php _e('Can you display view count?', 'simple-post-counter-display') ?></label></th>
                        <td scope="row" class="can_you_dvc">
						  <input type="radio" id="yes" name="spcd_can_you_dvc" <?php if($spcd_can_you_dvc == 'yes'){echo 'checked';}?> value="yes">
						  <label for="yes">Yes</label> 
						  <input type="radio" id="no" name="spcd_can_you_dvc" <?php if($spcd_can_you_dvc == 'no'){echo 'checked';}?> value="no">
						  <label for="no">No</label><br>
						</td>
                    </tr>
					<tr valign="top" class="position_show_hide" <?php if($spcd_can_you_dvc == 'no'){echo 'style="display: none;"';}?>>
                        <th scope="row" ><label><?php _e('Post views display position', 'simple-post-counter-display') ?></label></th>
                        <td scope="row" class="position_pvd">
						  <input type="radio" id="before_content" name="spcd_position_pvd" <?php if($spcd_position_pvd == 'before_content'){echo 'checked';}?> value="before_content">
						  <label for="before_content">Before Content</label> 
						  <input type="radio" id="after_content" name="spcd_position_pvd" <?php if($spcd_position_pvd == 'after_content'){echo 'checked';}?> value="after_content">
						  <label for="after_content">After Content</label><br>
						</td>
                    </tr>
					<tr valign="top" class="position_show_hide" <?php if($spcd_can_you_dvc == 'no'){echo 'style="display: none;"';}?>>
                        <th scope="row" ><label><?php _e('Select post type', 'simple-post-counter-display') ?></label></th>
                        <td scope="row" class="">
						    <select id="spcd_post_type" name="spcd_post_type[]" multiple>
							<?php
								$post_types = get_post_types();
								foreach (@$post_types as $post_type_name) {
									//ignore list
									$ignore_post_types = array(
										'reply',
										'topic',
										'report',
										'status',
										'shop_order',
										'shop_coupon',
										'shop_webhook',
										'attachment',
										'popup_theme',
										'acf'
									);

									if (in_array($post_type_name, $ignore_post_types))
										continue;

									$post_type_data = get_post_type_object($post_type_name);
									if ($post_type_data->show_ui === FALSE)
										continue;
											?>
											  <option <?php if(in_array($post_type_name,$spcd_post_type)){echo 'selected="selected"';}?> value="<?php echo $post_type_name; ?>"><?php echo $post_type_name ?></option>              
										<?php } ?>
							  
							</select>
						</td>
                    </tr>
				</tbody>
            </table>
			
            <p class="submit">
                <button onclick="fn_option_save();" class="button button-primary button-large" type="button" name="Save-Settings"><?php 
                            _e('Save Settings', 'simple-post-counter-display') ?></button>
            </p>
			<?php wp_nonce_field('spcd_form_submit','spcd_form_nonce'); ?>
            <input type="hidden" name="form_submit" value="true" />
            <input type="hidden" name="action" value="spcd_save_option"/>

        </form>

        <br />
        <script type="text/javascript">
            function fn_option_save() {
                var form_data = jQuery('#form_data').serialize();
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: form_data,
                    success: function (data) {
                        window.location.reload(true);
                    }
                    //window.location.reload();
                });
                return false;
            }
			jQuery('input[type=radio][name=spcd_can_you_dvc]').change(function() {
				if (this.value == 'yes') {
					jQuery('.position_show_hide').show();
				}
				else {
					jQuery('.position_show_hide').hide();
				}
			});
        </script>
    </div>
	<?php 
}

/*  Message store in session Start*/
add_action('wp_ajax_spcd_save_option', 'spcd_save_option');
function spcd_save_option() {
    session_start();
	
	if (isset($_POST['form_submit']) &&  wp_create_nonce($_POST['spcd_form_nonce'],'spcd_form_submit')) {
        
		
		$spcd_count_text = isset($_POST['spcd_count_text']) ? sanitize_text_field($_POST['spcd_count_text']) : '';
        update_option('spcd_count_text', $spcd_count_text);
		
		$spcd_can_you_dvc = isset($_POST['spcd_can_you_dvc']) ? sanitize_text_field($_POST['spcd_can_you_dvc']) : '';
        update_option('spcd_can_you_dvc', $spcd_can_you_dvc);
		
		$spcd_position_pvd = isset($_POST['spcd_position_pvd']) ? sanitize_text_field($_POST['spcd_position_pvd']) : '';
        update_option('spcd_position_pvd', $spcd_position_pvd);
		
		$spcd_post_type = isset($_POST['spcd_post_type']) ? sanitize_text_field(json_encode($_POST['spcd_post_type'])) : '';
        update_option('spcd_post_type', $spcd_post_type);
		
		
        $_SESSION['notices'] = array('type' => 'success', 'msg' => 'Setting saved successfully.');
	} else {
        $_SESSION['notices'] = array('type' => 'error', 'msg' => 'Failed to saved setting.');
    }
	
}
/*  Message store in session End*/

// Frontend css Start
function spcd_frontheader_css() {
    ?>
	<style type="text/css">
	<?php echo get_option('spcd_frontend_css');?>
	</style>
	<?php 
}
add_action('wp_head', 'spcd_frontheader_css');
// Frontend css End

// add admin notice success Start
function spcd_admin_notice__success() {
if (!isset($_SESSION)) {
        @session_start();
    }
	
    if (isset($_SESSION['notices']) && !empty($_SESSION['notices']) && ($_SESSION['notices'] != '')) {
        if ($_SESSION['notices']['type'] == 'success') {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php _e($_SESSION['notices']['msg'], 'sample-text-domain'); ?></p>
            </div>
            <?php
            $_SESSION['notices']['type'] = '';
        }
    }
}
add_action('admin_notices', 'spcd_admin_notice__success');
// add admin notice success End

// add admin error notice Start
function spcd_my_error_notice() {
    if (!isset($_SESSION)) {
        @session_start();
    }
    if (isset($_SESSION['notices']) && !empty($_SESSION['notices']) && ($_SESSION['notices'] != '')) {
        if ($_SESSION['notices']['type'] == 'error') {
            ?>
            <div class="error notice">
                <p><?php _e($_SESSION['notices']['msg'], 'my_plugin_textdomain'); ?></p>
            </div>
            <?php
            $_SESSION['notices']['type'] = '';
        }
    }
}
add_action('admin_notices', 'spcd_my_error_notice');
// add admin error notice End

// Add default value in option start
function spcd_add_option_default_value()
{
	$spcd_frontend_css = get_option('spcd_frontend_css');
	if($spcd_frontend_css == '')
	{
		update_option('spcd_frontend_css', '.spcd_count_dis{text-align: center;padding: 5px;} .spcd_count_dis span { background-color: #ea906b; padding: 10px; border-radius: 10%}');
	}
	
	$spcd_count_text = get_option('spcd_count_text');
	if($spcd_count_text == '')
	{
		update_option('spcd_count_text', 'View count [count_text]');
	}
}
add_action( 'activated_plugin', 'spcd_add_option_default_value' );
// Add default value in option end



// Register and load the widget
function spcd_load_widget() {
    register_widget( 'spcd_widget' );
}
add_action( 'widgets_init', 'spcd_load_widget' );
 
// Creating the widget 
class spcd_widget extends WP_Widget {
 
function __construct() {
parent::__construct(
 
// Base ID of your widget
'spcd_widget', 
 
// Widget name will appear in UI
__('Simple Post Count Display Widget', 'spcd_widget_domain'), 
 
// Widget description
array( 'description' => __( 'Siomle post view count', 'spcd_widget_domain' ), ) 
);
}
 
// Creating widget front-end
 
public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$description = apply_filters( 'widget_title', $instance['description'] );
	 
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];
	 
	// This is where you run the code and display the output
	echo __( $description, 'spcd_widget_domain' );
	echo do_shortcode('[spcd_display]');
	echo $args['after_widget'];
}
         
// Widget Backend start
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
	$description = $instance[ 'description' ];
}
else {
	$title = __( 'New title', 'spcd_widget_domain' );
	$description = __( 'New description', 'spcd_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>" />
</p>
<?php 
}
// Widget Backend end
     
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Before and After content display start
function spcd_output_shortcode_position( $content ) {
	$spcd_can_you_dvc = get_option('spcd_can_you_dvc');
	$spcd_position_pvd = get_option('spcd_position_pvd');
	
        $output_shortcode = do_shortcode( '[spcd_display]' );
		if($spcd_can_you_dvc == 'yes')
		{
			if($spcd_position_pvd == 'before_content')
			{
				$output_shortcode .= $content;
			}else{
				$output_shortcode = $content.$output_shortcode;
			}
			return $output_shortcode;
		}else{
		return $content;
		}
}
add_filter( 'the_content', 'spcd_output_shortcode_position' );
// Before and After content display end
?>