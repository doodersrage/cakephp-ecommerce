<div class="page-head">
    <h1><?php echo h($content['Content']['header']); ?></h1>
</div>

<!--<div class="bread-crumbs">
    <a href="#">Home</a>
</div>-->
<?php
// flash warning message
echo $this->Session->flash();
?>

<div class="home">
	<div class="info-blocks">
        <div class="row">
             <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/21"><?php echo $this->Html->image('/app/webroot/img/home/Glass-Materials-(Home).jpg', array('alt' => 'Glass Materials')); ?></a>
               <a class="hover-text" href="/pages/21">Glass Materials</a>
             </div>
             <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/23"><?php echo $this->Html->image('/app/webroot/img/home/Glass-Wafers-(Home).jpg', array('alt' => 'Glass Wafers')); ?></a>
               <a class="hover-text" href="/pages/23">Glass Wafers</a>
             </div>
            <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/fused-silica-wafers"><?php echo $this->Html->image('/app/webroot/img/home/Silicon-Wafers-(Home).jpg', array('alt' => 'Fused Silica Wafers')); ?></a>
               <a class="hover-text" href="/pages/fused-silica-wafers">Fused Silica Wafers</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/pyrex-rod-tube"><?php echo $this->Html->image('/app/webroot/img/home/Pyrex-Rod-and-Tube-(Home).jpg', array('alt' => 'Pyrex Rod and Tubing')); ?></a>
               <a class="hover-text" href="/pages/pyrex-rod-tube">Pyrex Rod and Tubing</a>
            </div>
            <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/12"><?php echo $this->Html->image('/app/webroot/img/home/Sapphire-Wafers.jpg', array('alt' => 'Sapphire Wafers')); ?></a>
               <a class="hover-text" href="/pages/12">Sapphire Wafers</a>
            </div>
             <div class="col-lg-4 col-md-4">
               <a class="image" href="/pages/optical-glass-products"><?php echo $this->Html->image('/app/webroot/img/home/DSC04657.jpg', array('alt' => 'Glass Tube and Rod')); ?></a>
               <a class="hover-text" href="/pages/optical-glass-products">Miscellaneous</a>
             </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align:center">
            <a href="/pages/optical-glass-products"><?php echo $this->Html->image('/app/webroot/img/Rectangle_3.png', array('alt' => 'view more products')); ?></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8  col-md-8">
            <?php echo $this->Html->image('/app/webroot/img/KW7_3864-2.jpg', array('alt' => 'serious sir looking at wafer')); ?>
        </div>
        <div class="col-lg-4  col-md-4">
            <?php echo $content['Content']['content']; ?>
        </div>
    </div>
</div>