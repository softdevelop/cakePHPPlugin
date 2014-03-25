<div id="content-header">
<h1>Edit content</h1>
</div>
<div id="breadcrumb">
<a href="<?php echo $this->Html->url('/admin/')?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
<a href="#">Edit</a>
<a href="#" class="current"><?php echo $datas['Node']['title']?></a>
</div>
<div class="container-fluid">

<div class="row-fluid">
	<div class="span12">
 <?php
    echo $this->Form->create('Node', array('id' => 'paginate','class'=>'form-horizontal', 'action' => 'edit', 'url' => $this->request->here(false), 'type' => 'file',
        'inputDefaults' => array('label' => false, 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))));

    echo $this->Html->script('ckeditor/ckeditor');
    echo $this->element('toolbar');
    ?>									
		<div class="widget-box">

            <?php 
            $fieldsets['user_id'] = $this->Form->input('user_id', array(
                'label' => array('class' => 'control-label'),
                'between' => '<div class="controls">',
                'div' => array('class' => 'control-group'),
                'after' => '</div>',
                'type' => 'hidden'));
            ?>
            <?php 
                $fieldsets['title'] = $this->Form->input('title', array(
                'label' => array( 'text'=> 'Title','class' => 'control-label'),
                'between' => '<div class="controls">',
                'div' => array('class' => 'control-group'),
                'after' => '</div>',
                'type' => 'text'));
                
    
                              
            $fieldsets['node_term_id'] = $this->Form->input('node_term_id', array(
                'label' => array('class' => 'control-label'),
                'between' => '<div class="controls">',
                'div' => array('class' => 'control-group'),
                'after' => '</div>',
                'value' => $nodeTerm['NodeTerm']['id'],
                'type' => 'hidden'));   
                
            $fieldsets['is_published'] = $this->Form->input('is_published', array(
                    'label' => array('text'=> 'Show/Hide','class' => 'control-label'),
                    'between' => '<div class="controls">',
                    'div' => array('class' => 'control-group'),
                    'after' => '</div>',
                    'type' => 'checkbox'));  
                     
                                                                      
            ?>
<?php
    $layout = array(
        array('node_term_id', 'user_id'),
        array('title'),
        array('is_published'),
    );
    foreach ($fields as $field) {
            $type = 'text';
            if ($field['Field']['field_type'] == 'img' || $field['Field']['field_type'] == 'file') {
                $type = 'file';
            }
             if($field['Field']['field_type'] == 'textarea'){
                $type= 'textarea';
            }
            else if($field['Field']['field_type'] == 'checkbox'){
                $type= 'checkbox';
            }
            $chosseckeditor = null;
            
          switch ($field['Field']['use_wyswyg']) {
            case null:
                $chosseckeditor =null;
                break;
            case 0:
                $chosseckeditor =null;
                break;                
            case 1:
            $chosseckeditor = 'ckeditor';
                break;
        } 
        $fieldsets['field_' . $field['Field']['name']] = $this->Form->input('field_' . $field['Field']['name'], array(
            'label' => array('text'=>$field['Field']['label'],'class' => 'control-label'),
            'between' => '<div class="controls">',
            'div' => array('class' => 'control-group'),
            'after' => '</div>',
            'class'=> $chosseckeditor,
            'type' => $type));
        $layout[] = array('field_' . $field['Field']['name']);
    }
            
            $layout = array(
                array(
                    'Basic setting',
                    $layout,
                )
            );
            echo $this->Layout->form($layout, $fieldsets);
    ?>

       
		</div>
    <?php
    echo $this->Form->hidden('node_type_id');
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->end();
    ?>									
	</div>	
</div>
<!--
<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-align-justify"></i>									
				</span>
				<h5>SEO OPTIONS</h5>
			</div>
			<div class="widget-content nopadding">
				<form action="#" method="get" class="form-horizontal" />
					<div class="control-group">
						<label class="control-label">Title</label>
						<div class="controls">
							<input type="text" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Keywords</label>
						<div class="controls">
							<input type="text" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Description</label>
						<div class="controls">
							<textarea></textarea>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
</div>
-->