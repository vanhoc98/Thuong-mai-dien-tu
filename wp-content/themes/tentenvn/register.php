<?php  
/* 
Template Name: page-template-dangky 
*/  
session_start();
global $wpdb;  
get_header();  
?>

<div id="content">
    <div class="container">
       <h2>đăng ký</h2>
       <div class="wrap_register">
         <?php
         if($_POST['submit-register']) {
            $username = $wpdb->escape($_POST['txtusername']);
            $_SESSION['txtusername'] = $username;
            $email = $wpdb->escape($_POST['txtemail']);
            $password = $wpdb->escape($_POST['txtpassword']);
            $c_password = $wpdb->escape($_POST['confirm_password']);
            $error = array();

        // Tên
            if(strpos($username,' ')!== FALSE){
                $error['username_space'] = 'Tên có chứa khoảng trắng';
            }
            if(empty($username)){
                $error['username_empty'] = 'Phần tên không được để trống';
            }
            if(username_exists($username)){
                $error['username_exists'] = 'Tên này đã được sử dụng';
            }

        // Email
            if(!is_email($email)){
                $error['email_valid'] = 'Email không hợp lệ';
            }
            if(empty($email)){
                $error['email_empty'] = 'Email không được để trống';
            }
            if(email_exists($email)){
                $error['email_existence'] = 'Email đã được sử dụng';
            }

        // Mật khẩu
            if(empty($password)){
                $error['password_empty'] = 'Mật khẩu không được để trống';
            }
            if(strcmp($password, $c_password) !==0){
                $error['password'] = 'Mật khẩu không trùng khớp ';
            }
            if(count($error)==0){
                ?>  
                <?php
                 wp_create_user($username,$password,$email);
                 wp_redirect(get_site_url().'/tai-khoan'); exit;
            }
            else{
                if (count($error)) {
                    ?> <ul class="list_errors"> <?php
                    foreach ($error as $e) {
                        echo '<li>'.$e.' </li>' ;
                    }
                    ?> </ul> <?php
                }
            }
        }

        ?>

        <form id="wp_signup_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">  
            <?php //print_r($error);?>
            <div class="form-row">
               <label for="username">Tên</label>  
               <input type="text" name="txtusername" id="username" value="<?= $_REQUEST['txtusername'] != ''  ? $_REQUEST['txtusername'] : '' ?>"> 
           </div>
           <div class="form-row">
            <label for="email">Email</label>  
            <input type="text" name="txtemail" id="email" value="<?= $_REQUEST['txtemail'] != ''  ? $_REQUEST['txtemail'] : '' ?>">   
        </div>
        <div class="form-row">
            <label for="password">Mật khẩu</label>  
            <input type="password" name="txtpassword" id="password"> 
        </div>
        <div class="form-row">
            <label for="password_confirmation">Xác nhận mật khẩu</label>  
            <input type="password" name="confirm_password" id="password_confirmation">  
        </div>
        <input type="submit" id="submitbtn" name="submit-register" value="Sign Up" />  

    </form> 
</div>

</div>
</div>


<?php get_footer(); ?>