<div class="section">
    <?php
    echo $this->element('toolbar');
    ?>
    <?php
    echo $this->Form->create('NodeType', array('id' => 'paginate', 'action' => 'edit', 'url' => $this->request->here(false), 'type' => 'post',
        'inputDefaults' => array('label' => false, 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))));
    $fieldsets['name'] = $this->Form->input('name', array(
        'label' => __d('system', 'Name'),
        'type' => 'text'));

    $fieldsets['enabled'] = $this->Form->input('enabled', array(
        'label' => __d('system', 'Enabled'),
        'type' => 'checkbox'));
        
    $fieldsets['description'] = $this->Form->input('description', array(
        'label' => __d('system', 'Description'),
        'type' => 'textarea'));
    ?>

    <div class="panel clearfix">
        <fieldset>
            <?php
            echo $this->Layout->form($_layouts, $fieldsets);
            ?>
        </fieldset>
    </div>
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->end();
    ?>
</div>