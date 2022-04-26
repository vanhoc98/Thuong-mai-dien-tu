<?php 

  // ADD META BOX

function status_event_dropdown(){
    add_meta_box('tinh-trang-dropdown','Trạng thái dropdowns','tg_status_ouput_dropdown','post');
}
add_action('add_meta_boxes','status_event_dropdown');

function tg_status_ouput_dropdown ( $post ) {
?>
          <?php 
        //get dropdown saved value
        $selected = esc_attr(get_post_meta( $post->ID, '_multi_dropdown', true )); 
        ?>
   <select name="multi_dropdown" id="multi_dropdown" >
            <option value="Vẫn đang diễn ra" <?php echo ($selected == "first_choice")?  'selected="selected"' : '' ?>> Vẫn đang diễn ra </option>
            <option value="Hết thời hạn" <?php echo ($selected == "second_choice")?  'selected="selected"' : '' ?>> Hết thời hạn </option>
    </select>
<?php
}

function tg_save($post_id){
  $status_event = sanitize_text_field($_POST['multi_dropdown']);
  update_post_meta( $post_id, '_status_event', $status_event );
}
add_action('save_post','tg_save');

?>