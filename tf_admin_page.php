<?php
/*
The main admin page for this plugin. The logic for different user input and form submittion is written here. 
*/

function kc_twitter_facebook_admin_menu() {
add_options_page('TF Social Share', 'TF Social Share', 'administrator',
'kc-social-share', 'kc_twitter_facebook_admin_page');
}

function kc_twitter_facebook_admin_page() {

	$option_name = 'twitter_facebook_share';
if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

$active_buttons = array(
		'facebook_like'=>'Facebook like',
		'twitter'=>'Twitter',
		'stumbleupon'=>'Stumbleupon',
		'Google_plusone'=>'Google PlusOne'
	);	
	
	$out = '';
	
	if( isset($_POST['twitter_facebook_share_position'])) {
		$option = array();
		
		$option['auto'] = (isset($_POST['twitter_facebook_share_auto_display']) and $_POST['twitter_facebook_share_auto_display']=='on') ? true : false;

		foreach (array_keys($active_buttons) as $item) {
			$option['active_buttons'][$item] = (isset($_POST['twitter_facebook_share_active_'.$item]) and $_POST['twitter_facebook_share_active_'.$item]=='on') ? true : false;
		}	
		$option['position'] = esc_html($_POST['twitter_facebook_share_position']);
		$option['border'] = esc_html($_POST['twitter_facebook_share_border']);
		
		$option['bkcolor'] = (isset($_POST['twitter_facebook_share_background_color']) and $_POST['twitter_facebook_share_background_color']=='on') ? true : false;
		
		$option['bkcolor_value'] = esc_html($_POST['twitter_facebook_share_bkcolor_value']);
		$option['jsload'] = (isset($_POST['twitter_facebook_share_javascript_load']) and $_POST['twitter_facebook_share_javascript_load']=='on') ? true : false;

		$option['twitter_id'] = esc_html($_POST['twitter_facebook_share_twitter_id']);		
		$option['left_space'] = esc_html($_POST['twitter_facebook_share_left_space']);
		$option['bottom_space'] = esc_html($_POST['twitter_facebook_share_bottom_space']);
		$option['float_position'] = esc_html($_POST['twitter_facebook_share_float_position']);
		
		update_option($option_name, $option);
		// Put a settings updated message on the screen
		$out .= '<div class="updated"><p><strong>'.__('Settings saved.', 'menu-test' ).'</strong></p></div>';
	}
	
	//GET ARRAY OF STORED VALUES
	$option = twitter_facebook_share_get_options_stored();
	
	$sel_above = ($option['position']=='above') ? 'selected="selected"' : '';
	$sel_below = ($option['position']=='below') ? 'selected="selected"' : '';
	$sel_both  = ($option['position']=='both' ) ? 'selected="selected"' : '';
	$sel_left  = ($option['position']=='left' ) ? 'selected="selected"' : '';
	
	$sel_flat = ($option['border']=='flat') ? 'selected="selected"' : '';
	$sel_round = ($option['border']=='round') ? 'selected="selected"' : '';
	$sel_none  = ($option['border']=='none' ) ? 'selected="selected"' : '';
	
	$sel_fixed = ($option['float_position']=='fixed') ? 'selected="selected"' : '';
	$sel_absolute = ($option['float_position']=='absolute') ? 'selected="selected"' : '';
	
	$bkcolor = ($option['bkcolor']) ? 'checked="checked"' : '';
	$jsload =  ($option['jsload']) ? 'checked="checked"' : '';
	$auto =    ($option['auto']) ? 'checked="checked"' : '';
	
	$out .= '
	<div class="wrap">
	<div style="float:left; width:70%;">
	<h2>'.__( 'Facebook and Twitter share buttons', 'menu-test' ).'</h2>
	<form name="form1" method="post" action="">

	<table>

	<tr><td valign="top" colspan="2"><h3>'.__("General Settings", 'menu-test' ).'</h3></td></tr>

	<tr><td style="padding-bottom:20px;" valign="top">'.__("Auto Display", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;">
		<input type="checkbox" name="twitter_facebook_share_auto_display" '.$auto.' />
		<span class="description">'.__("Enable Auto display of Social Share buttons at specified postion", 'menu-test' ).'</span>
	</td></tr>
	
	<tr><td style="padding-bottom:20px;" valign="top">'.__("Code for Manual Display", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;">
	<code>&lt;?php if(function_exists(&#39;kc_add_social_share&#39;)) kc_add_social_share(); ?&gt;</code>
	</td></tr>

	<tr><td valign="top" style="width:130px;">'.__("Active share buttons", 'menu-test' ).':</td>
	<td style="padding-bottom:40px;">';
	
	foreach ($active_buttons as $name => $text) {
		$checked = ($option['active_buttons'][$name]) ? 'checked="checked"' : '';
		$out .= '<div style="width:150px; float:left;">
				<input type="checkbox" name="twitter_facebook_share_active_'.$name.'" '.$checked.' /> '
				. __($text, 'menu-test' ).' &nbsp;&nbsp;</div>';

	}

	$out .= '</td></tr>
	
	<tr><td style="padding-bottom:20px;" valign="top">'.__("Position", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;"><select name="twitter_facebook_share_position">
		<option value="above" '.$sel_above.' > '.__('Above the post', 'menu-test' ).'</option>
		<option value="below" '.$sel_below.' > '.__('Below the post', 'menu-test' ).'</option>
		<option value="both"  '.$sel_both.'  > '.__('Above and Below the post', 'menu-test' ).'</option>
		<option value="left"  '.$sel_left.'  > '.__('Left Side of the post', 'menu-test' ).'</option>
		</select>
	</td></tr>
	
	<tr><td style="padding-bottom:20px;" valign="top">'.__("Border Style", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;"><select name="twitter_facebook_share_border">
		<option value="flat"  '.$sel_flat.' > '.__('Flat Border', 'menu-test' ).'</option>
		<option value="round" '.$sel_round.' > '.__('Round Border', 'menu-test' ).'</option>
		<option value="none"  '.$sel_none.'  > '.__('No Border', 'menu-test' ).'</option>
		</select>
	</td></tr>
	
	<tr><td style="padding-bottom:20px;" valign="top">'.__("Show Background Color", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;">
		<input type="checkbox" name="twitter_facebook_share_background_color" '.$bkcolor.' />
	</td></tr>
	
	<tr><td style="padding-bottom:20px;" valign="top">'.__("Background Color", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;">
	<input type="text" name="twitter_facebook_share_bkcolor_value" value="'.$option['bkcolor_value'].'" size="10">  
		 <span class="description">'.__("Default Color wont disappoint you", 'menu-test' ).'</span>
	</td></tr> 
	
	<tr><td style="padding-bottom:20px;" valign="top">'.__("Load Javascript in Footer", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;">
		<input type="checkbox" name="twitter_facebook_share_javascript_load" '.$jsload.' />
		<span class="description">'.__("(Recommended, else loaded in header)", 'menu-test' ).'</span>
	</td></tr>
	<tr><td style="padding-bottom:20px;" valign="top">'.__("Your Twitter ID", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;">
	<input type="text" name="twitter_facebook_share_twitter_id" value="'.$option['twitter_id'].'" size="30">  
		 <span class="description">'.__("Specify your twitter id without @", 'menu-test' ).'</span>
	</td></tr> 
	
	<tr><td valign="top" colspan="2"><h3>'.__("Left Side Floating Specific Options", 'menu-test' ).'</h3></td></tr>
	
	<tr><td style="padding-bottom:20px;" valign="top">'.__("Left Side Spacing", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;">
	<input type="text" name="twitter_facebook_share_left_space" value="'.$option['left_space'].'" size="10">  
		 <span class="description">'.__("Spacing from Left Side of Margin", 'menu-test' ).'</span>
	</td></tr> 
	
	<tr><td style="padding-bottom:20px;" valign="top">'.__("Top Spacing", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;">
	<input type="text" name="twitter_facebook_share_bottom_space" value="'.$option['bottom_space'].'" size="10">  
		 <span class="description">'.__("Spacing from Top of the page", 'menu-test' ).'</span>
	</td></tr> 
	
	<tr><td style="padding-bottom:20px;" valign="top">'.__("Float Bar Position", 'menu-test' ).':</td>
	<td style="padding-bottom:20px;"><select name="twitter_facebook_share_float_position">
		<option value="fixed" '.$sel_fixed.' > '.__('Fixed Position', 'menu-test' ).'</option>
		<option value="absolute" '.$sel_absolute.' > '.__('Absolute Position', 'menu-test' ).'</option>
		</select>
	</td></tr>
	
	<tr><td valign="top" colspan="2">
	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="'.esc_attr('Save Changes').'" />
	</p>
	</td></tr>

		
	</table>

	</form>
	</div>
	<div style="float:left; margin-top:100px; width:30%;">
	<table>
	<tr><td  align="justify" width="80px">
	<h4>Support the Author</h4>
	<p >If you liked the plugin and was useful to your site then please support to keep this project up and running. Maintenance and enhancement do cost. Show your appreciation and love.</p> </td></tr>
	<tr>
	<td align="centre">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="86FHBFVUYN45J">
	<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
	</form>
	</td>
	</tr>
	</table>
	</div>

	<div style="clear:both;"></div>
	</div>
	';
	echo $out; 
}


// PRIVATE FUNCTIONS

function twitter_facebook_share_get_options_stored () {
	//GET ARRAY OF STORED VALUES
	$option = get_option('twitter_facebook_share');
	 
	if ($option===false) {
		//OPTION NOT IN DATABASE, SO WE INSERT DEFAULT VALUES
		$option = twitter_facebook_share_get_options_default();
		add_option('twitter_facebook_share', $option);
	} else if ($option=='above' or $option=='below') {
		// Versions below 1.2.0 compatibility
		$option = twitter_facebook_share_get_options_default($option);
	} else if(!is_array($option)) {
		// Versions below 1.2.2 compatibility
		$option = json_decode($option, true);
	}
	
	// Versions below 1.5.1 compatibility
	if (!isset($option['bkcolor'])) {
		$option['bkcolor'] = true;
	}
	
	if (!isset($option['auto'])) {
		$option['auto'] = true;
	}
	// Versions below 1.4.1 compatibility
	if (!isset($option['bkcolor_value'])) {
		$option['bkcolor_value'] = '#F0F4F9';
	}
	if (!isset($option['left_space'])) {
		$option['left_space'] = '60px';
	}
	if (!isset($option['bottom_space'])) {
		$option['bottom_space'] = '20%';
	}
	
	if (!isset($option['jsload'])) {
		$option['jsload'] = true;
	}
	
	return $option;
}

function twitter_facebook_share_get_options_default ($position='above', $border='flat', $color='#F0F4F9',$left_space='60px',$bottom_space='40%', $float_position='fixed') {
	$option = array();
	$option['auto'] = true;
	$option['active_buttons'] = array('facebook_like'=>true, 'twitter'=>true, 'stumbleupon'=>true, 'Google_plusone'=>true);
	$option['position'] = $position;
	$option['border'] = $border;
	$option['bkcolor'] = true;
	$option['bkcolor_value'] = $color;
	$option['jsload'] = true;
	$option['left_space'] = $left_space;
	$option['bottom_space'] = $bottom_space;
	$option['float_position'] = $float_position;
	return $option;
}
?>