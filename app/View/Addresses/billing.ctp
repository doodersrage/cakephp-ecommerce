<div class="page-head">
    <h1>Addresses Billing</h1>
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
	<?php echo $this->Form->create('Address'); ?>
        <fieldset>
            <legend><?php echo __('Edit Billing Address'); ?></legend>
        <?php
            echo $this->Form->input('email', array('class'=>'form-control',));
            echo $this->Form->input('firstName', array('class'=>'form-control',));
            echo $this->Form->input('lastName', array('class'=>'form-control',));
            echo $this->Form->input('company', array('class'=>'form-control',));
            echo $this->Form->input('telephone', array('class'=>'form-control',));
            echo $this->Form->input('fax', array('class'=>'form-control',));
            echo $this->Form->input('address', array('class'=>'form-control',));
            echo $this->Form->input('address2', array('class'=>'form-control',));
            echo $this->Form->input('city', array('class'=>'form-control',));
            echo $this->Form->input('state', array('class'=>'form-control','options'=>$states));
            echo $this->Form->input('postalCode', array('class'=>'form-control',));
        ?>
        </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
    </div>
</div>
