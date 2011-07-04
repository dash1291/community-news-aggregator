<?php
/*
Plugin Name: Community News Aggregator

*/

//Hook load_cna_menu() to admin menu load action
add_action('admin_menu','cna_init');
function cna_init()
{
	$user=wp_get_current_user();
	$role=$user->roles[0];
	if($role=='administrator')
	{
		admin_cna_menu();
	}
	else
	{
		subscriber_cna_menu();
	}

}
function admin_cna_menu()
{
	add_menu_page("Community News Aggregator","Configure Your Blog",'administrator','cna-parent-menu','create_menu');		
	add_submenu_page('cna-parent-menu','Community News Aggregator','Settings','administrator','cna-admin-config','create_admin_page');
}
function subscriber_cna_menu()
{
	//create an admin menu and its page
	//page title=Community News Aggregator
	//Menu title=Configure Your Blog
	//priviledge=administrator
	//slug=<user the current php file to ommit the slug parameter>
	//callback function=create_menu()
	add_menu_page("Community News Aggregator","Configure Your Blog",'subscriber','cna-parent-menu','create_menu');
}
function create_menu()
{
	$plugin_url=plugin_dir_url(dirname(__FILE__).'/community-news-aggregator.php');
	$plugin_dir=plugin_dir_path(dirname(__FILE__).'/community-news-aggregator.php');

	//load blog settings form
	include $plugin_dir.'/blog-settings-form.php';
}

function create_admin_page()
{
	echo 'this is the admin page';
}

