<div id="cna-form-container">
<h2>Configure Your Blog on this Community</h2>
<?php 
function cna_init_blog_settings()
{
	$user=wp_get_current_user();
	$userid=$user->ID;
	register_setting("cna-settings","cna-".$userid."-blog-service");
	add_settings_section("cna-".$userid."-settings",'',"cna_user_settings_form",'cna-parent-menu');
	add_settings_field("cna-".$userid."-blog-service",'',"cna_blog_service_string",'cna-parent-menu',"cna-".$userid."-settings");
	add_settings_field("cna-".$userid."-blog-address",'',"cna_blog_service_string",'cna-parent-menu',"cna-".$userid."-settings");
	
}


//get current logged in user
$user=wp_get_current_user();
$userid=$user->ID;
if(isset($_POST['cna-blog-address']))
{
	//Proceed with saving blog settings
	//Settings are saved as User Meta Data 
	//Blog address has a meta key 'cna-blog-address'
	//Blog service has a meta key 'cna-blog-service'
	$blog_service=$_POST['cna-service'];
	$blog_address=$_POST['cna-blog-address'];
	update_user_meta($userid,"cna_blog_service",$blog_service);
	update_user_meta($userid,"cna_blog_address",$blog_address);
	echo '<div class="updated">Blog settings updated</div>';
}
else
{
	//load saved blog config from user's meta data into the form variables
	$blog_service=get_user_meta($userid,"cna_blog_service",true);
	$blog_address=get_user_meta($userid,"cna_blog_address",true);
}

switch($blog_service)
	{
		case 'blogger':
			$blogger="selected";
			break;
		case 'wordpress':
			$wordpress="selected";
			break;
		default:
	}

?>
<link rel="stylesheet" type="text/css" href="<?php echo $plugin_url.'/style.css'; ?>"/>
<form method="post" action="">
<p>Select Your Blogging Service
<select name="cna-service" class="cna-input">
<option value="wordpress" <?php echo $wordpress?>>WordPress</option>
<option value="blogger" <?php echo $blogger?>>Blogger</option>
</select>
</p>
<p>Enter Your Blog's Address
<input type="text" name="cna-blog-address" size="50" class="cna-input" id="cna-blog-address" value="<?php echo $blog_address; ?>"/><span class="cna-info">Example: yourblogaddress.com or yourblog.wordpress.com</span>
</p>
<p><input id="cna-submit" type="submit" value="Save Settings" class="button"/></p>
</form>
</div>

