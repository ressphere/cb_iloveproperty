<?php
class MY_custom_fields {

	function select2($params)
	{
		$form_builder =& $params['instance'];

		$js = '<script type="text/javascript">
			    $(function(){
			    	$(".field_type_tag").select2();
		    	})
		    	</script>
			';
		$form_builder->add_js($js);
		$params['class'] = (!empty($params['class'])) ? $params['class'].' field_type_tag' : 'field_type_tag';
		$params['type'] = 'select';

		return $form_builder->create_select($params);
	}

}

?>
