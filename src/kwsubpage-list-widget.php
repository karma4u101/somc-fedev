<?php
/*
 Plugin Name: Subpage list widget
 Plugin URI: 
 Description: Add a collapsable subpage listing.
 Version: 0.1
 Author: Peter Petersson
 Author URI: https://github.com/karma4u101
 */



class KWSubpageListWidget extends WP_Widget {
	
	public function KWSubpageListWidget(){
		$widget_options = array(
				'classname' => 'KWSubpageListWidget',
				'description' => 'Collapsable subpage listing'
		);
		parent::WP_Widget('kwsubpage_list_widget','Subpage list widget',$widget_options);
	}

	function widget( $args, $instance){
		$this->kwsubpage_list();
	}
	
	protected function kwsubpage_list(){
		global $post;
		// Determine parent page ID
		$parent_page_id = ( '0' != $post->post_parent ? $post->post_parent : $post->ID );
		$gaargs = Array('orderby' => 'title',
				'order'   => 'ASC');
		//get a flat array of all subpages
		$gasubpages = $this->get_all_subpages($parent_page_id, $gaargs);
		if (sizeof($gasubpages) > 0) {
		    //rem above in favor for array_reverse to avoid hitting the db twice
		    $gasubpages2 = array_reverse($gasubpages); 
		    //transform the array to a contain nested child arrays with children pages
		    $tree = $this->buildTree($gasubpages,$parent_page_id);
		    $revtree = $this->buildTree($gasubpages2,$parent_page_id);    
		    ?>
			        <script>
					    var kwmenu = <?php echo json_encode($tree); ?>;
					    var kwmenu2 = <?php echo json_encode($revtree); ?>;
			        </script>
			        <div id="kwnav-widget-wrapper">
			        <div id="togglekwlist">
			        <div class="pull-right glyphicon glyphicon-sort"></div>
			        </div> 
			        <ul id="kwnav-container-asc" class="nav nav-kwnav" style="display:"></ul>
			        <ul id="kwnav-container-desc" class="nav nav-kwnav" style="display:none"></ul>
			        </div> 
			<?php			
		}
	}

	//recursively build a nested parent, child relation array structure from a flat array
	private function buildTree(array $elements, $parentId = 0) {
		$branch = array();
		foreach ($elements as $element) {
			if ($element['post_parent'] == $parentId) {
				$children = $this->buildTree($elements, $element['ID']);
				if ($children) {
					$element['menu'] = $children;
				}
				$branch[] = $element;
			}
		}
		return $branch;
	}
	
	//get a flat array of all subpages from the db
	private function get_all_subpages($page, $args = '') {
		// Validate 'page' parameter
		if (! is_numeric($page))
			$page = 0;
		// Set up args
		$default_args = array(
				'post_type' => 'page',
		);
		if (empty($args))
			$args = array();
		elseif (! is_array($args))
		if (is_string($args))
			parse_str($args, $args);
		else
			$args = array();
		$args = array_merge($default_args, $args);
		$args['post_parent'] = $page;

		// Get children
		$subpages = array();
		$children = get_children($args, ARRAY_A);
		foreach ($children as $child) {
			$subpages[] = $child;
            $page = $child['ID'];
			// Get subpages by recursion
			$subpages = array_merge($subpages, $this->get_all_subpages($page, $args));
		}
		return $subpages;
	}
	
	//first take on adding shortcode functionality, currently not working + needs refactoring 
	//to avoid dublication of code.   
	public function display(){
		global $post;
		// Determine parent page ID
		$parent_page_id = ( '0' != $post->post_parent ? $post->post_parent : $post->ID );
		$gaargs = Array('orderby' => 'title',
				'order'   => 'ASC');
		//get a flat array of all subpages
		$gasubpages = $this->get_all_subpages($parent_page_id, $gaargs);
		$widgetContent = '';
		if (sizeof($gasubpages) > 0) {
		    $gasubpages2 = array_reverse($gasubpages);
		    //transform the array to a contain nested child arrays with children pages
		    $tree = $this->buildTree($gasubpages,$parent_page_id);
		    $revtree = $this->buildTree($gasubpages2,$parent_page_id);		
		    $widgetContent = '<script>';
		    $widgetContent .= 'var kwmenu = ' . json_encode($tree) . ';';
		    $widgetContent .= 'var kwmenu2 = ' . json_encode($revtree) . ';';
		    $widgetContent .= '</script>';
		    $widgetContent .= '<div id="kwnav-widget-wrapper">';
		    $widgetContent .= '<div id="togglekwlist">';
		    $widgetContent .= '<div class="pull-right glyphicon glyphicon-sort"></div>';
		    $widgetContent .= '</div>'; 
		    $widgetContent .= '<ul id="kwnav-container-asc" class="nav nav-kwnav" style="display:"></ul>';
		    $widgetContent .= '<ul id="kwnav-container-desc" class="nav nav-kwnav" style="display:none"></ul>';
		    $widgetContent .= '</div>'; 	
		}	
		return $widgetContent;
	}

//call to adding shortcode is removed and method commented out due to problem initializing the widget
//as a shortcode, my guess is that I probably need to initialize the widget as a singelton instance 
//and refer to the the instance in the add_shortcode function(?).
// 	protected function _init() {
// 		error_log("in _init");
// 	    add_shortcode( 'kwsubpage-list', array( $this , 'display' ) );	
// 	}
	
}

//Enqueue stylesheet
add_action( 'wp_enqueue_scripts', 'kwsubpage_list_event_add_stylesheet' );
function kwsubpage_list_event_add_stylesheet() {
	// Respects SSL, Style.css is relative to the current file
	wp_register_style( 'kwsubpage_list_stylesheet', plugins_url('/assets/css/kwsubpage.css', __FILE__), array('bootstrap.css'),"0.1",false );
	wp_enqueue_style( 'kwsubpage_list_stylesheet' );
}
//Enqueue scripts
add_action( 'wp_enqueue_scripts', 'kwsubpage_list_event_add_scripts' );
function kwsubpage_list_event_add_scripts() {
	//Register the script to make it available -- here theme-js is the bootstrap.js (v3) script used by the devbootsrap3 theme 
	wp_register_script( 'kwsubpage_list_scripts', plugins_url( '/assets/js/kwsubpage.js' , __FILE__ ), array('jquery','theme-js'), "0.1", false );
	//Enqueue it to load it onto the page
	wp_enqueue_script('kwsubpage_list_scripts');
}


function kwsubpage_widget_init(){
	register_widget("KWSubpageListWidget");
}
add_action('widgets_init','kwsubpage_widget_init');


?>