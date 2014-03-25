<div class="section">
    <?php
    echo $this->element('toolbar');
    ?>
    <?php
    echo $this->Form->create('NodeType', array('id' => 'paginate', 'action' => 'translate', 'url' => $this->request->here(false), 'type' => 'post',
        'inputDefaults' => array('label' => false, 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))));

    $format = '<div class="translate-wrapper">
                            <div class="translate-title">%s</div>
                            <div class="translate-content">%s</div>
                  </div>
                  <div class="translate-input">%s</div>';
    $original = __d('system', 'Original');
    $translation = __d('system', 'Translation');
    if (isset($_translateFields['name'])) {
        $layout[] = array(__d('system', '%s translation', __d('system', 'name')), array('name'));
        $fieldsets['name'] = sprintf($format
                , $original
                , $nodetype['NodeType']['name']
                , $this->Form->input('name', array('value' => $nodetype['name'], 'type' => 'text', 'label' => $translation)));
    }

    ?>

    <div class="panel clearfix">
        <fieldset>
            <?php
            echo $this->Layout->form($layout, $fieldsets);
            ?>
        </fieldset>
    </div>
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->end();
    ?>
</div>