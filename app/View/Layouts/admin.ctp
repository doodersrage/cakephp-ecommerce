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
    <meta name="robots" content="noindex">
    
	<!-- Le styles -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<style>
	body {
		padding-top: 70px; /* 70px to make the container go all the way to the bottom of the topbar */
	}
	.affix {
		position: fixed;
		top: 60px;
		width: 220px;
	}
	</style>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->css('admin.css');
		echo $this->fetch('script');
	?>
</head>

<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php echo $this->Html->link('CGS', array(
					'controller' => 'pages',
					'action' => 'index'
				), array('class' => 'navbar-brand')); ?>
			</div>
			<?php 
			// enable menu for logged in admin user
			if(isset($role) && $role == 'admin'):
			?>
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
					      Pages <span class="caret"></span>
					    </a>
						<ul class="dropdown-menu">
							<li>
								<?php echo $this->Html->link('List', array(
									'controller' => 'contents',
									'action' => 'index'
								)); ?>
							</li>
							<li><?php echo $this->Html->link('Add', array(
								'controller' => 'contents',
								'action' => 'add'
							)); ?></li>
						</ul>
					</li>
					<!--<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
					      Products <span class="caret"></span>
					    </a>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('List', array(
								'controller' => 'products',
								'action' => 'index'
							)); ?></li>
							<li><?php echo $this->Html->link('Add', array(
								'controller' => 'products',
								'action' => 'add'
							)); ?></li>
						</ul>
					</li>-->
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
					      Product Attributes <span class="caret"></span>
					    </a>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('List', array(
								'controller' => 'productAttributeTypes',
								'action' => 'index'
							)); ?></li>
							<li><?php echo $this->Html->link('Add', array(
								'controller' => 'productAttributeTypes',
								'action' => 'add'
							)); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
					      Product Types <span class="caret"></span>
					    </a>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('List', array(
								'controller' => 'productTypes',
								'action' => 'index'
							)); ?></li>
							<li><?php echo $this->Html->link('Add', array(
								'controller' => 'productTypes',
								'action' => 'add'
							)); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
					      Users <span class="caret"></span>
					    </a>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('List', array(
								'controller' => 'users',
								'action' => 'index'
							)); ?></li>
							<li><?php echo $this->Html->link('Add', array(
								'controller' => 'users',
								'action' => 'add'
							)); ?></li>
							<li><?php echo $this->Html->link('Addresses', array(
								'controller' => 'addresses',
								'action' => 'index'
							)); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
					      Vendors <span class="caret"></span>
					    </a>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('List', array(
								'controller' => 'vendors',
								'action' => 'index'
							)); ?></li>
							<li><?php echo $this->Html->link('Add', array(
								'controller' => 'vendors',
								'action' => 'add'
							)); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
					      Orders <span class="caret"></span>
					    </a>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('List', array(
								'controller' => 'orders',
								'action' => 'index'
							)); ?></li>
						</ul>
					</li>
					<li>
						
					<a href="/users/logout/">Logout</a>
							
					</li>
				</ul>
			</div>
			<?php endif; ?>
		</div>
	</nav>
<?php
// flash warning message
echo $this->Session->flash();
?>
	<div class="container">

		<?php echo $this->fetch('content'); ?>

	</div><!-- /container -->

	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="//google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
	<?php //echo $this->fetch('script'); 
	if(isset($jsIncludes)){
		foreach($jsIncludes as $js){
			echo $this->Html->script($js);
		}
	}

?>

</body>
</html>
