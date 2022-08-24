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
    public function __construct($tableName)
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
