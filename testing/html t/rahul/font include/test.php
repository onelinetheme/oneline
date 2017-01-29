<?php


* ----------------------------------------------------------------------------- */
/* Add Menu Page */
/* ----------------------------------------------------------------------------- */ 

function add_my_menu() {
    add_menu_page (
        'Page Title', // page title 
        'Menu Title', // menu title
        'manage_options', // capability
        'my-menu-slug',  // menu-slug
        'my_menu_page',   // function that will render its output
        get_template_directory_uri() . '/assets/ico/theme-option-menu-icon.png'   // link to the icon that will be displayed in the sidebar
        //$position,    // position of the menu option
    );
}
add_action('admin_menu', 'add_my_menu');
function my_menu_page() {
        ?>
        <?php  
        if( isset( $_GET[ 'tab' ] ) ) {  
            $active_tab = $_GET[ 'tab' ];  
        } else {
            $active_tab = 'tab_one';
        }
        ?>  
        <div class="wrap">
            <h2>Menu Page Title</h2>
            <div class="description">This is description of the page.</div>
            <?php settings_errors(); ?> 

            <h2 class="nav-tab-wrapper">  
                <a href="?page=my-menu-slug&tab=tab_one" class="nav-tab <?php echo $active_tab == 'tab_one' ? 'nav-tab-active' : ''; ?>">Tab One</a>  
                <a href="?page=my-menu-slug&tab=tab_two" class="nav-tab <?php echo $active_tab == 'tab_two' ? 'nav-tab-active' : ''; ?>">Tab Two</a>  
            </h2>  

            <form method="post" action="options.php"> 
            <?php
                if( $active_tab == 'tab_one' ) {  

                    settings_fields( 'setting-group-1' );
                    do_settings_sections( 'my-menu-slug' );

                } elseif( $active_tab == 'tab_two' )  {

                    settings_fields( 'setting-group-2' );
                    do_settings_sections( 'my-menu-slug' );

                }
            ?>

                <?php submit_button(); ?> 
            </form> 

        </div>
        <?php
}

/* ----------------------------------------------------------------------------- */
/* Setting Sections And Fields */
/* ----------------------------------------------------------------------------- */ 

function sandbox_initialize_theme_options() {  
    add_settings_section(  
        'page_1_section',         // ID used to identify this section and with which to register options  
        'Section 1',                  // Title to be displayed on the administration page  
        'page_1_section_callback', // Callback used to render the description of the section  
        'my-menu-slug'                           // Page on which to add this section of options  

    );

    add_settings_section(  
        'page_2_section',         // ID used to identify this section and with which to register options  
        'Section 2',                  // Title to be displayed on the administration page  
        'page_2_section_callback', // Callback used to render the description of the section  
        'my-menu-slug'                           // Page on which to add this section of options  
    );

    /* ----------------------------------------------------------------------------- */
    /* Option 1 */
    /* ----------------------------------------------------------------------------- */ 

    add_settings_field (   
        'option_1',                      // ID used to identify the field throughout the theme  
        'Option 1',                           // The label to the left of the option interface element  
        'option_1_callback',   // The name of the function responsible for rendering the option interface  
        'my-menu-slug',                          // The page on which this option will be displayed  
        'page_1_section',         // The name of the section to which this field belongs  
        array(                              // The array of arguments to pass to the callback. In this case, just a description.  
            'This is the description of the option 1',
        )  
    );  
    register_setting(  
        //~ 'my-menu-slug',  
        'setting-group-1',  
        'option_1'  
    );

    /* ----------------------------------------------------------------------------- */
    /* Option 2 */
    /* ----------------------------------------------------------------------------- */     

    add_settings_field (   
        'option_2',  // ID -- ID used to identify the field throughout the theme  
        'Option 2', // LABEL -- The label to the left of the option interface element  
        'option_2_callback', // CALLBACK FUNCTION -- The name of the function responsible for rendering the option interface  
        'my-menu-slug', // MENU PAGE SLUG -- The page on which this option will be displayed  
        'page_2_section', // SECTION ID -- The name of the section to which this field belongs  
        array( // The array of arguments to pass to the callback. In this case, just a description.  
            'This is the description of the option 2', // DESCRIPTION -- The description of the field.
        )  
    );
    register_setting(  
        'setting-group-2',  
        'option_2'  
    );

} // function sandbox_initialize_theme_options
add_action('admin_init', 'sandbox_initialize_theme_options');

function page_1_section_callback() {  
    echo '<p>Section Description here</p>';  
} // function page_1_section_callback
function page_2_section_callback() {  
    echo '<p>Section Description here</p>';  
} // function page_1_section_callback

/* ----------------------------------------------------------------------------- */
/* Field Callbacks */
/* ----------------------------------------------------------------------------- */ 

function option_1_callback($args) {  
    ?>
    <input type="text" id="option_1" class="option_1" name="option_1" value="<?php echo get_option('option_1') ?>">
    <p class="description option_1"> <?php echo $args[0] ?> </p>
    <?php      
} // end sandbox_toggle_header_callback  

function option_2_callback($args) {  
    ?>
    <textarea id="option_2" class="option_2" name="option_2" rows="5" cols="50"><?php echo get_option('option_2') ?></textarea>
    <p class="description option_2"> <?php echo $args[0] ?> </p>
    <?php      
} // end sandbox_toggle_header_callback  