<?php

/*
Plugin Name: Increase Sociability
Plugin URI: http://www.preblogging.com/increase-sociability/
Description: This is a call to action to increase to get your StumbleUpon & Digg visitors to vote for your site. This is based on  heavily on <a href="http://www.richardkmiller.com/blog/wordpress-plugin-what-would-seth-godin-do/">What Would Seth Godin Do</a> by <a href="http://www.richardkmiller.com/blog/">Richard K Miller</a>. 
Version: 1.3.0
Author: Becky Sanders
Author URI: http://www.preblogging.com

*/

$defaultdata = array(
	'new_digg_visitor_message' => "<p style='border:thin dotted black; padding:3mm;'>Hello fellow <b>Digger</b>, if you like this page, don't forget to digg it ! </p>",
	'new_stumble_visitor_message' => "<div style='border:thin dotted black; padding:3mm;'>Welcome, <b>StumbleUpon</b> visitor! Don't forget to give me thumbs up if you like this page !</div>",
	'message_location' => 'before_post',
	'new_site1_visitor_message' => "<p style='border:thin dotted black; padding:3mm;'>Hello fellow <b>Example.com Visitor</b>, if you like this page, don't forget to vote for it ! </p>",
	'new_site1' => 'www.preblogging.com',
	'test' => 'no',
	'nice_link' => 'no'
	);
	
add_option('incSoc_settings', $defaultdata, 'Options for Increasing Social Media Traffic');

$incSoc_settings = get_option('incSoc_settings');
$incSoc_settings['new_digg_visitor_message'] = stripslashes($incSoc_settings['new_digg_visitor_message']);
$incSoc_settings['new_stumble_visitor_message'] = stripslashes($incSoc_settings['new_stumble_visitor_message']);
$incSoc_settings['new_site1_visitor_message'] = stripslashes($incSoc_settings['new_site1_visitor_message']);
$incSoc_settings['new_site1'] = stripslashes($incSoc_settings['new_site1']);
$incSoc_settings['test'] = stripslashes($incSoc_settings['test']);


add_action('admin_menu', 'add_incSoc_options_page');


add_filter('the_content', 'incSoc_message_filter');

function add_incSoc_options_page()
{
	if (function_exists('add_options_page'))
	{
		add_options_page('Increase Social Media Traffic', 'Increase Sociability', 8, basename(__FILE__), 'incSoc_options_subpanel');
	}
}



function incSoc_options_subpanel()
{
	global $incSoc_settings, $_POST;
	
	if (isset($_POST['submit']))
	{
		$incSoc_settings['new_digg_visitor_message'] = stripslashes($_POST['new_digg_visitor_message']);
		$incSoc_settings['new_stumble_visitor_message'] = stripslashes($_POST['new_stumble_visitor_message']);
		$incSoc_settings['new_site1_visitor_message'] = stripslashes($_POST['new_site1_visitor_message']);
		$incSoc_settings['new_site1'] = stripslashes($_POST['new_site1']);
		$incSoc_settings['message_location'] = $_POST['message_location'];
		$incSoc_settings['nice_link'] = $_POST['nice_link'];
		$incSoc_settings['test'] = $_POST['test'];

		update_option('incSoc_settings', $incSoc_settings);
	}
	?>
	<div class="wrap">
        <h2>Increase StumbleUpon and Digg votes</h2>
        <p>When the browser detects that a visitor is coming from StumbleUpon.com or from Digg.com, it will give them a little reminder that then should give you a vote. This plugin should help increase the precentage of visitors to voters a little (or a lot).</p>
        
        <form action="" method="post">
        <h3>Message to Visitors from Digg.com:</h3>
        <textarea rows="4" cols="80" name="new_digg_visitor_message"><?php echo htmlentities($incSoc_settings['new_digg_visitor_message']); ?></textarea>
        <h3>Message to  Visitors from StumbleUpon.com:</h3>
        <textarea rows="6" cols="80" name="new_stumble_visitor_message"><?php echo htmlentities($incSoc_settings['new_stumble_visitor_message']); ?></textarea>
		<h3>Message to Visitors from custom site</h3>
        <textarea rows="6" cols="80" name="new_site1_visitor_message"><?php echo htmlentities($incSoc_settings['new_site1_visitor_message']); ?></textarea><br/>
	    Your Custom Site : <strong>http://</strong><input type="text" name="new_site1" length="30" width="30" value="<?php echo $incSoc_settings['new_site1']; ?>"><strong>/</strong> 

        <h3>Location of Message</h3>
        <p><input type="radio" name="message_location" value="before_post" <?php if ($incSoc_settings['message_location'] == 'before_post') echo 'checked="checked"'; ?> /> Before Post</p>
        <p><input type="radio" name="message_location" value="after_post" <?php if ($incSoc_settings['message_location'] == 'after_post') echo 'checked="checked"'; ?> /> After Post</p>
         <p><input type="radio" name="message_location" value="both_post" <?php if ($incSoc_settings['message_location'] == 'both_post') echo 'checked="checked"'; ?> /> Both Before & After Post</p>
        <h3>Add link in the footer to Plugin Author</h3>
	<p>If you would like to add a link back to the author (<a href="http://www.preblogging.com/">www.preblogging.com</a>) you can do so by selecting yes. Of course, like everything in life, you have a choice <img src="<?php echo get_option('home') . "/wp-includes/images/smilies/icon_biggrin.gif"	?>" title="wink wink">. The link will be in the footer and will say the following<br/>
	<div style="border:thin dotted black; padding:3mm;" >I'm happy to use <a href="http://www.preblogging.com/increase-sociability/" title="Increase Stumbleupon & Digg Traffic">Increase Sociability</a>.</div>
	</p>	

		 <p><input type="radio" name="nice_link" value="yes" <?php if ($incSoc_settings['nice_link'] == 'yes') echo 'checked="checked"'; ?> /> yeah sure, why not !</p>
        <p><input type="radio" name="nice_link" value="no" <?php if ($incSoc_settings['nice_link'] == 'no') echo 'checked="checked"'; ?> /> no thanks, not right now</p>
		<h3>Test the messages</h3>
		<p>If you want to see the messages on all pages, to see how it works with your layout, change the selection to yes.</p>
		<p><input type="radio" name="test" value="yes" <?php if ($incSoc_settings['test'] == 'yes') echo 'checked="checked"'; ?> />Yes, show the Digg Message as a test</p>
        <p><input type="radio" name="test" value="no" <?php if ($incSoc_settings['test'] == 'no') echo 'checked="checked"'; ?> /> No thanks, I am happy with it</p>
				<p><input type="submit" name="submit" value="Save Settings" /></p>
        </form>
		For help with this plugin you can visit the official support post on <a href="http://www.preblogging.com/increase-sociability-wordpress-plugin/">PreBlogging.com</a>.
        </div>
	<?php
}



function incSoc_message_filter($content = '')
{
	global $incSoc_visits, $incSoc_settings, $incSoc_messagedisplayed, $incSoc_test;

	$returnValue = $content;
	
	if ( (!is_feed() && !$incSoc_messagedisplayed) || $incSoc_settings['test'] == 'yes')
	{
		$incSoc_messagedisplayed = true;
		$browser_message = '';
		
		if($_SERVER['HTTP_REFERER'] != ''){
			$URL = parse_url($_SERVER['HTTP_REFERER']);
		
		 if ($URL['host'] =="www.stumbleupon.com"){

			$browser_message = $incSoc_settings['new_stumble_visitor_message'] ;
			}
		elseif ($URL['host'] == $incSoc_settings['new_site1']){
		$browser_message = $incSoc_settings['new_site1_visitor_message'] ;
		}
		elseif ($incSoc_settings['test'] == 'yes'){
			$browser_message = "<br/><strong>TEST INCREASE SOCIABILITY \/\/\/</strong> ";
			$browser_message .= $incSoc_settings['new_digg_visitor_message'] ;
		}
		else if ($URL['host'] =="digg.com" || $URL['host'] =="www.digg.com"){
			$browser_message = $incSoc_settings['new_digg_visitor_message'] ;
			}
			//$browser_message .= $URL['host'];
		}
		

		if ($incSoc_settings['message_location'] == 'before_post' )
		{
			$returnValue =
				$browser_message
				.
				$content
			;
		}
		else if ($incSoc_settings['message_location'] == 'after_post')
		{
			$returnValue =
				$content
				.
				$browser_message
				.
				$incSoc_settings['new_visitor_message']
			;
		}
		else {
				$returnValue =
				$browser_message
				.
				$content
				.
				$browser_message
			;
		}
	}
//$returnValue .= "<br/>testdata : " . $URL['host'] . "<br/>" ;  
	return $returnValue;
}

function preblogging_notice() {
global  $incSoc_settings;
$comment =  "\n<!-- Increase Socialability 1.3 - http://www.preblogging.com/increase-sociability/ -->\n " ;
	if ($incSoc_settings['nice_link'] == 'yes'){
		echo '<p>I\'m happy to use <a href="http://www.preblogging.com/increase-sociability/" title="Increase Stumbleupon & Digg Traffic">Increase Sociability</a>.</p>';
		echo $comment;
	}else {
		echo $comment;
	}
}


add_action( 'wp_footer', 'preblogging_notice' );

?>
