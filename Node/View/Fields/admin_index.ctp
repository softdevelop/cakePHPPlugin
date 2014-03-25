<?php
$this->Paginator->options(array('url' => array('ext' => false, '?' => $this->request->query)));
?>
<div id="content-header">
	<h1>List Field</h1>
</div>
<div id="breadcrumb">
	<a href="<?php echo $this->Html->url('/admin/')?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    	<a href="#" class="current">List Field</a>

</div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
            <?php
            echo $this->element('toolbar');
            ?>	
            
    <?php  echo $this->Form->create('Paginate', array('id' => 'paginate', 'url' => $this->request->here(false), 'type' => 'post', 'inputDefaults' => array('label' => false))); ?>            										
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="icon-th"></i>
					</span>
					<h5>Static table with checkboxes in box with padding</h5>
				</div>
				<div class="widget-content nopadding">
					<table class="table table-bordered data-table table-striped with-check">
						<thead>
						<tr>
							<th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" /></th>
                            <th><?php echo  __d('system', 'Id'); ?>      </th>
                            <th> <?php echo  __d('system', 'Label'); ?></th>
                            <th> <?php echo  __d('system', 'Name'); ?></th>
                            <th> <?php echo  __d('system', 'Operations'); ?></th>
                            <th class="wd-fix-width"><?php echo  __d('system', 'Action'); ?></th>
						</tr>
						</thead>
						<tbody>
                            <?php
                        
                            $defaultLanguage = Router::defaultLanguage();
                          $_queries = array('continue' => $this->request->here(false));
                            ?>                    
                    <?php foreach ($list_fields as $field) : ?>
							<tr>
                		<td><input type="checkbox" /></td>            
                        <?php if (isset($_displayFields['id'])): ?>       
  	                         <td>
                           <?php echo $field['Field']['id']; ?>
                           </td>
                           <?php endif; ?>
                        <?php if (isset($_displayFields['label'])): ?>       
  	                         <td>
                           <?php echo $field['Field']['label']; ?>
                           </td>
                               <?php endif; ?>
                        <?php if (isset($_displayFields['name'])): ?>       
  	                         <td>
                          <?php echo $field['Field']['name']; ?>
                           </td>
                               <?php endif; ?>
                        <?php if (isset($_displayFields['field_type'])): ?>       
  	                         <td>
                          <?php echo $field['Field']['field_type']; ?>
                           </td>
                               <?php endif; ?>
								<td>
									<ul class="wd-action" style="">
										<li><?php echo $this->Html->link('Edit', array('action' => 'edit_field_settings', $field['Field']['id'], '?' => $_queries), array('title' => __d('system', 'Edit this item'), 'class' => 'wd-edit')); ?></li>
										<li > <?php echo $this->Html->link('Delete', array('action' => 'delete', '?' => array_merge($_queries, array('keys' => array($field['Field']['id'])))), array('title' => __d('system', 'Delete this item'), 'class' => 'wd-delete'), __d('system', 'Are you sure to delete #%s ?', $field['Field']['id'])); ?></li>
									</ul>
								</td>
							</tr>
           <?php endforeach?>
						</tbody>
					</table>							
				</div>
			</div>
            <?php         
            echo $this->Form->hidden('task', array('id' => 'task', 'value' => ''));
            echo $this->Form->end();?>
		</div>	