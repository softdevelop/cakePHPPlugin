<div id="content-header">
<h1>List Categories</h1>
</div>
<div id="breadcrumb">
<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-th-list"></i> Home</a>
<a href="#" class="current">Dashboard</a>
</div>
<div class="container-fluid">
<div class="row-fluid">
</div>
<div class="row-fluid">
	<div class="span12">
 <?php
    echo $this->Form->create('NodeType', array('id' => 'paginate','class'=>'form-horizontal', 'action' => 'edit', 'url' => $this->request->here(false), 'type' => 'post',
        'inputDefaults' => array('label' => false, 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))));
    echo $this->element('toolbar');
    ?>									
		<div class="widget-box">
<?php 
    $fieldsets['name'] = $this->Form->input('name', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'text'));

    $fieldsets['enabled'] = $this->Form->input('enabled', array(
            'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'checkbox'));
        
    $fieldsets['description'] = $this->Form->input('description', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'textarea'));         
                        

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