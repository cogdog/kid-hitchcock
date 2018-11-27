<?php
/* Functions and stuff for kid that is the child of Hamilton
   
   mods by and blame go to http://cog.dog
*/


/* ------  enqueue custom style sheet ------------------------------------------------  */

add_action( 'wp_enqueue_scripts', 'kidhitchcock_enqueue_style' );

function  kidhitchcock_enqueue_style() {

    $parent_style = 'hitchcock-style';  // define parent
    
    // enqueue parent first
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    
    // now enqueue the child 
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );    
}



/* ------ Customizer settings for footer editing -------------------------------------  */

add_action( 'customize_register', 'kidhitchcock_register_theme_customizer' );

// register custom customizer stuff

function kidhitchcock_register_theme_customizer( $wp_customize ) {

	// Setting for custom footer
	
	// Add section in customizer for this stuff
	$wp_customize->add_section( 'kid_stuff' , array(
		'title'    => __('Kid Hitchcock Stuff','hitchcock'),
		'priority' => 500
	) );
	
	
	
	$wp_customize->add_setting( 'kid_footer_content', array(
		 'default'           => __( '', 'hitchcock' ),
		 'sanitize_callback' => 'kidhitchcock_sanitize_html'
	) );
	
	// Add control for footer text
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'kid_footer_content',
		    array(
		        'label'    => __( 'Footer Text (allowable HTML tags are: "a, img, em, strong, br" all others will be stripped out)', 'hitchcock' ),
		        'section'  => 'kid_stuff',
		        'settings' => 'kid_footer_content',
		        'type'     => 'textarea'
		    )
	    )
	);		

 	// Allow just some html
	function kidhitchcock_sanitize_html( $value ) {
	
		$allowed_html = [
			'a'      => [
				'href'  => [],
				'title' => [],
			],
			'img'    => [
				'src' => [],
				'alt' => [],
				'title' => [],
			],
			'br'     => [],
			'em'     => [],
			'strong' => [],
		];

		return  wp_kses( $value, $allowed_html );
	}	
	
}

function kidhitchcock_get_footer() {
	 if ( get_theme_mod( 'kid_footer_content') != "" ) {
	 	echo '<p>' . get_theme_mod( 'kid_footer_content') . '</p>';
	 }	else {
	 	echo '&copy; ' . date( 'Y' ) . ' <a href="' . esc_url( home_url() ) . '" class="site-name">' . get_bloginfo( 'name' ) . '</a>';
	 }
}


?>