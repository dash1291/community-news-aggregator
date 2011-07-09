<?php
	
	require(ABSPATH.'/wp-load.php');
	$last_feed_time=get_option("cna-last-update");
	$community_label=get_option("cna-community-label");
	$last_in=new DateTime($last_feed_time);
	$current_time_obj=new DateTime();
	$current_time_string=$current_time_obj->format($current_time_obj::ATOM);
	//TODO:: following code has to execute only when the last feed time is more than 3 minutes older than the current time
	//if($current_time_obj-$last_feed_time>3) // something like this
	//loop through all the users, getting their blog addresses and fetching feeds
$users=$wpdb->get_results("SELECT ID FROM wp_users WHERE '1' = '1'");
	$user_index=0;
	while($users[$user_index])
	{
		$blog_service=get_user_meta($users[$user_index]->ID,"cna_blog_service",true);
		$blog_address=get_user_meta($users[$user_index]->ID,"cna_blog_address",true);
		switch($blog_service)
		{
			case "wordpress":
				$feed_url='http://'.$blog_address.'/feed/atom/';
				break;
			case "blogger":
				$feed_url='http://'.$blog_address.'/feeds/posts/default/';
				break;
			default:
		}
		/*$curlobj=curl_init($feed_url);
		curl_setopt($curlobj,CURLOPT_RETURNTRANSFER,1);
		$str=curl_exec($curlobj);
		echo $str;
		curl_close($curlobj);*/
		$str=file_get_contents($feed_url);
		$atom=new DOMDocument();
		$atom->loadXML($str);
		$atom_entries=$atom->getElementsByTagName("entry");
		$entry_count=$atom_entries->length;
		$latest_entry=$atom_entries->item(0);
		$latest_entry_date=$latest_entry->getElementsByTagName("published")->item(0)->childNodes->item(0)->nodeValue;
		$feed_index=0;
		while($feed_index<$entry_count)
		{
			$entry=$atom_entries->item($feed_index);
			$date=$entry->getElementsByTagName("published")->item(0)->childNodes->item(0)->nodeValue;
			$category=$entry->getElementsByTagName("category")->item(0)->getAttribute("term");
			$feed_date=new DateTime($date);		
			if($feed_date>$last_in && $category==$community_label)
			{
				$title=$entry->getElementsByTagName("title")->item(0)->childNodes->item(0)->nodeValue;
				$summary=$entry->getElementsByTagName("content")->item(0)->childNodes->item(0)->nodeValue;
				$post_url=$entry->getElementsByTagName("link")->item(0)->getAttribute("href");
							echo '<p>'.$title.'</p>';
				$new_post=array(
						'post_title' => $title,
						'post_content' => $summary,
						'post_date' => $date,
						'post_author' => '1',
						'network_id' => $network_id,
						'feed_id' => $feed_id,
						'post_status' => 'pending'
						);
				$post_id=wp_insert_post($new_post);
				// TODO :: success			
			}
			else
			{
				break;
			}
			$feed_index++;	

		}

	$user_index++;
	}
	update_option("cna-last-update",$current_time_string);
	echo 'OK';

?>
