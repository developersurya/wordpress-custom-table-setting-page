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
    public function get_main_model()
	{
		$table    = new Dealer_Query('main_model');
		$all_rows = $table->get_all();
		return $all_rows;
	}



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


    public function list_table_header() {
        return '<thead>
        <tr>
            <td id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                <input id="cb-select-all-1" type="checkbox">
            </td>
            <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                <span>Model number </span>
                <span class="sorting-indicator"></span>
            </th>
            <th scope="col" id="author" class="manage-column column-author">Author</th>
            <th scope="col" id="categories" class="manage-column column-categories">Categories</th>
            <th scope="col" id="tags" class="manage-column column-tags">Tags</th>
            <th scope="col" id="comments" class="manage-column column-comments num sortable desc">
                <span>
                    <span class="vers comment-grey-bubble" title="Comments">
                        <span class="screen-reader-text">Comments</span>
                    </span>
                </span>
            </th>
            <th scope="col" id="date" class="manage-column column-date sortable asc">
                <a href="javascript:void(0)">
                    <span>Date</span><span class="sorting-indicator"></span>
                </a>
            </th>
        </tr>
    </thead>';
    }


    public function list_table_footer(){
        return '<tfoot>
        <tr>
            <td class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                <input id="cb-select-all-2" type="checkbox">
            </td>
            <th scope="col" class="manage-column column-title column-primary sortable desc">
                <span>Title</span>
            </th>
            <th scope="col" class="manage-column column-author">Author</th>
            <th scope="col" class="manage-column column-categories">Categories</th>
            <th scope="col" class="manage-column column-tags">Tags</th>
            <th scope="col" class="manage-column column-comments num sortable desc">
                <span>
                    <span class="vers comment-grey-bubble" title="Comments">
                        <span class="screen-reader-text">Comments</span>
                    </span>
                </span>
            </th>
            <th scope="col" class="manage-column column-date sortable asc">
                <a href="javascript:void(0)">
                    <span>Date</span>
                    <span class="sorting-indicator"></span>
                </a>
            </th>
        </tr>
    </tfoot>';
    }


    public function get_list_items( $data ) {

         if ($data) { 

          $body = '<tbody id="the-list">';

             foreach ($data as $model) { 

                $body .= '<tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-Dummy category">
                    <th scope="row" class="check-column">
                        <label class="screen-reader-text" for="cb-select-1">Select Post #1</label>
                        <input id="cb-select-1" type="checkbox" name="post[]" value="1">
                        <div class="locked-indicator">
                            <span class="locked-indicator-icon" aria-hidden="true"></span>
                            <span class="screen-reader-text">
                                “Post #1” is locked
                            </span>
                        </div>
                    </th>
                    <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                        <div class="locked-info">
                            <span class="locked-avatar"></span>
                            <span class="locked-text"></span>
                        </div>
                        <strong>
                            <a class="row-title" href="javascript:void(0)" aria-label="“Post #1” (Edit)">'.$model['model_number'].'</a>
                        </strong>

                        <div class="row-actions">
                            <span class="edit"><a href="javascript:void(0)" aria-label="Edit “Post #1”">Edit</a> | </span>
                            <span class="inline hide-if-no-js"><button type="button" class="button-link editinline" aria-label="Quick edit “Post #1” inline" aria-expanded="false">Quick Edit</button> | </span>
                            <span class="trash"><a href="javascript:void(0)" class="submitdelete" aria-label="Move “Post #1” to the Trash">Trash</a> | </span>
                            <span class="view"><a href="javascript:void(0)" rel="bookmark" aria-label="View “Post #1”">View</a></span>
                        </div>
                        <button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
                    </td>
                    <td class="author column-author" data-colname="Author">
                        <a href="javascript:void(0)">dummy@emailaddress</a>
                    </td>
                    <td class="categories column-categories" data-colname="Categories">
                        <a href="javascript:void(0)">Dummy category</a>
                    </td>
                    <td class="tags column-tags" data-colname="Tags">
                        <span aria-hidden="true">—</span>
                        <span class="screen-reader-text">No tags</span>
                    </td>
                    <td class="comments column-comments" data-colname="Comments">
                        <div class="post-com-count-wrapper">
                            <a href="javascript:void(0)" class="post-com-count post-com-count-approved">
                                <span class="comment-count-approved" aria-hidden="true">1</span>
                                <span class="screen-reader-text">1 comment</span>
                            </a>
                            <span class="post-com-count post-com-count-pending post-com-count-no-pending">
                                <span class="comment-count comment-count-no-pending" aria-hidden="true">0</span>
                                <span class="screen-reader-text">No pending comments</span></span>
                        </div>
                    </td>
                    <td class="date column-date" data-colname="Date">Published<br>
                        <abbr title="2019/08/22 9:00:46 am">2 hours ago</abbr>
                    </td>
                </tr>';
             } 
             
            $body .= '</tbody>';

            return $body;
         } 

    }

    /**
	 * Displays the list of views available on this table.
	 *
	 * @since 3.1.0
	 */
	public function list_views( ) {

        $data = $this->get_main_model(); 

       $views = '<form id="posts-filter" method="get">
                <header class="section-header">
                    <h2>Model list</h2>
                </header>';
            
            
                $views .= '<table class="wp-list-table widefat fixed striped table-view-list posts">';

                $views .= $this->list_table_header();

                $views .= $this->get_list_items( $data );

                $views .= $this->list_table_footer();
            
                $views .= '</table></form>';

		if ( empty( $views ) ) {
			return;
		}

        return $views;

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

    /**
	 * Gets the current page number.
	 *
	 * @since 1.0
	 *
	 * @return int
	 */
	public function get_pagenum() {
		$pagenum = isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 0;

		if ( isset( $this->_pagination_args['total_pages'] ) && $pagenum > $this->_pagination_args['total_pages'] ) {
			$pagenum = $this->_pagination_args['total_pages'];
		}

		return max( 1, $pagenum );
	}


    



}

if (is_admin()) {
	//$list_table = new Atom_List_Table();
}