<?php
/*
Plugin Name: Point Blank Super Recent Posts Widget
Plugin URI: http://www.pointblank.ie
Description: A Recent Posts Widget that can be filtered by pbsrc_category , shows date and optionally shows the excerpt. The amount of words shown by the excerpt can also be set.
Author: Dom Muldoon for Point Blank.
Version: v1.0
Author URI: http://www.pointblank.ie

Copyright 2012  Dom Muldoon for Point Blank  (email : info@pointblank.ie)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



class PointBlankSuperRecentPosts extends WP_Widget
{
 /**
  * Declares the Super Recent Posts class.
  *
  */
function PointBlankSuperRecentPosts() {
    
	$widget_ops = array('classname' => 'widget_PointBlankSuperRecentPosts', 'description' => __( "Recent Posts With excerpt,date and pbsrc_category") );
    $control_ops = array('width' => 250, 'height' => 250);
    $this->WP_Widget('PointBlankSuperRecentPosts', __('Point Blank Super Recent Posts'), $widget_ops, $control_ops);

}

/**
* Displays the Widget
*
*/
	
function widget($args, $instance){
      extract($args);
	  
      $pbsrc_title = apply_filters('widget_pbsrc_title', empty($instance['pbsrc_title']) ? '&nbsp;' : $instance['pbsrc_title']);
	  
      $pbsrc_numberofposts = empty($instance['pbsrc_numberofposts']) ? '10' : $instance['pbsrc_numberofposts'];
     
	  $pbsrc_dateformat = empty($instance['pbsrc_dateformat']) ? 'World' : $instance['pbsrc_dateformat'];
	  
	  $pbsrc_category = empty($instance['pbsrc_category']) ? 'World' : $instance['pbsrc_category'];
	  
	  $pbsrc_useexcerpt = empty($instance['pbsrc_useexcerpt']) ? 'World' : $instance['pbsrc_useexcerpt'];
	  
	  $pbsrc_excerptlength = empty($instance['pbsrc_excerptlength']) ? 'World' : $instance['pbsrc_excerptlength'];

      # Before the widget
      echo $before_widget;

      # The pbsrc_title
      if ( $pbsrc_title ) { 
	  
	  $pbsrc_title = ''.$pbsrc_title.'';
	  
      echo $before_pbsrc_title . $pbsrc_title . $after_pbsrc_title;
	  }
      # Make the  widget
     // echo '<div style="text-align:center;padding:10px;">' . $pbsrc_numberofposts . '<br />' . $pbsrc_dateformat . "</div>";
		
		global $post;
       
	   	$args = array( 'numberposts' => $pbsrc_numberofposts, 'cat' => $pbsrc_category );
		
		$lastposts = get_posts( $args );
	
		echo '<ul>';
			
			foreach($lastposts as $post) : setup_postdata($post); 
		
				echo '<li>'; ?>
				
						<?php //echo $post->permalink; ?><?php //echo $post->post_pbsrc_title; ?>
    
    					<h6><a href="<?php the_permalink(); ?>" pbsrc_title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>
       	
        				<span><?php the_time(''.$pbsrc_dateformat.'') ?></span>
     
     					
     
     
	 					 <?php  if (strtolower($pbsrc_useexcerpt) == "yes") { ?>
						
						 <?php
						
						 $words = explode(' ', get_the_excerpt());

    echo  implode( ' ', array_slice($words, 0, $pbsrc_excerptlength) );

 
					?>
                         <?php } ?>
   
				<?php echo '</li>'; ?>
   
			<?php endforeach; 
		
		echo '<li class="view-all"><a href="news" pbsrc_title="view all">view all</a></li></ul>';


      # After the widget
      echo $after_widget;
}

/**
* Saves the widgets settings.
*
*/

function update($new_instance, $old_instance){
      
	  $instance = $old_instance;
      $instance['pbsrc_title'] 			= strip_tags(stripslashes($new_instance['pbsrc_title']));
      $instance['pbsrc_numberofposts'] 	= strip_tags(stripslashes($new_instance['pbsrc_numberofposts']));
      $instance['pbsrc_dateformat'] 	= strip_tags(stripslashes($new_instance['pbsrc_dateformat']));
	  $instance['pbsrc_category'] 		= strip_tags(stripslashes($new_instance['pbsrc_category']));
	  $instance['pbsrc_useexcerpt'] 	= strip_tags(stripslashes($new_instance['pbsrc_useexcerpt']));
	  $instance['pbsrc_excerptlength'] 	= strip_tags(stripslashes($new_instance['pbsrc_excerptlength']));

    return $instance;
}

  
/**
* Creates the edit form for the widget.
*
*/
    
function form($instance){
      
	  //Defaults
      $instance = wp_parse_args( (array) $instance, array('pbsrc_title'=>'', 'pbsrc_numberofposts'=>'', 'pbsrc_dateformat'=>'', 'pbsrc_category'=>'','pbsrc_useexcerpt'=>'','pbsrc_excerptlength'=>'' ) );

      $pbsrc_title 			= htmlspecialchars($instance['pbsrc_title']);
      $pbsrc_numberofposts 			= htmlspecialchars($instance['pbsrc_numberofposts']);
      $pbsrc_dateformat 			= htmlspecialchars($instance['pbsrc_dateformat']);
	  $pbsrc_category 		= htmlspecialchars($instance['pbsrc_category']);
	  $pbsrc_useexcerpt 		= htmlspecialchars($instance['pbsrc_useexcerpt']);
	  $pbsrc_excerptlength 	= htmlspecialchars($instance['pbsrc_excerptlength']);
     
	  # Output the options
	  //Title of plugin
	  
      echo '<p><label for="' . $this->get_field_name('pbsrc_title') . '">' . __('Title:') . '</label></p> <p><input style="width: 200px;" id="' . $this->get_field_id('pbsrc_title') . '" name="' . $this->get_field_name('pbsrc_title') . '" type="text" value="' . $pbsrc_title . '" /></p>';
      
	  # Number of posts
	  
      echo '<p><label for="' . $this->get_field_name('pbsrc_numberofposts') . '">' . __('Number of Posts:') . '</p><p> <input style="width: 200px;" id="' . $this->get_field_id('pbsrc_numberofposts') . '" name="' . $this->get_field_name('pbsrc_numberofposts') . '" type="text" value="' . $pbsrc_numberofposts . '" /></label></p>';
      
	  # Date format
	  
      echo '<p><label for="' . $this->get_field_name('pbsrc_dateformat') . '">' . __('Date Format:');
	   ?></label></p><p>
	   <select id="<?php echo $this->get_field_id('pbsrc_dateformat');?>" name="<?php echo  $this->get_field_name('pbsrc_dateformat');?>">
  		<option value="d/m/y"   <?php if($pbsrc_dateformat == "d/m/y") { ?>SELECTED<? } ;?>>eg 31/12/99</option>
    	<option value="d, M, Y" <?php if($pbsrc_dateformat == "d, M, Y") { ?>SELECTED<? } ;?>>eg 31, Dec, 2099</option>
  		<option value="m/d/y"   <?php if($pbsrc_dateformat == "m/d/y") { ?>SELECTED<? } ;?>>eg 12/31/99</option>
 		<option value="M, d, Y" <?php if($pbsrc_dateformat == "M, d, Y") { ?>SELECTED<? } ;?>>eg Dec, 31, 2099</option>
	</select> 
	   
	<?php  echo '</p>'; ?>
	  
	  
  
	<?php # Category

       echo '<p><label for="' . $this->get_field_name('pbsrc_category') . '">' . __('Category:').'</label></p><p>'; 
	   wp_dropdown_categories('show_count=1&hierarchical=1&selected='.$pbsrc_category.'&name=' . $this->get_field_name('pbsrc_category') . '&id=' . $this->get_field_id('pbsrc_dateformat').'&show_option_all=All'); 
	   echo '</p>';
	  
	 
	  
	  # Use excerpt?
	?>
     <p><label for="<?php echo $this->get_field_name('pbsrc_useexcerpt');?>"><?php echo __('Show Excerpt?:') ;?></label></p><p> <input type="checkbox"   id="<?php echo  $this->get_field_id('pbsrc_useexcerpt');?>" name="<?php echo $this->get_field_name('pbsrc_useexcerpt');?>"  value="yes" <?php if(strtolower($pbsrc_useexcerpt) == "yes") { ?> checked="yes" <?php } ?> /></p>
     
     
	<?php
		// excerpt length
		
     echo '<p><label for="' . $this->get_field_name('pbsrc_excerptlength') . '">' . __('Excerpt Word Length:') . '</label></p> <p><input style="width: 200px;" id="' . $this->get_field_id('pbsrc_excerptlength') . '" name="' . $this->get_field_name('pbsrc_excerptlength') . '" type="text" value="' . $pbsrc_excerptlength . '" /></p>'; 
	 
	 ?>
 
<?php
 
} // End Form
  
}// END class

/**
  * Register Hello World widget.
  *
  * Calls 'widgets_init' action after the Point Blank Super Recent Posts widget has been registered.
  */
  function PointBlankRecentPostsWithBodyInit() {
  register_widget('PointBlankSuperRecentPosts');
  }
  add_action('widgets_init', 'PointBlankRecentPostsWithBodyInit');
?>