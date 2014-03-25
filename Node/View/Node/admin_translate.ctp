<div id="content-header">
<h1>Translate Content</h1>
</div>
<div id="breadcrumb">
<a href="<?php echo $this->Html->url('/admin/')?>" title="Go to Home" class="tip-bottom"><i class="icon-th-list"></i> Home</a>
<a href="<?php echo $this->Html->url(array('plugin'=>'node','controller' => 'node', 'action' => 'admin_index'));?>" class="current">Translate Contents</a>
</div>
<div class="container-fluid">
<div class="row-fluid">
	<div class="span12">
    <?php
    echo $this->Html->script('ckeditor/ckeditor');
    echo $this->element('toolbar');
    echo $this->Form->create('Node', array('id' => 'paginate','class'=>'form-horizontal', 'action' => 'translate', 'url' => $this->request->here(false), 'type' => 'post',
        'inputDefaults' => array('label' => false, 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))));
    ?>									
		<div class="widget-box wd-widget-border">

            <?php 
                $format = '<div class="translate-wrapper">
                                        %s
                                        <div class="toggle-content">%s</div>
                              </div>
                              <div class="translate-input">%s</div>';
                $original = '';
                $translation = __d('system', 'Translation');
   
                if (isset($_translateFields['title'])) {
                    $layout[] = array(__d('system', '%s translation', __d('system', 'Title')), array('title'));
                    $fieldsets['title'] = sprintf($format
                            , $original
                            , $node['Node']['title']
                            , $this->Form->input('title', array('value' => $node['title'], 'type' => 'text', 
                                   'label' => array('text'=>$translation,'class' => 'control-label'),
                                    'between' => '<div class="controls">',
                                    'div' => array('class' => 'control-group'),
                                    'after' => '</div>',
                            
                            
                            )));
        
                }
                if (isset($_translateFields['field_description'])) {
                    $layout[] = array(__d('system', '%s translation', __d('system', 'Description')), array('field_description'));
                    $fieldsets['field_description'] = sprintf($format
                            , $original
                            , $node['Node']['field_description']
                            , $this->Form->input('field_description', array('value' => $node['field_description'], 'type' => 'textarea', 
                            'label' => array('text'=>$translation,'class' => 'control-label'),
                            'between' => '<div class="controls">',
                            'div' => array('class' => 'control-group'),
                            'after' => '</div>')));
                }  
                
                  if (isset($_translateFields['field_body'])) {
                    $layout[] = array(__d('system', '%s translation', __d('system', 'Body')), array('field_body'));
                    $fieldsets['field_body'] = sprintf($format
                            , $original
                            , $node['Node']['field_body']
                            , $this->Form->input('field_body', array(
                                    'value' => $node['field_body'], 
                                    'type' => 'textarea','class' => 'ckeditor',
                                    'label' => array('text'=>$translation,'class' => 'control-label'),
                                    'between' => '<div class="controls">',
                                    'div' => array('class' => 'control-group'),
                                    'after' => '</div>',)));
                }  
                ?>


              <?php
            echo $this->Layout->form($layout, $fieldsets);
            ?>          
		</div>
        	
        
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->end();
    ?>								
	</div>	
</div>