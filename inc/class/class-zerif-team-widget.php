<?php
/****************************/

/****** team member widget **/

/***************************/

class zerif_team_widget extends WP_Widget {

	private $form_tools;

    public function __construct()
    {
        $widget_ops = array( 'classname' => 'zerif_team', 'customize_selective_refresh' => true );

        parent::__construct( 'zerif_team-widget', 'Zerif - Team member widget', $widget_ops );
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
			<div class="col-lg-3 col-sm-3">

				<div class="team-member">

					<figure class="profile-pic">
						<?php
						if( !empty($instance['name']) ):
							$ourteam_widget_image_alt = apply_filters('widget_title', $instance['name'] );
						else:
							$ourteam_widget_image_alt = __( 'Team member','zerif' );
						endif;
						?>
						<img src="<?php if( !empty($instance['image_uri']) ): echo esc_url($instance['image_uri']); endif; ?>" alt="<?php echo esc_html($ourteam_widget_image_alt); ?>">

					</figure>

					<div class="member-details">

					<?php if( !empty($instance['profile_link']) ): ?>
						<h5 class="dark-text red-border-bottom"><a href="<?php echo apply_filters('widget_title', $instance['profile_link'] ); ?>"><?php if( !empty($instance['name']) ): echo apply_filters('widget_title', $instance['name'] ); endif; ?></a></h5>
					<?php else: ?>
						<h5 class="dark-text red-border-bottom"><?php if( !empty($instance['name']) ): echo apply_filters('widget_title', $instance['name'] ); endif; ?></h5>
					<?php endif; ?>

						<div class="position"><?php if( !empty($instance['position']) ): echo htmlspecialchars_decode(apply_filters('widget_title', $instance['position'] )); endif; ?></div>

					</div>

					<div class="social-icons">

						<ul>
							<?php
								$zerif_team_target = '_self';
								if( !empty($instance['open_new_window']) ):
									$zerif_team_target = '_blank';
								endif;
							?>

							<?php if( !empty($instance['fb_link']) ):
								$zerif_widget_fb_link = $instance['fb_link'];
							?>
								<li><a title="<?php _e( 'Facebook', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_fb_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-facebook"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['tw_link']) ):
								$zerif_widget_tw_link = $instance['tw_link'];
							?>
								<li><a title="<?php _e( 'Twitter', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_tw_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-twitter"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['bh_link']) ):
								$zerif_widget_bh_link = $instance['bh_link'];
							?>
								<li><a title="<?php _e( 'Behance', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_bh_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-behance"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['db_link']) ):
								$zerif_widget_db_link = $instance['db_link'];
							?>
								<li><a title="<?php _e( 'Dribbble', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_db_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-dribbble"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['ln_link']) ):
								$zerif_widget_ln_link = esc_url($instance['ln_link']);
							?>
								<li><a title="<?php _e( 'LinkedIn', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_ln_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-linkedin"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['gp_link']) ):
								$zerif_widget_gp_link = esc_url($instance['gp_link']);
							?>
								<li><a title="<?php _e( 'Google Plus', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_gp_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-google"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['pinterest_link']) ):
								$zerif_widget_pinterest_link = esc_url($instance['pinterest_link']);
							?>
								<li><a title="<?php _e( 'Pinterest', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_pinterest_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-pinterest"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['tumblr_link']) ):
								$zerif_widget_tumblr_link = esc_url($instance['tumblr_link']);
							?>
								<li><a title="<?php _e( 'Tumblr', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_tumblr_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-tumblr"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['reddit_link']) ):
								$zerif_widget_reddit_link = esc_url($instance['reddit_link']);
							?>
								<li><a title="<?php _e( 'Reddit', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_reddit_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-reddit"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['youtube_link']) ):
								$zerif_widget_youtube_link = esc_url($instance['youtube_link']);
							?>
								<li><a title="<?php _e( 'YouTube', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_youtube_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-youtube"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['instagram_link']) ):
								$zerif_widget_instagram_link = esc_url($instance['instagram_link']);
							?>
								<li><a title="<?php _e( 'Instagram', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_instagram_link ); ?>" target="<?php echo esc_html($zerif_team_target); ?>"><i class="fa fa-instagram"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['email_link']) ):
								$zerif_widget_email_link = sanitize_email($instance['email_link']);
							?>
								<li><a title="<?php _e( 'Email', 'zerif' ); ?>" href="mailto:<?php echo apply_filters('widget_title', $zerif_widget_email_link ); ?>"><i class="fa fa-envelope"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['website_link']) ):
								$zerif_widget_website_link = wp_kses_post($instance['website_link']);
							?>
								<li><a title="<?php _e( 'Website', 'zerif' ); ?>" href="<?php echo apply_filters('widget_title', $zerif_widget_website_link ); ?>"><i class="fa fa-globe"></i></a></li>
							<?php endif; ?>

							<?php if( !empty($instance['phone_link']) ): ?>
								<li><a title="<?php _e( 'Phone Number', 'zerif' ); ?>" href="tel:<?php echo esc_attr( $instance['phone_link'] ); ?>"><i class="fa fa-phone"></i></a></li>
							<?php endif; ?>

						</ul>

					</div>

					<?php if( !empty($instance['description']) ):
						$zerif_widget_description = wp_kses_post($instance['description']);
					?>
						<div class="details">
							<?php echo htmlspecialchars_decode(apply_filters('widget_title', $zerif_widget_description )); ?>
						</div>
					<?php endif; ?>

				</div>

			</div>
<?php

		echo $after_widget;

	}



    public function update($new_instance, $old_instance) {

        $instance = $old_instance;

        $instance['name'] = strip_tags( $new_instance['name'] );

        $instance['position'] = stripslashes(wp_filter_post_kses( $new_instance['position'] ));

		$instance['description'] = stripslashes(wp_filter_post_kses( $new_instance['description'] ));

		$instance['fb_link'] = strip_tags( $new_instance['fb_link'] );

		$instance['tw_link'] = strip_tags( $new_instance['tw_link'] );

		$instance['bh_link'] = strip_tags( $new_instance['bh_link'] );

		$instance['db_link'] = strip_tags( $new_instance['db_link'] );

		$instance['ln_link'] = strip_tags( $new_instance['ln_link'] );

		$instance['gp_link'] = strip_tags( $new_instance['gp_link'] );

		$instance['pinterest_link'] = strip_tags( $new_instance['pinterest_link'] );

		$instance['tumblr_link'] = strip_tags( $new_instance['tumblr_link'] );

		$instance['reddit_link'] = strip_tags( $new_instance['reddit_link'] );

		$instance['youtube_link'] = strip_tags( $new_instance['youtube_link'] );

		$instance['instagram_link'] = strip_tags( $new_instance['instagram_link'] );

		$instance['website_link'] = strip_tags( $new_instance['website_link'] );

		$instance['email_link'] = strip_tags( $new_instance['email_link'] );

		$instance['phone_link'] = strip_tags( $new_instance['phone_link'] );

		$instance['image_uri'] = strip_tags( $new_instance['image_uri'] );

		$instance['profile_link'] = strip_tags( $new_instance['profile_link'] );

		$instance['open_new_window'] = strip_tags($new_instance['open_new_window']);

	    $instance['image_in_customizer'] = strip_tags($new_instance['image_in_customizer']);

        return $instance;

    }

    public function form($instance) {
	    $form_tools = $this->form_tools;

	    $form_tools->input_text($instance, array(
		    'sanitize' => 'esc_html',
		    'instance_name' => 'name',
		    'label' => __('Name','zerif')
	    ));

	    $form_tools->input_text($instance, array(
		    'type'  => 'textarea',
		    'instance_name' => 'position',
		    'label' => __('Position','zerif')
	    ));

	    $form_tools->input_text($instance, array(
		    'type'  => 'textarea',
		    'instance_name' => 'description',
		    'label' => __('Description','zerif')
	    ));

	    $links = array(
	    	array( 'instance_name' => 'profile_link', 'label' => __('Profile link','zerif') ),
		    array( 'instance_name' => 'fb_link', 'label' => __('Facebook link','zerif') ),
		    array( 'instance_name' => 'tw_link', 'label' => __('Twitter link','zerif') ),
		    array( 'instance_name' => 'bh_link', 'label' => __('Behance link','zerif') ),
		    array( 'instance_name' => 'db_link', 'label' => __('Dribble link','zerif') ),
		    array( 'instance_name' => 'ln_link', 'label' => __('Linkedin link','zerif') ),
		    array( 'instance_name' => 'gp_link', 'label' => __('Google+ link','zerif') ),
		    array( 'instance_name' => 'pinterest_link', 'label' => __('Pinterest link','zerif') ),
		    array( 'instance_name' => 'tumblr_link', 'label' => __('Tumblr link','zerif') ),
		    array( 'instance_name' => 'reddit_link', 'label' => __('Reddit link','zerif') ),
		    array( 'instance_name' => 'youtube_link', 'label' => __('YouTube link','zerif') ),
		    array( 'instance_name' => 'instagram_link', 'label' => __('Instagram link','zerif') ),
		    array( 'instance_name' => 'email_link', 'label' => __('Email link','zerif') ),
		    array( 'instance_name' => 'website_link', 'label' => __('Website link','zerif') ),
		    array( 'instance_name' => 'phone_link', 'label' => __('Phone number','zerif') )
	    );

	    foreach( $links as $link_input){
		    $form_tools->input_text($instance, array(
			    'sanitize' => ($link_input['instance_name'] === 'phone_link' ? 'esc_attr' : 'esc_url'),
			    'instance_name' => $link_input['instance_name'],
			    'label' => $link_input['label']
		    ));
	    }

	    $form_tools->input_text($instance, array(
		    'type' => 'checkbox',
		    'instance_name' => 'open_new_window'
	    ));

	    $form_tools->image_control($instance);
    }

}