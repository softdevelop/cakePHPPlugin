<?php

Class UpdateNodeComponent extends Component {
    /*
     *  Use in controller $this->Components->load('Node.UpdateNode')->init();
     */

    public function init() {
        $Model = new Model(array('name' => 'Node', 'ds' => 'default'));
        $nodes = $Model->find('all');
        foreach ($nodes as $node) {
            $node = array_shift($node);
            foreach ($node as $k => &$v) {
                if (strpos($k, 'field_') === 0 && $v) {
                    $v = unserialize($v);
                    $v = 'uploads/' . $v['name'];
                }
            }
            $Model->id = $node['id'];
            unset($node['id']);
            $Model->save($node);
        }
        $this->_Collection->getController()->showDebug();
    }

}

?>
