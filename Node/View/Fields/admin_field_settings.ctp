<?php 
    switch ($this->request->data['Field']['field_type']){
        case 'text': {
?>
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
    echo $this->Form->create('Field', array('id' => 'paginate','class'=>'form-horizontal' ,'action' => 'edit_field_settings', 'url' => $this->request->here(false), 'type' => 'post',
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
        'type' => 'hidden'));
                    
    $fieldsets['label'] = $this->Form->input('label', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'text'));
        
    $fieldsets['is_requied'] = $this->Form->input('is_requied', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'checkbox'));
        
    $options = array('varchar' => "Text field", 'text' => 'Long text');
    $fieldsets['type_of_content'] = $this->Form->input('type_of_content', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'select',
        'options' => $options,
        'escape' => false));
        
    $fieldsets['maxlength'] = $this->Form->input('maxlength', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'text'));
                        

?>        
        
    <?php
    $layout = array(
        array(
            'Basic setting',
            array(
                array('type_id'),
                array('label', 'is_requied')
            )
        ),
        array(
            'Content field setting',
            array(
                array('type_of_content', 'maxlength')
            )
        )
    );
    echo $this->Layout->form($layout, $fieldsets);
    ?>
		</div>	
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->end();
    ?>        								
	</div>	
</div>
<?php
            break;
        }
        case 'date':{
?>
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
    echo $this->Form->create('Field', array('id' => 'paginate','class'=>'form-horizontal' ,'action' => 'edit_field_settings', 'url' => $this->request->here(false), 'type' => 'post',
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
        'type' => 'hidden'));
        
    $fieldsets['label'] = $this->Form->input('label', array(
          'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'text'));
        
    $fieldsets['is_requied'] = $this->Form->input('is_requied', array(
         'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'checkbox'));
                        

?>        
        
        <?php
        $layout = array(
            array(
                'Basic setting',
                array(
                    array('type_id'),
                    array('label', 'is_requied')
                )
            )   
        );
        echo $this->Layout->form($layout, $fieldsets);
        ?>
		</div>	
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->end();
    ?>        								
	</div>	
</div>
<?php
            break;
        }
        case 'term':{
?>
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
    echo $this->Form->create('Field', array('id' => 'paginate','class'=>'form-horizontal' ,'action' => 'edit_field_settings', 'url' => $this->request->here(false), 'type' => 'post',
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
        'type' => 'hidden'));
        
    $fieldsets['label'] = $this->Form->input('label', array(
         'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'text'));
        
    $fieldsets['is_requied'] = $this->Form->input('is_requied', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'checkbox'));
        
    //$options = array('varchar' => "Text field", 'text' => 'Long text');
    $fieldsets['type_of_term'] = $this->Form->input('type_of_term', array(
         'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'select',
        'options' => $list_types,
        'escape' => false));
        
    $options = array('1' => "1", '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', 'unlimit' => 'Unlimited');
    $fieldsets['num_of_value'] = $this->Form->input('num_of_value', array(
         'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'select',
        'options' => $options,
        'escape' => false));
                        

?>        
        
        <?php
        $layout = array(
            array(
                'Basic setting',
                array(
                    array('type_id'),
                    array('label', 'is_requied')
                )
            ),
            array(
                'Category field setting',
                array(
                    array('type_of_term', 'num_of_value'),
                )
            )
        );
        echo $this->Layout->form($layout, $fieldsets);
        ?>
		</div>	
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->end();
    ?>        								
	</div>	
</div>
<?php   
            break;
        }
        default:{
?>
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
    echo $this->Form->create('Field', array('id' => 'paginate','class'=>'form-horizontal' ,'action' => 'edit_field_settings', 'url' => $this->request->here(false), 'type' => 'post',
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
        'type' => 'hidden'));
        
    $fieldsets['label'] = $this->Form->input('label', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'text'));
        
    $fieldsets['is_requied'] = $this->Form->input('is_requied', array(
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' => 'control-group'),
        'after' => '</div>',
        'type' => 'checkbox'));
        
    $fieldsets['use_wyswyg'] = $this->Form->input('use_wyswyg', array(
        'label' => array('text'=>'Are you use wysiwyg ?','class' => 'control-label'),
        'between' => '<div class="controls">',
        'div' => array('class' =>'control-group'),
        'after' => '</div>',
        'type' => 'checkbox'));
        

?>        
        
        <?php
        $layout = array(
            array(
                'Basic setting',
                array(
                    array('type_id'),
                    array('label', 'is_requied')
                )
            ),
            array(
                'File field setting',
                array(
                    array('use_wyswyg'),
                )
            )
        );
        echo $this->Layout->form($layout, $fieldsets);
        ?>
		</div>	
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->end();
    ?>        								
	</div>	
</div>
<?php
        }
    }
            
?>
