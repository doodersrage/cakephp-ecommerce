<div class="col-lg-12 users form">
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
</div>