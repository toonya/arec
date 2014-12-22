<?php

// finish it later
function get_toonya_metabox_html($post_id, $field, $horizontal){
	$html = '';

	switch ($field['type']) {
		case 'text':
			$value = get_post_meta( $post_id, $field['id'], true );
			$html .= sprintf( 
				"<div class='form-group'>
					<label class='%s control-label' for='%s'>%s</label>
					%s<input class='form-control' type='text' id='%s' name='%s' value='%s' />%s
				</div>",
				( $horizontal == 'true' ) ? "col-sm-2" : "",
				$field['id'],
				esc_html($field['label']),
				( $horizontal == 'true' ) ? "<div class=\"col-sm-8\">" : "",
				$field['id'],
				$field['id'],
				esc_attr( $value ),
				( $horizontal == 'true' ) ? "</div>" : ""
		    );
			break;
		case 'textarea':
			$value = get_post_meta( $post_id, $field['id'], true );
			$html .= sprintf( 
				"<div class='form-group'>
					<label class='%s control-label' for='%s'>%s</label>
					%s%s<textarea rows='5' class='form-control' type='text' id='%s' name='%s' />%s</textarea>%s
				</div>",
				( $horizontal == 'true' ) ? "col-sm-2" : "",
				$field['id'],
				esc_html($field['label']),
				( $horizontal == 'true' ) ? "<div class=\"col-sm-8\">" : "",
				( ! empty($field['desc']) ) ? "<p>".esc_html( $field['desc'] )."</p>" : "",
				$field['id'],
				$field['id'],
				esc_attr( $value ),
				( $horizontal == 'true' ) ? "</div>" : ""
		    );
			break;
		case 'checkbox':
			$value = get_post_meta( $post_id, $field['id'], true );
			$html.= '<div class="checkbox">';
			$html .= '<label><input value=1 '.checked( $value, '1', false ).' id="'.$field['id'].'" name="'.$field['id'].'" type="checkbox"> '.$field['label'].'</label>';
			$html.= '</div>';
			break;

		// not finished, js and control area.
		case 'title-content':
			// get title array
			$title = get_post_meta( $post_id, $field['id'].'_title', true );

			$html.= '<div class="form-group title-content">';
			$html.= sprintf("<label class='%s control-label'>%s</label>%s",
				( $horizontal == 'true' ) ? "col-sm-2" : "",
				esc_html($field['label']),
				( $horizontal == 'true' ) ? "<div class=\"col-sm-8\">" : ""
			);

			$html.= '<ul class="nav nav-tabs ui-sortable">';
			if( isset($title) && ! empty($title) ){
				foreach ($title as $key => $value) {
					$html.= printf('<li%s><a href="#%s" data-toggle="tab">%s</a></li>',
						( $key == 0 ) ? ' class="active"' : '',
						$key+1,
						$key+1
					);
				}

				$html.=	'<li><a href="#addnew" data-toggle="tab">+</a></li></ul>';
    		}
    		else {
    			$html.=	'<li class="active"><a href="#addnew" data-toggle="tab">+</a></li></ul>';
    		}

    		// get content array
    		$content = get_post_meta( $post_id, $field['id'].'_content', true );
    		$html.= '<div class="tab-content">';
    
    		if( isset($content) && ! empty($content) ){
    			foreach ($title as $key => $value) {
    				$html.= printf(
    					'<div class="tab-pane%s" id="%s">
							<input class="form-control" type="text" name="%s_title[]" value="%s" />
							<textarea class="form-control" type="text" name="%s_content[]">%s</textarea>
    					</div>',
    					( $key == 0 ) ? ' active' : '',
    					'step'.($key+1),
    					$field['id'],
    					$title[$key],
    					$field['id'],
    					$content[$key]
    				);
    			}

    			$html.= '<div class="tab-pane" id="addnew">
							<input class="form-control" type="text" name="'.$field['id'].'"_title[] />
							<textarea class="form-control" rows="5" name="'.$field['id'].'"_content[]></textarea>
		    			</div>';
    		}

    		else {
    			$html.= '<div class="active" id="addnew">
							<input class="form-control" type="text" name="'.$field['id'].'"_title[] />
							<textarea class="form-control" rows="5" name="'.$field['id'].'"_content[]></textarea>
		    			</div>';
    		}

    		$html.= sprintf("%s", ( $horizontal == 'true' ) ? "</div>" : "" );
    		$html .= '</div>';
    		$html .= '</div>';

			break;

		
		default:
			# code...
			break;
	}

	return $html;
}

?>