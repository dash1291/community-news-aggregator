<div id="cna-form-container">
<?php 
//get current logged in user
$user=wp_get_current_user();
$userid=$user->ID;
if(isset($_POST['cna-service']))
{
	//Proceed with saving blog settings
	//Settings are saved as User Meta Data 
	//Blog address has a meta key 'cna-blog-address'
	//Blog service has a meta key 'cna-blog-service'
	$blog_service=$POST['cna-service'];
	$blog_address=$POST['cna-blog-address'];
	set_user_meta($userid,"cna-blog_service",$blog_service);
	set_user_meta($userid,"cna-blog_address",$blog_service);
}
else
{
	//load saved blog config from user's meta data into the form variables
	$blog_service=get_user_meta($userid,"cna_blog_service",true);
	$blog_address=get_user_meta($userid,"cna_blog_addresss",true);
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
}

?>
<link rel="stylesheet" type="text/css" href="<?php echo $plugin_url.'/style.css'; ?>"/>
<h2>Configure Your Blog on this Community</h2>
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

