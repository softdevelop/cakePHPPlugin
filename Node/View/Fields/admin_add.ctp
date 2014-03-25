<div id="content-header">
<h1>List Field</h1>
</div>
<div id="breadcrumb">
<a href="<?php echo $this->Html->url('/admin/')?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
<a href="#" class="current">Add Field</a>
</div>
<div class="container-fluid">
<div class="row-fluid">
</div>
<div class="row-fluid">
	<div class="span12">
 <?php
    echo $this->Form->create('Field', array('id' => 'paginate','class'=>'form-horizontal', 'action' => 'edit', 'url' => $this->request->here(false), 'type' => 'post',
        'inputDefaults' => array('label' => false, 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))));
    echo $this->element('toolbar');
    ?>									
		<div class="widget-box">
<?php 
    $fieldsets['type_id'] = $this->Form->input('type_id', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'value' => $type_id,
        'type' => 'hidden'));
        
    $fieldsets['label'] = $this->Form->input('label', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'text'));
        
    $fieldsets['name'] = $this->Form->input('name', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'text'));
        
    $options = array('date' => "Date",'img' => 'Image', 'file' => 'File','text' => 'Text','textarea' => 'Text Area', 'checkbox'=> 'Checkbox');
    $fieldsets['field_type'] = $this->Form->input('field_type', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls controls-large">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'select',
        'options' => $options,
        'escape' => false));        
                        

?>        
        
    <?php
    echo $this->Layout->form($_layouts, $fieldsets);
    ?>
		</div>	
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->end();
    ?>        								
	</div>	
</div>