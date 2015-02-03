<div class="page-head">
    <h1><?php echo h($content['Content']['header']); ?></h1>
</div>

<div class="bread-crumbs">
    <a href="#">Home</a>
</div>
<?php
// flash warning message
echo $this->Session->flash();
?>

<div class="home">
	<div class="info-blocks">
        <div class="row">
             <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/7"><?php echo $this->Html->image('/app/webroot/img/20131024-KW7_3779-Edit.jpg', array('alt' => 'Glass Wafers')); ?></a>
               <a class="hover-text" href="/pages/7">Glass Wafers</a>
             </div>
             <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/products"><?php echo $this->Html->image('/app/webroot/img/20131024-KW7_3824-Edit.jpg', array('alt' => 'CakePHP')); ?></a>
               <a class="hover-text" href="/pages/products">Glass Wafers</a>
             </div>
             <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/10"><?php echo $this->Html->image('/app/webroot/img/KW7_3798.jpg', array('alt' => 'Glass Tube and Rod')); ?></a>
               <a class="hover-text" href="/pages/10">Glass Tube and Rod</a>
             </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/products"><?php echo $this->Html->image('/app/webroot/img/KW7_3820-Edit.jpg', array('alt' => 'CakePHP')); ?></a>
               <a class="hover-text" href="/pages/products">Glass Wafers</a>
            </div>
            <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/products"><?php echo $this->Html->image('/app/webroot/img/KW7_3810.jpg', array('alt' => 'CakePHP')); ?></a>
               <a class="hover-text" href="/pages/products">Glass Wafers</a>
            </div>
            <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/products"><?php echo $this->Html->image('/app/webroot/img/KW7_3801.jpg', array('alt' => 'CakePHP')); ?></a>
               <a class="hover-text" href="/pages/products">Glass Wafers</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align:center">
            <a href="/pages/products"><?php echo $this->Html->image('/app/webroot/img/Rectangle_3.png', array('alt' => 'view more products')); ?></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8  col-md-8">
            <?php echo $this->Html->image('/app/webroot/img/KW7_3864-2.jpg', array('alt' => 'serious sir looking at wafer')); ?>
        </div>
        <div class="col-lg-4  col-md-4">
            <?php echo $content['Content']['content']; ?>
            <?php echo $this->Html->image('/app/webroot/img/KW7_3225.jpg', array('alt' => 'CakePHP')); ?>
        </div>
    </div>
</div>