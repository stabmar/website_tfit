<?php
/****************************/

/****** testimonial widget **/

/***************************/


class zerif_testimonial_widget extends WP_Widget {

	private $form_tools;

    public function __construct()
    {
        $widget_ops = array( 'classname' => 'zerif_testim', 'customize_selective_refresh' => true );

        parent::__construct( 'zerif_testim-widget', 'Zerif - Testimonial widget', $widget_ops );
	    $this->form_tools = new Zerif_Widget_Form_Tools($this);
        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
        add_action('admin_enqueue_styles', array($this, 'upload_styles'));
    }

    /**
     * Upload the Javascripts for the media uploader
     */
    public function upload_scripts($hook)
    {
		if( $hook != 'widgets.php' )
            return;
	    wp_enqueue_media();
	    wp_enqueue_script('zerif_widget_media_script', get_template_directory_uri() . '/js/widget-media.js', false, '1.2.1', true);

    }

    /**
     * Add the styles for the upload media box
     */
    public function upload_styles($hook)
    {
		if( $hook != 'widgets.php' )
            return;
        wp_enqueue_style('thickbox');
    }

	public function widget($args, $instance) {

        extract($args);

	    echo $before_widget;

?>

			<!-- MESSAGE OF THE CLIENT -->

			<div class="message">

				<?php if( !empty($instance['text']) ): echo htmlspecialchars_decode(apply_filters('widget_title', $instance['text'] )); endif; ?>

			</div>

			<!-- CLIENT INFORMATION -->

			<div class="client">

				<div class="quote red-text">

					<i class="fa fa-quote-left"></i>

				</div>

				<div class="client-info">

					<a class="client-name" target="_blank" <?php if( !empty($instance['link']) ): echo 'href="'.esc_url($instance['link']).'"'; endif; ?>><?php if( !empty($instance['title']) ): echo apply_filters('widget_title', $instance['title'] ); endif; ?></a>

					<div class="client-company">

						<?php
						if( !empty($instance['details']) ):
							echo apply_filters('widget_title', $instance['details'] );
						endif;
						?>

					</div>

				</div>

				<?php

					echo '<div class="client-image hidden-xs">';

						if( !empty($instance['image_uri']) ):
							if( !empty($instance['title']) ):
								echo '<img src="'.esc_url($instance['image_uri']).'" alt="'.apply_filters('widget_title', $instance['title'] ).'">';
							else:
								echo '<img src="'.esc_url($instance['image_uri']).'" alt="'.__( 'Testimonial','zerif' ).'">';
							endif;

						endif;

					echo '</div>';

				?>

			</div> <!-- / END CLIENT INFORMATION-->

<?php

	    echo $after_widget;

    }



	public function update($new_instance, $old_instance) {

        $instance = $old_instance;

        $instance['text'] = stripslashes(wp_filter_post_kses($new_instance['text']));

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['link'] = strip_tags( $new_instance['link'] );

		$instance['details'] = strip_tags( $new_instance['details'] );

        $instance['image_uri'] = strip_tags( $new_instance['image_uri'] );

	    $instance['image_in_customizer'] = strip_tags($new_instance['image_in_customizer']);

        return $instance;

    }



	public function form($instance) {
	    $form_tools = $this->form_tools;

	    $form_tools->input_text($instance, array(
		    'sanitize' => 'wp_kses_post',
		    'instance_name' => 'title',
		    'label' => __('Author','zerif')
	    ));

	    $form_tools->input_text($instance, array(
		    'sanitize' => 'esc_url',
		    'instance_name' => 'link',
		    'label' => __('Author link','zerif')
	    ));

	    $form_tools->input_text($instance, array(
		    'sanitize' => 'wp_kses_post',
		    'instance_name' => 'details',
		    'label' => __('Author details','zerif')
	    ));

	    $form_tools->input_text($instance, array(
		    'type'  => 'textarea',
		    'instance_name' => 'text',
		    'label' => __('Text','zerif')
	    ));

	    $form_tools->image_control($instance);

    }

}