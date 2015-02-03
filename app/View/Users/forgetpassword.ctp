<div class="page-head">
    <h1>Forget Password</h1>
</div>

<div class="bread-crumbs">
    <a href="#">Home</a>
</div>
<?php
// flash warning message
echo $this->Session->flash();
?>

<div class="row marketing">
    <div class="row" style="padding:20px">
	<?php echo $this->Form->create('User'); ?>
        <fieldset>
        <p>Enter your email and username to reset your password.</p>
        <?php
            echo $this->Form->input('email', array('class'=>'form-control'));
            echo $this->Form->input('username', array('class'=>'form-control'));
        ?>
        </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
	</div>
</div>