<?php
/**
 * User Information
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="user-info">

	<div class="author-avatar"><?php echo $user->get_profile_picture( null, '270' ); ?></div>

	<div class="user-information">

		<?php
		$lp_info = get_the_author_meta( 'lp_info', $user->user->data->ID );
		?>
		<ul class="thim-author-social">
			<?php if ( isset( $lp_info['facebook'] ) && $lp_info['facebook'] ) : ?>
				<li>
					<a href="<?php echo esc_url( $lp_info['facebook'] ); ?>" class="facebook"><i class="fa fa-facebook"></i></a>
				</li>
			<?php endif; ?>

			<?php if ( isset( $lp_info['twitter'] ) && $lp_info['twitter'] ) : ?>
				<li>
					<a href="<?php echo esc_url( $lp_info['twitter'] ); ?>" class="twitter"><i class="fa fa-twitter"></i></a>
				</li>
			<?php endif; ?>

			<?php if ( isset( $lp_info['google'] ) && $lp_info['google'] ) : ?>
				<li>
					<a href="<?php echo esc_url( $lp_info['google'] ); ?>" class="google-plus"><i class="fa fa-google-plus"></i></a>
				</li>
			<?php endif; ?>

			<?php if ( isset( $lp_info['linkedin'] ) && $lp_info['linkedin'] ) : ?>
				<li>
					<a href="<?php echo esc_url( $lp_info['linkedin'] ); ?>" class="linkedin"><i class="fa fa-linkedin"></i></a>
				</li>
			<?php endif; ?>

			<?php if ( isset( $lp_info['youtube'] ) && $lp_info['youtube'] ) : ?>
				<li>
					<a href="<?php echo esc_url( $lp_info['youtube'] ); ?>" class="youtube"><i class="fa fa-youtube"></i></a>
				</li>
			<?php endif; ?>
		</ul>
		<?php 
		 
          $user_id = $user->user->data->ID;
		  $user_info = get_userdata($user_id);
          $first_name =  get_user_meta($user_id, 'billing_first_name', true);
          $last_name =  get_user_meta($user_id, 'billing_last_name', true);
          $email =   $user_info->user_email;
		  $user_login =   $user_info->user_login;
          $telephone=  get_user_meta($user_id, 'billing_phone', true);
		  $lineID =  get_user_meta($user_id, 'lineid', true);
		  $user_info = get_userdata($user_id);

		  if(!empty($first_name)){
			  $name = $first_name.' '.$last_name;
		  }else{
			  $name = 'กรุณาระบุชื่อของคุณ';
		  }
		  
		  if(!empty($telephone)){
			  $phone = $telephone;
		  }else{
			  $phone = 'กรุณาระบุเบอร์โทรศัพท์';
		  }
		  
		  if(!empty($lineID)){
			  $line = $lineID;
		  }else{
			  $line = 'กรุณาระบุ LINE ID';
		  }

		?>
		 <div class="user_info name">
		  <span class="strong">ชื่อ-สกุล :</span>
          <span><?php echo $name ?></span>
         </div>
        <div class="user_info email">
        	<span class="strong">อีเมล์ :</span>
        	<span><?php echo $email ?></span>
        </div>
        <div class="user_info telephone">
        	<span class="strong">เบอร์โทรศัพท์ :</span>
        	<span><?php echo $phone ?></span>
        </div>
		<div class="user_info line">
        	<span class="strong">LINE ID :</span>
        	<span><?php echo $line ?></span>
        </div>
		<p><?php echo get_user_meta( $user->user->data->ID, 'description', true ); ?></p>
		
	</div>
</div>

