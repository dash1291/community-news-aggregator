
<?php
/*
Plugin Name: Community News Aggregator

*/

//Hook load_cna_menu() to admin menu load action
add_action('admin_head','cna_include');
add_action('admin_menu','cna_init');
function cna_include()
{
	?>

	<script>
	function cna_update()
	{
		jQuery("#cna-status-container").show();
		jQuery.post(ajaxurl,{'action':'cna'},function(response)
		{
			jQuery("#cna-loading").hide();
			document.getElementById("cna-status").innerHTML="Updated";
		});

	}
	</script>
	<?php
}

$plugin_url=plugin_dir_url(dirname(__FILE__).'/community-news-aggregator.php');
$plugin_dir=plugin_dir_path(dirname(__FILE__).'/community-news-aggregator.php');
	
include $plugin_dir.'/cna-update.php';
add_action('wp_ajax_cna','cna_update_news');
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
	add_submenu_page('cna-parent-menu','Community News Aggregator','News Update','administrator','cna-news-update','create_update_page');
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
	include $plugin_dir.'/cna-blog-settings-form.php';
	
//	add_action('admin_init','cna_init_blog_settings');
}

function create_admin_page()
{
	$plugin_url=plugin_dir_url(dirname(__FILE__).'/community-news-aggregator.php');
	$plugin_dir=plugin_dir_path(dirname(__FILE__).'/community-news-aggregator.php');
	include $plugin_dir.'/cna-admin.php';
	add_action('admin_init','cna_init_admin_settings');
}
	
function create_update_page()
{
	
	cna_show_update_page();
}

