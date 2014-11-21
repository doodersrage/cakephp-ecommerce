<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		BoostCake -
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
	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->css('b006cd3f.main.css');
		echo $this->fetch('script');
		echo $this->Html->script('fbe20327.modernizr.js');;
	?>
</head>

<body>
	<!--[if lt IE 10]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="container">
            <div class="row header">
                <div class="col-lg-6">
                    <a href="#"><?php echo $this->Html->image('e6de4c3b.cgs-logo.png'); ?></a>
                </div>
                <div class="col-lg-6 top-nav">
                	<?= $this->element('menus/main'); ?>
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Products</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>

                </div>
                <div class="col-lg-12 head-contact">
                    <p>757.888.1361<br>
                    INFO@COMPANYNAME.COM</p>
                </div>                
            </div>


            <div class="page-head">
                <h1>A tag line of some sort can go here.</h1>
            </div>

            <div class="bread-crumbs">
                Home / Main Item / <a href="#">Sub Item</a>
            </div>

            <div class="row marketing">
                <div class="col-lg-3 prod-image">
                    <?php echo $this->Html->image('0b7fa982.wafer.jpg'); ?>
                </div>
                <div class="col-lg-9">
                    <h2>Glass Wafers</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt

                     <p>ut labore et dolore magna aliqua. Ut enim ad minim veniam, 

                    <p>quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore 

                    <p>eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>

                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <table>
                            <tr>
                                <th>Material</th>
                                <th>Size (MM)</th>
                                <th>Thickness (MM)</th>
                                <th>Quality</th>
                                <th>Quantity</th>
                                <th>Price Each</th>
                                <th class="lw">More<br>info</th>
                                <th class="lw">Qty</th>
                                <th class="lw">Total</th>
                            </tr>
                            <tr>
                                <td>Eagle XG</td>
                                <td>100 x 100</td>
                                <td>0.50</td>
                                <td>60/40</td>
                                <td>82</td>
                                <td class="cost-clm">$12.00</td>
                                <td><a href="#" data-toggle="popover" data-content="<b>TTY:</b> 2um<br><b>Orientation:</b> EMI Flat<br><b>Thickness Tol:</b> +_ 25um<br><b>Dimensional Tol</b>: +/- 20um">hover</a></td>
                                <td class="qty-clm"><input type="number" name="qty[]"></td>
                                <td class="ttl-clm"></td>
                            </tr>
                            <tr>
                                <td>Borofloat</td>
                                <td>150mm Ø</td>
                                <td>0.70</td>
                                <td>20/10</td>
                                <td>36</td>
                                <td class="cost-clm">$23.50</td>
                                <td><a href="#" data-toggle="popover" data-content="<b>TTY:</b> 2um<br><b>Orientation:</b> EMI Flat<br><b>Thickness Tol:</b> +_ 25um<br><b>Dimensional Tol</b>: +/- 20um">hover</a></td>
                                <td class="qty-clm"><input type="number" name="qty[]"></td>
                                <td class="ttl-clm"></td>
                            </tr>
                            <tr>
                                <td>Eagle XG</td>
                                <td>200mm Ø</td>
                                <td>0.30</td>
                                <td>80/50</td>
                                <td>123</td>
                                <td class="cost-clm">$18.25</td>
                                <td><a href="#" data-toggle="popover" data-content="<b>TTY:</b> 2um<br><b>Orientation:</b> EMI Flat<br><b>Thickness Tol:</b> +_ 25um<br><b>Dimensional Tol</b>: +/- 20um">hover</a></td>
                                <td class="qty-clm"><input type="number" name="qty[]"></td>
                                <td class="ttl-clm"></td>
                            </tr>
                            <tr>
                                <td>Soda Lime</td>
                                <td>76.2mm Ø</td>
                                <td>1.10</td>
                                <td>20/10</td>
                                <td>15</td>
                                <td class="cost-clm">$21.50</td>
                                <td><a href="#" data-toggle="popover" data-content="<b>TTY:</b> 2um<br><b>Orientation:</b> EMI Flat<br><b>Thickness Tol:</b> +_ 25um<br><b>Dimensional Tol</b>: +/- 20um">hover</a></td>
                                <td class="qty-clm"><input type="number" name="qty[]"></td>
                                <td class="ttl-clm"></td>
                            </tr>
                            <tr>
                                <td>Fused Silica</td>
                                <td>150mm Ø</td>
                                <td>0.75</td>
                                <td>40/20</td>
                                <td>68</td>
                                <td class="cost-clm">$32.10</td>
                                <td><a href="#" data-toggle="popover" data-content="<b>TTY:</b> 2um<br><b>Orientation:</b> EMI Flat<br><b>Thickness Tol:</b> +_ 25um<br><b>Dimensional Tol</b>: +/- 20um">hover</a></td>
                                <td class="qty-clm"><input type="number" name="qty[]"></td>
                                <td class="ttl-clm"></td>
                            </tr>
                            <tr>
                                <td>Soda Lime</td>
                                <td>152 x 152</td>
                                <td>2.00</td>
                                <td>60/40</td>
                                <td>21</td>
                                <td class="cost-clm">$12.90</td>
                                <td><a href="#" data-toggle="popover" data-content="<b>TTY:</b> 2um<br><b>Orientation:</b> EMI Flat<br><b>Thickness Tol:</b> +_ 25um<br><b>Dimensional Tol</b>: +/- 20um">hover</a></td>
                                <td class="qty-clm"><input type="number" name="qty[]"></td>
                                <td class="ttl-clm"></td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-lg-offset-10 col-lg-2">
                        <p>Total: <span id="total"></span></p>
                        <button type="submit">Check Out</button>
                    </div>
                </div>

                <?php echo $this->fetch('content'); ?>

            </div>

            <div class="footer">
                <p>&copy; Copyright 2014 Custom Glass and Silicon. All Rights Reserved.</p>
            </div>



        </div>


	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="//google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
	<?php echo $this->fetch('script'); ?>

</body>
</html>
