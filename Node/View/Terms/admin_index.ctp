<?php
$this->Paginator->options(array('url' => array('ext' => false, '?' => $this->request->query)));
?>
<div id="content-header">
	<h1>List Categories</h1>
</div>
<div id="breadcrumb">
	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    	<a href="#" class="">List Categories</a>
	<a href="#" class="current">Dashboard</a>
</div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
            <?php
            echo $this->element('toolbar');
            ?>	
            
      <?php echo $this->Form->create('Paginate', array('id' => 'paginate', 'url' => $this->request->here(false), 'type' => 'post', 'inputDefaults' => array('label' => false))); ?>
        <div class="paginate-place">							
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
                            <th> <?php echo  __d('system', 'Name'); ?></th>
                            <th> <?php echo  __d('system', 'Created'); ?></th>
                            <th>  <?php echo  __d('system', 'Updated'); ?></th>
                            <th class="wd-fix-width">  <?php echo  __d('system', 'Translate'); ?></th>
                            <th class="wd-fix-width"><?php echo  __d('system', 'Action'); ?></th>
						</tr>
						</thead>
						<tbody>
                            <?php
                        
                            $defaultLanguage = Router::defaultLanguage();
                          $_queries = array('continue' => $this->request->here(false));
                            ?>                    
                         <?php foreach ($listTerms as $term) : ?>
							<tr>
                		<td><input type="checkbox" /></td>            
                        <?php if (isset($_displayFields['id'])): ?>       
  	                         <td>
                           <?php echo $term['Term']['id']; ?>
                           </td>
                           <?php endif; ?>
                        <?php if (isset($_displayFields['name'])): ?>       
  	                         <td>
                           <?php echo $term['Term']['name']; ?>
                           </td>
                               <?php endif; ?>
                        
                          
                        <?php if (isset($_displayFields['created'])): ?>       
  	                         <td>
                             <?php echo date("d-m-Y",$term['Term']['created']); ?>
                           </td>
                        <?php endif; ?>
                        <?php if (isset($_displayFields['updated'])): ?>       
  	                         <td>
                          <?php echo date("d-m-Y",$term['Term']['updated']); ?>
                           </td>
                        <?php endif; ?>                               
								<td>
                            <?php if (isset($_translateMaps)): ?>
									<ul class="wd-laguage">
                                    <?php
                                    foreach (Configure::read('Languages') as $_language) {
                                        if ($_language['code'] === $defaultLanguage) {
                                            continue;
                                        }
                                        echo $this->Html->link($this->Html->image('/theme/Green/img/' . $_language['code'] . '.png'), array('action' => 'translate', $term['Term']['id'], $_language['code'], '?' => $_queries), array(
                                            'class' => isset($_translateMaps[$term['Term']['id']][$_language['locale']]) ? '' : 'ui-state-disabled', 'escape' => false, 'title' => $_language['name']));
                                    }
                                    ?>
									</ul>
                            <?php endif; ?>       
								</td>
							<td>
								<ul class="wd-action">
									<li> <?php echo $this->Html->link('Edit', array('action' => 'edit',$type_id, $term['Term']['id'], $term['Term']['parent_id'], '?' => $_queries), array('title' => __d('system', 'Edit this item'), 'class' => 'wd-edit')); ?></li>
									<li><?php echo $this->Html->link('Delete', array('action' => 'delete', '?' => array_merge($_queries, array('keys' => array($term['Term']['id'])))), array('title' => __d('system', 'Delete this item'), 'class' => 'wd-delete'), __d('system', 'Are you sure to delete #%s ?', $term['Term']['id'])); ?></li>
									<li> <?php echo $this->Html->link('Move up', array('action' => 'move', $term['Term']['id'], 'up', '?' => $_queries), array('title' => __d('system', 'Move up this item'), 'class' => 'wd-up')); ?></li>
									<li> <?php echo $this->Html->link('Move down', array('action' => 'move', $term['Term']['id'], 'down', '?' => $_queries), array('title' => __d('system', 'Move down this item'), 'class' => 'wd-down')); ?></li>
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