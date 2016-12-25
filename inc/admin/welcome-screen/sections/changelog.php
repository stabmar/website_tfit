<?php
/**
 * Changelog
 */

$zerif_pro = wp_get_theme( 'zerif-pro' );

?>
<div class="zerif-pro-tab-pane" id="changelog">

	<div class="zerif-tab-pane-center">
	
		<h1>Zerif PRO <?php if( !empty($zerif_pro['Version']) ): ?> <sup id="zerif-pro-theme-version"><?php echo esc_attr( $zerif_pro['Version'] ); ?> </sup><?php endif; ?></h1>

	</div>

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$zerif_pro_changelog = $wp_filesystem->get_contents( get_template_directory().'/CHANGELOG.md' );
	$zerif_pro_changelog_lines = explode(PHP_EOL, $zerif_pro_changelog);
	foreach($zerif_pro_changelog_lines as $zerif_pro_changelog_line){
		if(substr( $zerif_pro_changelog_line, 0, 3 ) === "###"){
			echo '<hr /><h1>'.substr($zerif_pro_changelog_line,3).'</h1>';
		} else {
			echo $zerif_pro_changelog_line.'<br/>';
		}
	}

	?>
	
</div>
