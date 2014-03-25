<div class="section">
    <?php
    echo $this->element('toolbar');
    ?>
    <?php
    echo $this->Form->create('Node', array('id' => 'paginate', 'action' => 'edit', 'url' => $this->request->here(false), 'type' => 'post',
        'inputDefaults' => array('label' => false, 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))));

    $layout = $cols = array();
    $message = __d('system', '--- Not import ---', true);

    $count = count($fields);
    $index = 0;
    foreach ($fields as $field => $name) {
        $index++;
        $cols[] = $field;
        if (count($cols) === 2 || ($count === $index && $cols)) {
            $layout[] = $cols;
            $cols = array();
        }
        $fieldsets[$field] = $this->Form->input($field, array(
            'label' => __d('system', $name),
            'options' => $fieldset,
            'empty' => $message,
            'type' => 'select'));
    }
    ?>

    <div class="panel clearfix">
        <fieldset>
            <?php
            $_layouts = array(
                array(
                    'Import content step 2 : Select fields corresponding with column in the file you chosen',
                    $layout,
                )
            );
            echo $this->Layout->form($_layouts, $fieldsets);
            ?>
        </fieldset>
    </div>
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->hidden('Paginate.step', array('id' => 'step', 'value' => $step));
    echo $this->Form->hidden('NodeType.file', array('id' => 'file', 'value' => $file));
    echo $this->Form->hidden('NodeType.exist', array('id' => 'file', 'value' => $exist));
    echo $this->Form->end();
    ?>
</div>