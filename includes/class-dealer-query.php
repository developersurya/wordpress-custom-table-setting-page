<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Atom_Dealer
 * @subpackage Atom_Dealer/admin
 * @author     NWS <wordpress@wordpress.com>
 */

 /**
  * Class which has helper functions to get data from the database
  */
 class Dealer_Query {
    /**
     * The current table name
     *
     * @var boolean
     */
    private $tableName = false;

     /**
     * Constructor for the database class to inject the table name
     *
     * @param String $tableName - The current table name
     */
    public function __construct( $tableName )
    {
        $this->tableName = $tableName;
    }


    /**
     * Get all from the selected table
     *
     * @param  String $orderBy - Order by column name
     *
     * @return Table result
     */
    public function get_all( $orderBy = NULL  , $return = NULL )
    {
        global $wpdb;

        $sql = 'SELECT * FROM `'.$this->tableName.'`';

        if(!empty($orderBy))
        {
            $sql .= ' ORDER BY ' . $orderBy;
        }
        if( empty($return))
        {
            $return = 'ARRAY_A';
        }

        $all = $wpdb->get_results($sql ,  $return );

        return $all;
    }


    // [10]=> array(12) { ["model_id"]=> string(6) "758631" ["model_number"]=> string(5) "315-5" ["description"]=> string(46) "Battery Edger - kit with 5AH battery & charger" ["retail_price"]=> string(3) "829" ["image_name"]=> string(21) "315 battery edger.png" ["dealer_discount"]=> string(2) "25" ["part_collection"]=> string(1) "0" ["is_publish"]=> string(1) "0" ["date"]=> string(19) "2022-02-23 08:17:04" ["is_deactive"]=> string(1) "0" ["no_longer_available"]=> string(1) "0" ["substitute_model_number"]=> string(0) "
        
    public function get_table_data( $orderBy = NULL , $order, $offset, $limit ) {
        global $wpdb;
        $limit = ( $limit )? $limit: 10;
        $sql = 'SELECT * FROM `'.$this->tableName.'`';

        if(!empty($orderBy))
        {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        if(!empty($order))
        {
            $sql .= ' ' . $order;
        }


        if(!empty($limit))
        {
            $sql .= ' LIMIT  ' . $offset . ', ' .$limit ;
        }
        if( empty($return))
        {
            $return = 'ARRAY_A';
        }

        $all = $wpdb->get_results($sql ,  $return );

        return $all;
    }


    public function insert( array $data )
    {
        
        global $wpdb;
        if(empty($data))
        {
            return false;
        }
       $aa =  $wpdb->insert( $this->tableName, $data );


        return $wpdb->insert_id;
    }


 }
