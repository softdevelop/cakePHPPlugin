<div class="section">
    <?php
    echo $this->element('toolbar');
    ?>
    <?php
    echo $this->Form->create('Node', array('id' => 'paginate', 'action' => 'edit', 'url' => $this->request->here(false), 'type' => 'post',
        'inputDefaults' => array('label' => false, 'format' => array('before', 'label', 'between', 'input', 'after', 'error'))));

    $fieldsets['loading'] = $this->Html->div('input text', $this->Html->tag('div', '', array('id' => 'node-type-load')));
    $fieldsets['loading'] .= $this->Html->div('colcomment', __d('system', 'Preparing to import ...'), array('id' => 'node-type-message'));
    ?>

    <div class="panel clearfix">
        <fieldset>
            <?php
            $_layouts = array(
                array(
                    'Import content step 3 : Importing ...',
                    array('loading'),
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
    echo $this->Form->end();
    ?>
</div>
<script type="text/javascript">
    (function($){
        var url = '<?php echo $this->request->here(false); ?>';
        var $progess = $('#node-type-load'),
        $place = $progess.parent().next(),
        $message = $('#node-type-message'),
        completed =  false;
        
        $progess.progressbar({ 
            value: 0,
            complete : function(){
                completed = true;
                $('<div></div>').html(Green.t('The import process has completed')).appendTo('body').dialog({
                    modal : true,
                    title : Green.t('System Message'),
                    buttons :{
                        Ok: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
            }
        });
        var importViaAjax = function(){
            $.ajax({
                url : url,
                cache : false,
                type : 'GET',
                data : {ajax : true},
                success : function(data){
                    try{
                        data = $.parseJSON(data);
                    }catch(e){
                        return;
                    }
                    if(data && data.error != undefined){
                        if(data.error == false){
                            $progess.progressbar('value' , data.value);
                        }
                        $message.html(data.message);
                    }
                },
                complete : function(){
                    if(!completed){
                        importViaAjax();
                    }
                }
            });
        }
        importViaAjax();
    })(jQuery);
</script>