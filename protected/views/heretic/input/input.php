<?php if(!empty($arguments['aux_field'])&& (empty($arguments['aux_field']['errors']))) : ?>
<?php foreach($arguments['aux_field'] as $key => $value) : ?>

<?php 
    switch ($value['type']) {
        case 'string':
            $name = 'field_inner_' . $value['field_name'];
            heretic::Widget('input', array(
                'type' => 'text',
                'name' => $name,
                'label' => $value['title'] . ':',
                'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
            ));
            break;

        case 'number':
            $name = 'field_inner_' . $value['field_name'];
            heretic::Widget('input', array(
                'type' => 'text',
                'name' => $name,
                'label' => $value['title'] . ':',
                'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
            ));
            break;

        case 'text':
            $name = 'field_inner_' . $value['field_name'];
            heretic::Widget('input', array(
                'type' => 'textarea_no',
                'name' => $name,
                'label' => $value['title'] . ':',
                'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
            ));
            break;
        
        case 'date':
            $name = 'field_inner_' . $value['field_name'];
            heretic::Widget('input', array(
                'type' => 'date',
                'name' => $name,
                'label' => $value['title'] . ':',
                'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
            ));
            break;
        
        case 'image':
            $name = 'field_inner_' . $value['field_name'];
            heretic::Widget('input', array(
                'type' => 'image',
                'name' => $name,
                'label' => $value['title'] . ':',
                'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
            ));
            break;
        
        
        case 'selecter':
            $name = 'field_inner_' . $value['field_name'];
            heretic::Widget('input', array(
                'type' => 'selecter',
                'name' => $name,
                'selector' => $value["selecter_filter"],
                'label' => $value['title'] . ':',
                'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
            ));
            break;
        
        case 'phone':
            $name = 'field_inner_' . $value['field_name'];
            heretic::Widget('input', array(
                'type' => 'text',
                'name' => $name,
                'class' => 'phone-edit',
                'label' => $value['title'] . ':',
                'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
            ));
            break;
        
        case 'single_image':
            $name = 'field_inner_' . $value['field_name'];
            heretic::Widget('input', array(
                'type' => 'single_image',
                'name' => $name,
                'class' => 'single-image-edit',
                'label' => $value['title'] . ':',
                'errors' => (!empty($arguments['errors'][$name])) ? $arguments['errors'][$name] : '',
                'result' => (!empty($arguments['result'][$name])) ? $arguments['result'][$name] : '',
            ));
            break;
        
        
        default:
            break;
    }

?> 

<?php endforeach;?>
<?php endif;?>