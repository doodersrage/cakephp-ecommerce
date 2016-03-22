<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		Custom Glass and Optics -
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $description_for_layout; ?>">
	<meta name="author" content="">

	<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-60835000-1', 'auto');
	  ga('send', 'pageview');
	
	</script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <meta name="google-site-verification" content="VIavwIBDTbJZXJNtq1syjce3HI5TX0CI6Qa6_pt1dKs" />
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
                        <a title="custom glass and optics logo image" href="/"><?php echo $this->Html->image('cgs-logo.png',array('id'=>'logo','alt'=>'custom silicon and glass logo image')); ?></a>
                <div class="row">
                    <div class="col-lg-12 head-contact">
                        <p>757.880.9543<br>
                        <a style="color:#fff;text-transform:uppercase" href="mailto:sales@customglassandoptics.com">sales@customglassandoptics.com</a></p>
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
                <p>&copy; Copyright <?php echo date('Y'); ?> Custom Glass and Optics. All Rights Reserved. | <a href="https://customglassandoptics.com/pages/terms-conditions">Terms and Conditions</a></p>
            </div>
<!-- (c) 2005, 2015. Authorize.Net is a registered trademark of CyberSource Corporation --> <div style="bottom:0;position:fixed;_position:absolute;left:0;" class="AuthorizeNetSeal"> <script type="text/javascript" language="javascript">var ANS_customer_id="1f9e9edc-12d2-4fb9-a9f3-1c73366b7de0";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Payment Processing</a> </div>
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
<div id="sitelock_shield_logo" class="fixed_btm" style="bottom:0;position:fixed;_position:absolute;right:0;"><a href="https://www.sitelock.com/verify.php?site=customglassandoptics.com" onclick="window.open('https://www.sitelock.com/verify.php?site=customglassandoptics.com','SiteLock','width=600,height=600,left=160,top=170');return false;" ><img alt="PCI Compliance and Malware Removal" title="SiteLock" src="//shield.sitelock.com/shield/customglassandoptics.com"></a></div>
</body>
</html>
