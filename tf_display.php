<?php 
/*
Core logic to display social share icons at the required positions. 
*/
require_once('tf_admin_page.php');

function twitter_facebook_share_init() {
	// DISABLED IN THE ADMIN PAGES
	if (is_admin()) {
		return;
	}

	//GET ARRAY OF STORED VALUES
	$option = twitter_facebook_share_get_options_stored();

	if ($option['active_buttons']['twitter']==true) {
		wp_enqueue_script('twitter_facebook_share_twitter', 'http://platform.twitter.com/widgets.js','','',$option['jsload']);
	}
	
	if ($option['active_buttons']['Google_plusone']==true) {
		wp_enqueue_script('twitter_facebook_share_google', 'http://apis.google.com/js/plusone.js','','',$option['jsload']);
	}

	
}    


function kc_twitter_facebook_contents($content)
{
  global $single;
  $output = kc_social_share();
  $option = twitter_facebook_share_get_options_stored();
  if (is_single() && ($option['show_in']['posts'])) {
  		if ($option['position'] == 'above')
        	return  $output . $content;
		if ($option['position'] == 'below')
			return  $content . $output;
		if ($option['position'] == 'left')
			return  $output . $content;
		if ($option['position'] == 'both')
			return  $output . $content . $output;
    } 
	if (is_home() && ($option['show_in']['home_page'])){
		$option = twitter_facebook_share_get_options_stored();
		if ($option['position'] == 'above')
        	return  $output . $content;
		if ($option['position'] == 'below')
			return  $content . $output;
		if ($option['position'] == 'left')
			return  $output . $content;
		if ($option['position'] == 'both')
			return  $output . $content . $output;
	}
	if (is_singular() && ($option['show_in']['pages'])) {
  		if ($option['position'] == 'above')
        	return  $output . $content;
		if ($option['position'] == 'below')
			return  $content . $output;
		if ($option['position'] == 'left')
			return  $output . $content;
		if ($option['position'] == 'both')
			return  $output . $content . $output;
    }  
	if (is_category() && ($option['show_in']['categories'])) {
  		if ($option['position'] == 'above')
        	return  $output . $content;
		if ($option['position'] == 'below')
			return  $content . $output;
		if ($option['position'] == 'left')
			return  $output . $content;
		if ($option['position'] == 'both')
			return  $output . $content . $output;
    } 
	if (is_tag() && ($option['show_in']['tags'])) {
  		if ($option['position'] == 'above')
        	return  $output . $content;
		if ($option['position'] == 'below')
			return  $content . $output;
		if ($option['position'] == 'left')
			return  $output . $content;
		if ($option['position'] == 'both')
			return  $output . $content . $output;
    } 
	if (is_author() && ($option['show_in']['authors'])) {
  		if ($option['position'] == 'above')
        	return  $output . $content;
		if ($option['position'] == 'below')
			return  $content . $output;
		if ($option['position'] == 'left')
			return  $output . $content;
		if ($option['position'] == 'both')
			return  $output . $content . $output;
    } 
	if (is_search() && ($option['show_in']['search'])) {
  		if ($option['position'] == 'above')
        	return  $output . $content;
		if ($option['position'] == 'below')
			return  $content . $output;
		if ($option['position'] == 'left')
			return  $output . $content;
		if ($option['position'] == 'both')
			return  $output . $content . $output;
    } 
	if (is_date() && ($option['show_in']['date_arch'])) {
  		if ($option['position'] == 'above')
        	return  $output . $content;
		if ($option['position'] == 'below')
			return  $content . $output;
		if ($option['position'] == 'left')
			return  $output . $content;
		if ($option['position'] == 'both')
			return  $output . $content . $output;
    } 
	return $content;
}

// Function to manually display related posts.
function kc_add_social_share()
{
 $output = kc_social_share();
 echo $output;
}



function kc_social_share()
{
	//GET ARRAY OF STORED VALUES
	$option = twitter_facebook_share_get_options_stored();
	if (empty($option['bkcolor_value']))
		$option['bkcolor_value'] = '#F0F4F9';

?>
<style type="text/css">
#leftcontainerBox {
<?php if ($option['border'] == 'flat') 
		echo 'border:1px solid #808080;';
	  if ($option['border'] == 'round')
	  echo 'border:1px solid #808080;
			border-radius:5px 5px 5px 5px;
			box-shadow:2px 2px 5px rgba(0,0,0,0.3);'; ?>
float:left;
position: <?php echo $option['float_position']; ?>;
top:<?php echo $option['bottom_space']; ?>;
left:<?php echo $option['left_space'] ?>;
z-index:1;
<?php if ($option['bkcolor'] == true)
		echo 'background-color:';  echo $option['bkcolor_value']; ?>
}

#leftcontainerBox .buttons {
float:left;
clear:both;
margin:4px 4px 4px 4px;
width:55px;
height:60px;
padding-bottom:2px;
}


#bottomcontainerBox {
<?php if ($option['border'] == 'flat') 
		echo 'border:1px solid #808080;';
	  if ($option['border'] == 'round')
	  echo 'border:1px solid #808080;
			border-radius:5px 5px 5px 5px;
			box-shadow:2px 2px 5px rgba(0,0,0,0.3);'; ?>
float:left;
height:30px;
width:100%;
<?php if ($option['bkcolor'] == true)
		echo 'background-color:';  echo $option['bkcolor_value']; ?>
}

#bottomcontainerBox .buttons {
float:left;
height:30px;
width:85px;
margin:4px 4px 4px 4px;
}

</style>
<?php
 	$post_link = esc_url(get_permalink());
	$post_title = get_the_title();
	if ($option['position'] == 'left' && ( !is_single() || !is_singular()))
		$option['position'] = 'above';
	if ($option['position'] == 'left'){
		$output = '<div id="leftcontainerBox">';
		if ($option['active_buttons']['facebook_like']==true) {
		$output .= '
			<div class="buttons">
			<iframe src="http://www.facebook.com/plugins/like.php?href=' . rawurlencode(get_permalink()) . '&amp;layout=box_count&amp;show_faces=false&amp;action=like&amp;font=verdana&amp;colorscheme=light" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:50px; height:60px;" allowTransparency="true"></iframe>
			</div>';
		}
		
		if ($option['active_buttons']['twitter']==true) {
		if ($option['twitter_id'] != ''){
		$output .= '
			<div class="buttons">
			<a href="http://twitter.com/share" class="twitter-share-button" data-url="'. $post_link .'"  data-text="'. $post_title . '" data-count="vertical" data-via="'. $option['twitter_id'] . '">Tweet</a>
			</div>';
		} else {
		$output .= '
			<div class="buttons">
			<a href="http://twitter.com/share" class="twitter-share-button" data-url="'. $post_link .'"  data-text="'. $post_title . '" data-count="vertical">Tweet</a>
			</div>';
		}
		}
		
		if ($option['active_buttons']['Google_plusone']==true) {
		$output .= '
			<div class="buttons">
			<g:plusone size="tall" href="'. $post_link .'"></g:plusone>
			</div>';
		}
		
		if ($option['active_buttons']['stumbleupon']==true) {
		$output .= '
			<div class="buttons"><script src="http://www.stumbleupon.com/hostedbadge.php?s=5&amp;r='.$post_link.'"></script></div>';
		}
		$output .= '</div><div style="clear:both"></div>';
		return $output;
	}

		
	if (($option['position'] == 'below') || ($option['position'] == 'above') || ($option['position'] == 'both'))
	{
		$output = '<div id="bottomcontainerBox">';
		if ($option['active_buttons']['facebook_like']==true) {
		$output .= '
			<div class="buttons">
			<iframe src="http://www.facebook.com/plugins/like.php?href=' . rawurlencode(get_permalink()) . '&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;font=verdana&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>';
		}

		if ($option['active_buttons']['Google_plusone']==true) {
		$output .= '
			<div class="buttons">
			<g:plusone size="medium" href="' . $post_link . '"></g:plusone>
			</div>';
		}
		
		if ($option['active_buttons']['stumbleupon']==true) {
		$output .= '			
			<div class="buttons"><script src="http://www.stumbleupon.com/hostedbadge.php?s=1&amp;r='.$post_link.'"></script></div>';
		}
		
		if ($option['active_buttons']['twitter']==true) {
		if ($option['twitter_id'] != ''){
		$output .= '
			<div class="buttons">
			<a href="http://twitter.com/share" class="twitter-share-button" data-url="'. $post_link .'"  data-text="'. $post_title . '" data-count="horizontal" data-via="'. $option['twitter_id'] . '">Tweet</a>
			</div>';
		} else {
		$output .= '
			<div class="buttons">
			<a href="http://twitter.com/share" class="twitter-share-button" data-url="'. $post_link .'"  data-text="'. $post_title . '" data-count="horizontal">Tweet</a>
			</div>';
		}
		}
		$output .= '			
			</div><div style="clear:both"></div><div style="padding-bottom:4px;"></div>';
			
		return $output;
	}
}
?>