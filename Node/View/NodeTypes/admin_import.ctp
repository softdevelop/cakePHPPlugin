<div class="section">
    <?php
    echo $this->element('toolbar');
    ?>
    <?php
    echo $this->Form->create('NodeType', array('id' => 'paginate', 'action' => 'edit', 'url' => $this->request->here(false), 'type' => 'file',
        'inputDefaults' => array('label' => false, 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))));

    $fieldsets['file'] = $this->Form->input('file', array(
        'label' => __d('system', 'File to import'),
        'type' => 'file'));
    $fieldsets['exist'] = $this->Form->input('exist', array(
        'label' => __d('system', 'Action on node title exist'),
        'options' => array(
            __d('system', 'Nothing'),
            __d('system', 'Overwrite'),
            __d('system', 'Delete old node'),
            //__d('system', 'Keep boths')
        ),
        'type' => 'select'));
    ?>

    <div class="panel clearfix">
        <fieldset>
            <?php
            $_layouts = array(
                array(
                    'Import content',
                    array(array('file', 'exist')),
                )
            );
            echo $this->Layout->form($_layouts, $fieldsets);
            ?>
        </fieldset>
    </div>
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->hidden('Paginate.step', array('id' => 'step', 'value' => $step));
    echo $this->Form->end();
    ?>
</div>