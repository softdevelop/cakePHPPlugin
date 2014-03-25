<?php echo $this->Form->create('Paginate', array('id' => 'paginate', 'url' => $this->request->here(false), 'type' => 'post', 'inputDefaults' => array('label' => false))); ?>           				

<div id="content-header">
<h1>Content Management</h1>
</div>
<div id="breadcrumb">
	<a href="<?php echo $this->Html->url('/admin/')?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
	<a href="#" class="current">List Contents</a>
</div>
<div class="container-fluid">
<div class="row-fluid">
	<div class="span12">
    <?php     echo $this->element('toolbar');?>	
    <?php echo $this->Session->flash(); ?> 							
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-th"></i>
				</span>
				<h5>List of content</h5>
			</div>
			<div class="widget-content widget-content-two">
				<div class="wd-select">
					<div class="control-group">
						<div class="controls wd-farming">
							<select>
								<option />Delete
							</select>
							<button class="btn">Apply</button>
<!--
							<select>
								<option />Show all date
								<option />Second option Bulk Actions
								<option />Third option
								<option />Fourth option
								<option />Fifth option
								<option />Sixth option
								<option />Seventh option
								<option />Eighth option
							</select>
							<select>
								<option />View all categories
								<option />Second option Bulk Actions
								<option />Third option
								<option />Fourth option
								<option />Fifth option
								<option />Sixth option
								<option />Seventh option
								<option />Eighth option
							</select>
							<button class="btn">Filter</button>
-->
						</div>
					</div>
				</div>
				<table class="table table-bordered data-table table-striped with-check wd-hover-btn">
					<thead>
						<tr>
                        <th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" /></th>
                        <th> <?php echo  __d('system', 'Title'); ?></th>
                        <th> <?php echo  __d('system', 'Author'); ?></th>
                        <th> <?php echo  __d('system', 'Categories'); ?></th>
                        <th> <?php echo  __d('system', 'Translate'); ?></th>
                        <th class="wd-fix-width-1"><?php echo  __d('system', 'Last update'); ?></th>
                        <th class="wd-fix-width-2"><?php echo  __d('system', 'Action'); ?></th>
						</tr>
					</thead>
					<tbody>
                        <?php
                    
                        $defaultLanguage = Router::defaultLanguage();
                      $_queries = array('continue' => $this->request->here(false));
                        ?> 
                            <?php foreach ($listNodes as $node) : ?>                                            
						<tr>
							<td><?php echo $this->Form->input('id.', array('value' => $node['Node']['id'], 'type' => 'checkbox', 'div'=>false,'hiddenField' => false, 'id' => 'title-table-checkbox')); ?></td>
                            <?php if (isset($_displayFields['title'])): ?>       
  	                         <td>
                          <a href="<?php echo $this->Html->url(array('plugin'=>'node','controller' => 'node', 'action' => 'edit', $node['Node']['node_type_id'], $node['Node']['id'], '?' => $_queries));?>"> <?php echo $node['Node']['title']; ?></a>
                           </td>
                               <?php endif; ?>
                        <?php if (isset($_displayFields['user_id'])): ?>       
  	                         <td>
                          <?php echo $node['User']['fullname']; ?>
                           </td>
                               <?php endif; ?>
                        <?php if (isset($_displayFields['node_type_id'])): ?>       
  	                         <td>
                            <a href="#">  <?php echo $node['NodeType']['name']; ?></a>
                           </td>
                               <?php endif; ?>    
							<td>
                            <?php if (isset($_translateMaps)): ?>
									<ul class="wd-laguage">
                                    <?php
                                    foreach (Configure::read('Languages') as $_language) {
                                        if ($_language['code'] === $defaultLanguage) {
                                            continue;
                                        } ?>
                            <li><?php  echo $this->Html->link($this->Html->image('/theme/Green/img/' . $_language['code'] . '.png'), array('plugin'=>'node','controller'=>'node','action' => 'translate', $node['Node']['id'], $_language['code'], '?' => $_queries), array(
                                            'class' => isset($_translateMaps[$node['Node']['id']][$_language['locale']]) ? '' : 'ui-state-disabled', 'escape' => false, 'title' => $_language['name']));?></li>           
                                    <?php }?>
									</ul>
                            <?php endif; ?>  
							</td>
	                        <?php if (isset($_displayFields['updated'])): ?>       
  	                         <td>
                          <?php echo date("d-m-Y g:i A",$node['Node']['updated']); ?>
                           </td>
                        <?php endif; ?>  
							<td>
							<ul class="wd-link-control">
							<li><a href="<?php echo $this->Html->url(array('plugin'=>'node','controller' => 'node', 'action' => 'edit', $node['Node']['node_type_id'], $node['Node']['id'], '?' => $_queries));?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</a></li>
							<li><a href="#<?php echo $node['Node']['id']?>" data-toggle="modal" class="btn btn-mini"><i class="icon-remove" onclick="return getdata('<?php echo $node['Node']['id'] ?>','<?php echo $node['Node']['title'];?>');"></i> Delete</a></li>
    					   </ul>
							</td>
						</tr>
                                                     
           <?php endforeach?>                        
					</tbody>
      <?php foreach ($listNodes as $node) : ?> 
			 	<div id="<?php echo $node['Node']['id']?>" class="modal hide">
					<div class="modal-header">
						<button data-dismiss="modal" class="close" type="button">×</button>
						<h3>Alert modal</h3>
					</div>
					<div class="modal-body">
						<p>Are you sure delete “<?php echo $node['Node']['title']?>”?</p>
					</div>
					<div class="modal-footer">
						<a data-dismiss="modal" class="btn" href="#">Cancel</a>
                        <?php echo $this->Html->link('Delete', array('plugin'=>'node','controller' => 'node','action' => 'delete', '?' => array_merge($_queries, array('keys' => array($node['Node']['id'])))), array('title' => false, 'class' => 'btn btn-danger','data-dismiss='=>'modal')); ?>                        
					</div>
				</div>  
    <?php endforeach?>
				</table>
				<div class="wd-select">
					<div class="control-group">
						<div class="controls wd-farming">
							<select>
								<option />Delete
							</select>
							<button class="btn">Apply</button>
						</div>
					</div>
				</div>								
			</div>
		</div>
	</div>	
</div>
<?php         
echo $this->Form->hidden('task', array('id' => 'task', 'value' => ''));
echo $this->Form->end();
?>
