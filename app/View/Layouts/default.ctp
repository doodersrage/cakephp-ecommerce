<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		Custom Glass and Silicon -
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->css('b006cd3f.main.css');
        echo $this->Html->css('custom.css');
		echo $this->fetch('script');
		echo $this->Html->script('fbe20327.modernizr.js');
	?>
</head>

<body>
	<!--[if lt IE 10]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="container">
            <div class="row header">
                        <a title="custom silicon and glass logo image" href="/"><?php echo $this->Html->image('cgs-logo.png',array('id'=>'logo','alt'=>'custom silicon and glass logo image')); ?></a>
                <div class="row">
                    <div class="col-lg-12 head-contact">
                        <p>757.888.1361<br>
                        <a style="color:#fff" href="mailto:INFO@COMPANYNAME.COM">INFO@COMPANYNAME.COM</a></p>
                        <?php
						$cart = $this->Session->read('User.Cart');
						if(!empty($cart)){
							?>
							<p><a title="custom silicon and glass checkout icon" href="/cart"><?php echo $this->Html->image('cart.png',array('alt'=>'custom silicon and glass cart icon')); ?></a></p>
                            <?php
						}
						// print account info options
						if(!empty($userId)){
						?>
						<p>
                        <b>User Menu:</b><br>
                        <a  href="/users/edit/<?php echo $userId; ?>">Edit Account</a><br>
                        <a href="/addresses">Edit Stored Addresses</a><br>
                        <a href="/orders">View Previous Orders</a><br>
                        <a href="/users/logout">Logout</a>
                        </p>
						<?php
						} else {
						?>
                        <p>
                        <a href="/users/add">Create Account</a><br>
                        <a href="/users/login">Login</a>
                        </p>
						<?php
						}
						?>
                    </div>      
                </div>          
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-lg-offset-6 col-md-offset-6 top-nav">
                        <?= $this->element('menus/main'); ?>
                    </div>
                </div>
            </div>

            <?php 
			// page body content
			echo $this->fetch('content'); ?>
            
            <div class="footer">
                <p>&copy; Copyright <?php echo date('Y'); ?> Custom Glass and Silicon. All Rights Reserved.</p>
            </div>

        </div>


	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
    <?php echo $this->Html->script('4776dee8.vendor.js'); ?>
    <?php echo $this->Html->script('6b5da0e8.plugins.js'); ?>
    <?php echo $this->Html->script('d2f5b2af.main.js'); ?>
	<?php echo $this->fetch('script'); ?>
    <?php
	if(isset($jsIncludes)){
		foreach($jsIncludes as $js){
			echo $this->Html->script($js);
		}
	}
	?>

</body>
</html>
