<?php
// ----------------------------------------
// ! This is a basic bootstrap navigation.
// *
// * <li><a href="">首页</a></li>
// ----------------------------------------
class Bootsrap_basic extends Walker {

    // Tell Walker where to inherit it's parent and id values
    var $db_fields = array(
        'parent' => 'menu_item_parent',
        'id'     => 'db_id'
    );

    /**
     * At the start of each element, output a <li> and <a> tag structure.
     *
     * Note: Menu objects include url and title properties, so we will use those.
     */

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		//echo ' '.get_the_title().' '.$item->post_title.'<br />';
        //global $post;
        //wp_die(var_dump($post));
		//$item->object_id is string, get_the_ID(),returns a int.
        $current = ( $item->object_id == get_the_ID() || (is_front_page() && ($item->post_title == '首页'||$item->post_title == 'Home')) );
        $output .= sprintf( "\n<li><a %s href='%s'>%s</a></li>\n",
            $current? ' class="active"' : '',
            $current? '#' :  $item->url,
            $item->title
        );
    }

}

// ========================================
// ! notice 1. === -> ==
// ========================================


// ----------------------------------------
// ! This is a basic bootstrap navigation.
// *
// * <li><a href="">首页</a></li>
// ----------------------------------------
class bootstrap_dropdown extends Walker {

    // Tell Walker where to inherit it's parent and id values
    var $db_fields = array(
        'parent' => 'menu_item_parent',
        'id'     => 'db_id'
    );

    /**
     * At the start of each element, output a <li> and <a> tag structure.
     *
     * Note: Menu objects include url and title properties, so we will use those.
     */

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        // echo $item->object_id . ' ' . get_the_ID() . '<br />';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        if( ! in_array("menu-item-has-children", $classes ) ) {
            $output .= sprintf( "\n<li><a class=\"%s\" href='%s'>%s</a>",
                implode( ' ', $classes ).' '.$depth,
                $item->url,
                ( $depth == 0 ) ? $item->title : '<h3>'.$item->title.'</h3>'
            );
        }

        else {
            $output .= sprintf( "\n<li class=\"dropdown\"><a href='%s' class=\"%s dropdown-toggle\" data-toggle='dropdown' data-hover=\"dropdown\">%s <b class='caret'></b></a>",
                $item->url,
                implode( ' ', $classes ),
                $item->title
            );
        }
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"dropdown-menu sub-menu\"><div class=\"container\"><ul>\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent<div class=\"clearfix\"></div></ul></div></div>\n";
    }
}


// ----------------------------------------
// ! this is a special navigation type.
// * hover with another language. WBlegal
// ----------------------------------------

class Bootsrap_two_langs extends Walker {

    // Tell Walker where to inherit it's parent and id values
    var $db_fields = array(
        'parent' => 'menu_item_parent',
        'id'     => 'db_id'
    );

    /**
     * At the start of each element, output a <li> and <a> tag structure.
     *
     * Note: Menu objects include url and title properties, so we will use those.
     */

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $post;

    	$second_title = get_post_meta( $item->object_id, 'second_title', true );

		//echo $item->object_id.' '.$second_title.'<br />';
		if(empty($second_title)){
	        $output .= sprintf( "\n<li %s><a href='%s'>%s</a></li>\n",
	            ( !empty($post) && ( $item->object_id == $post->ID ) ) ? ' class="active"' : '',
	            $item->url,
	            $item->title
			);
        }
        else{
	        $output .= sprintf( "\n<li %s><a href='%s'><span>%s</span><span>%s</span></a></li>\n",
	            ( !empty($post) && ( $item->object_id == $post->ID ) ) ? ' class="active"' : '',
	            $item->url,
	            $item->title,
	            $second_title
			);
        }
    }


}