<div class="page-head">
    <h1>Login</h1>
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
		<?php echo $this->Session->flash('auth'); ?>
        <?php echo $this->Form->create('User', array('role'=>'form')); ?>
            <fieldset>
                <legend>
                    <?php echo __('Please enter your username and password'); ?>
                </legend>
                <div class="form-group">
                <?php echo $this->Form->input('username', array('class'=>'form-control'));
                echo $this->Form->input('password', array('class'=>'form-control'));
                ?></div>
            </fieldset>
        <?php echo $this->Form->end(__('Login')); ?>
        <p style="text-align:center"><strong><a href="/users/forgetpassword/">Forget your password?</a></strong></p>
    </div>
</div>