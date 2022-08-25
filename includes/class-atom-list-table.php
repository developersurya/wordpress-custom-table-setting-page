<?php
/**
 *Atom_List_Table class
 *
 * @package Atom Dealer
 * @since 1.0
 */

/**
 * Base class for displaying a list of items in an ajaxified HTML table.
 *
 * @since 1.0
 * @access private
 */
class Atom_List_Table {

    /**
	 * The current list of items.
	 *
	 * @since 1.0
	 * @var array
	 */
	public $items;

    /**
	 * Various information about the current table.
	 *
	 * @since 1.0
	 * @var array
	 */
	protected $_args;

    /**
	 * Various information needed for displaying the pagination.
	 *
	 * @since 1.0
	 * @var array
	 */
	protected $_pagination_args = array();


    /**
	 * List heading displaying .
	 *
	 * @since 1.0
	 * @var array
	 */
	protected $table_view_options  = array();

    public function __construct( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'plural'   => '',
				'singular' => '',
				'ajax'     => false,
				'screen'   => null,
			)
		);
    }


    /**
     * Get all main model data
     *
     * @return void
     */
    // public function get_main_model()
	// {
	// 	$table    = new Dealer_Query('main_model');
	// 	$all_rows = $table->get_all();
	// 	return $all_rows;
	// }



    /**
	 * Whether the table has items to display or not
	 *
	 * @since 3.1.0
	 *
	 * @return bool
	 */
	public function has_list_items() {
		return ! empty( $this->items );
	}


    public function list_table_header( $table_view_options  ) {
        $head =  '<thead><tr>';
        if( is_array( $table_view_options ) && !empty( $table_view_options ) ) {
            foreach ( $table_view_options as $table_view ) {
                $head .= '<th scope="col" id="'.$table_view.'" class="manage-column column-'.$table_view.'">'.ucfirst( str_replace ('_',' ', $table_view ) ) .'</th>';
            }
        }
    
        $head .= '</tr></thead>';
        return $head;
    }


    public function list_table_footer( $table_view_options  ){

        $footer =  '<tfoot><tr>';
        if( is_array( $table_view_options ) && !empty( $table_view_options ) ) {
            foreach ( $table_view_options as $table_view ) {
                $footer .= '<td scope="col" id="'.$table_view.'" class="manage-column column-'.$table_view.'">'.ucfirst( str_replace ('_',' ', $table_view ) ) .'</td>';
            }
        }
    
        $footer .= '</tr></tfoot>';

         return $footer ;
    }


    public function get_list_items( $data , $table_view_options  ) {

      
         if ($data) { 

          $body = '<tbody id="the-list">';

             foreach ($data as $model) { 

                $body .= '<tr id="post-list" class="iedit author-self level-0 post-1 type-post status-publish format-standard ">';
                
                if( is_array( $table_view_options ) && !empty( $table_view_options ) ) {
                    foreach ( $table_view_options as $table_view ) {
                        //$body .= '<td class="date column-date" data-colname="Date">Published<br>
                        $body .= '<td class="date column-date" data-colname="Date">'.$model[$table_view].'</td>';
                    }
                }
                $body .= '</tr>';
             } 

            $body .= '</tbody>';

            return $body;
         } 

    }

    public function get_main_model( $table , $limit , $filter )
	{

		$table    = new Dealer_Query( $table ); // ?? this could not pass the table name

        $pagenum = $this->get_pagenum();  // ?? does not work here

		$total_item = $this->get_total_item_number( $table );

        $limit = 10;

		$offset = ( $pagenum - 1 ) * $limit;
       
		$all_rows = $table->get_table_data( 'date', 'DESC', $offset, $limit ,$filter );
		return $all_rows;
	}


    /**
	 * Displays the list of views available on this table.
	 *
	 * @since 3.1.0
	 */
	public function list_views(  $table , $limit , $table_view_options  ) {

        $filter = empty( $_REQUEST['s'] ) ? '' : $_REQUEST['s'];

        $data = $this->get_main_model( $table , $limit ,$filter ); 

        $removable_query_args = wp_removable_query_args();

        $current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );

		$current_url = remove_query_arg( $removable_query_args, $current_url );

       $views = '<form id="posts-filter" method="post" action="'.$current_url.'">
                <header class="section-header">
                    <h2>Post list</h2>
                </header>';
                $views .= $this->top_search_box( $table , $limit );
            
                $views .= '<table class="wp-list-table widefat fixed striped table-view-list posts">';

                $views .= $this->list_table_header( $table_view_options  );

                $views .= $this->get_list_items( $data, $table_view_options  );

                $views .= $this->list_table_footer( $table_view_options );
            
                $views .= '</table></form>';

                $views .= $this->pagination_( $table );

		if ( empty( $views ) ) {
			return;
		}

        return $views;

	}

    /**
     * Undocumented function
     *
     * @return void
     */
    public function top_search_box( $table , $limit   ){
       
        if( empty( $_REQUEST['s'] ) &&  $this->get_total_item_number( $table) <= 0 ) {
            return;
        }

        $text = empty( $_REQUEST['s'] ) ? '' : $_REQUEST['s'];
       
        if( !empty( $text ) ) {
            echo '<span class="subtitle">Search results for: <strong>'.$text.'</strong></span>';
        }

        //echo '<input type="hidden" name="table" value="'.$table .'" />';

        if( ! empty( $_REQUEST['orderby'] ) ) {
            echo '<input type="hidden" name="orderby" value="'.esc_attr( $_REQUEST['orderby'] ).'" />';
        }
        if ( ! empty( $_REQUEST['order'] ) ) {
			echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
		}
        if ( ! empty( $_REQUEST['order'] ) ) {
			echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
		}
        
        $search = '<p class="search-box">';
            $search .= '<label class="screen-reader-text" for="'.esc_attr( $table ).'">'.$text.':</label>
                        <input type="search" id="'.esc_attr( $table ).'" name="s" value="'._admin_search_query().'" />';
             $search .= '<input type="submit" id="'.esc_attr( $table ).'-search-submit" class="button" value="Search">';
            $search .= '</p><br/>';
        return  $search;

        
    }


    /**
	 * Access the pagination args.
	 *
	 * @since 1.0
	 *
	 * @param string $key Pagination argument to retrieve. Common values include 'total_items',
	 *                    'total_pages', 'per_page', or 'infinite_scroll'.
	 * @return int Number of items that correspond to the given pagination argument.
	 */
	public function get_pagination_arg( $key ) {
		if ( 'page' === $key ) {
			return $this->get_pagenum();
		}

		if ( isset( $this->_pagination_args[ $key ] ) ) {
			return $this->_pagination_args[ $key ];
		}

		return 0;
	}


    public function get_total_item_number( $table ){
        $table    = new Dealer_Query($table);
        $data = $table->get_all(); 
        $total_items     = ( count( $data ) )? count( $data ) : 0;
        return $total_items;
    }
    /**
	 * Gets the current page number.
	 *
	 * @since 1.0
	 *
	 * @return int
	 */
	public function get_pagenum() {

		$pagenum = isset( $_REQUEST['pagenum'] ) ? absint( $_REQUEST['pagenum'] ) : 0;

		// if ( ( $this->get_total_item_number() > 0  ) && $pagenum > $total_pages ) {
		// 	//$pagenum = $this->total_pages;
		// }

		return max( 1, $pagenum );
	}


    public function get_pagination_data( $total_records , $no_of_records_per_page ){
        $total_pages = ceil($total_records / $no_of_records_per_page);
        return $total_pages;
    }

    protected function pagination_( $table ) {

        $get_current_page =  $this->get_pagenum();
        $get_total_item_number = $this->get_total_item_number( $table );
        $total_pages = $this->get_pagination_data( $get_total_item_number , 10 );

        $page_links = paginate_links( array(
            'base' => add_query_arg( 'pagenum', '%#%' ),
            'format' => '',
            'prev_text' => __( '&laquo;', 'text-domain' ),
            'next_text' => __( '&raquo;', 'text-domain' ),
            'total' => $total_pages,
            'current' => $get_current_page
        ) );
        
        if ( $page_links ) {
            $pagi_html =  '<div class="tablenav bottom"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>'; 
        }
        return $pagi_html;

    }

    



}

if (is_admin()) {
	//$list_table = new Atom_List_Table();
}