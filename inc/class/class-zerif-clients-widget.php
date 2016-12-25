<?php
/****************************/

/****** clients widget ******/

/***************************/


class zerif_clients_widget extends WP_Widget {

	private $form_tools;

	public function __construct()
	{
		$widget_ops = array( 'classname' => 'zerif_clients', 'customize_selective_refresh' => true );

		parent::__construct( 'zerif_clients-widget', 'Zerif - Clients widget', $widget_ops );
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

		if( !empty($instance['image_uri']) && !empty($instance['link']) ):
			if( isset($instance['new_tab']) && ($instance['new_tab'] == 'on') ):
				?>
				<a href="<?php echo apply_filters('widget_title', $instance['link'] ); ?>" target="_blank"><img src="<?php echo esc_url($instance['image_uri']); ?>" alt="<?php if( !empty($instance['title']) ): echo esc_html($instance['title']); endif; ?>"></a>
			<?php else: ?>
				<a href="<?php echo apply_filters('widget_title', $instance['link'] ); ?>"><img src="<?php echo esc_url($instance['image_uri']); ?>" alt="<?php if( !empty($instance['title']) ): echo esc_html($instance['title']); endif; ?>"></a>
				<?php
			endif;
		elseif( !empty($instance['image_uri']) && empty($instance['link']) ):
			?>
			<img src="<?php echo esc_url($instance['image_uri']); ?>" alt="<?php if( !empty($instance['title']) ): echo esc_html($instance['title']); endif; ?>"/>
			<?php
		endif;

		echo $after_widget;

	}



	public function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['link'] = strip_tags( $new_instance['link'] );

		$instance['image_uri'] = strip_tags( $new_instance['image_uri'] );

		$instance['new_tab'] = strip_tags( $new_instance['new_tab'] );

		$instance['image_in_customizer'] = strip_tags($new_instance['image_in_customizer']);

		return $instance;

	}



	public function form($instance) {
		$form_tools = $this->form_tools;

		$form_tools->input_text($instance, array(
			'sanitize' => 'wp_kses_post',
			'instance_name' => 'title',
			'label' => __('Alt Title','zerif')
		));

		$form_tools->input_text($instance, array(
			'sanitize' => 'esc_url',
			'instance_name' => 'link',
			'label' => __('Link','zerif')
		));

		$form_tools->input_text($instance, array(
			'type' => 'checkbox',
			'instance_name' => 'new_tab'
		));

		$form_tools->image_control($instance);

	}
}