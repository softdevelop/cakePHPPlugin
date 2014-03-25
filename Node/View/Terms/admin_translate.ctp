<div class="section">
    <?php
    echo $this->element('toolbar');
    ?>
    <?php
    echo $this->Form->create('Term', array('id' => 'paginate', 'action' => 'translate', 'url' => $this->request->here(false), 'type' => 'post',
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
                , $term['Term']['name']
                , $this->Form->input('name', array('value' => $term['name'], 'type' => 'text', 'label' => $translation)));
    }
    if (isset($_translateFields['description'])) {
        $layout[] = array(__d('system', '%s translation', __d('system', 'Description')), array('description'));
        $fieldsets['description'] = sprintf($format
                , $original
                , $term['Term']['description']
                , $this->Form->input('description', array('value' => $term['description'], 'type' => 'textarea', 'class' => 'ckeditor', 'label' => $translation)));
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