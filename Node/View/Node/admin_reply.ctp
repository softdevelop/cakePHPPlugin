<div class="section">
    <?php
    echo $this->element('toolbar');
    ?>
    <?php
    echo $this->Form->create('Node', array('id' => 'paginate', 'action' => 'edit', 'url' => $this->request->here(false), 'type' => 'file',
        'inputDefaults' => array('label' => false, 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))));

    $fieldsets['field_contact_email'] = $this->Form->input('field_contact_email', array(
        'label' => "To:",
        'type' => 'text'));

    $fieldsets['field_contact_content'] = $this->Form->input('field_contact_content', array(
        'label' => 'Content:',
        'type' => 'textarea'));
    $layout = array(
        array('field_contact_email'),
        array('field_contact_content')
    );
    ?>
    <div class="panel clearfix">
        <fieldset>
            <?php
            $layout = array(
                array(
                    'Content',
                    $layout,
                )
            );
            echo $this->Layout->form($layout, $fieldsets);
            ?>
        </fieldset>
    </div>
    <?php
    echo $this->Form->hidden('Paginate.task', array('id' => 'task', 'value' => ''));
    echo $this->Form->end();
    ?>
</div>
