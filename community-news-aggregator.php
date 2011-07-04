<?php
/*
Plugin Name: Community News Aggregator

*/

//Hook load_cna_menu() to admin menu load action
add_action('admin_menu','load_cna_menu');

function load_cna_menu()
{
	//create an admin menu and its page
	//page title=Community News Aggregator
	//Menu title=Configure Your Blog
	//priviledge=administrator
	//slug=<user the current php file to ommit the slug parameter>
	//callback function=create_menu()
	add_menu_page("Community News Aggregator","Configure Your Blog",'administrator',__FILE__,'create_menu');	
}
function create_menu()
{
	$plugin_url=plugin_dir_url(dirname(__FILE__).'/community-news-aggregator.php');
	$plugin_dir=plugin_dir_path(dirname(__FILE__).'/community-news-aggregator.php');

	//load blog settings form
	include $plugin_dir.'/blog-settings-form.php';
}

