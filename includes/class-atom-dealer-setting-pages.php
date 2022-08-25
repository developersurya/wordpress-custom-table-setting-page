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
class Atom_dealer_setting_pages extends Atom_List_Table
{


	/**
	 * Various information needed for displaying the pagination.****
	 *
	 * @since 3.1.0
	 * @var array
	 */
	protected $_atom_pagination_args = array();


	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		add_action('admin_menu', array($this, 'add_plugin_page'));
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page()
	{
		// This page will be under "Settings"
		add_menu_page(
			'Atom Dealer',
			'Atom Dealer',
			'manage_options',
			'atom-dealer-settings',
			array($this, 'atom_dealer_setting_general'),
			'dashicons-text-page',
			90
		);

		// add_submenu_page( 'atom-dealer-settings',
		//      'Atom Dealer',
		//       'Atom Dealer',
		//     'manage_options',
		//     'atom-dealer-settings',
		//     array($this, 'atom_dealer_setting_general'),
		//     'dashicons-text-page',
		//     90
		// );
		add_submenu_page(
			'atom-dealer-settings',
			'Model',
			'Model',
			'manage_options',
			'atom-dealer-settings-1',
			array($this, 'atom_dealer_setting_model'),
			'dashicons-text-page',
			90
		);

		add_submenu_page(
			'atom-dealer-settings',
			'Add Model',
			'Add Model',
			'manage_options',
			'atom-dealer-settings-add',
			array($this, 'atom_dealer_model_add'),
			'dashicons-text-page',
			90
		);
	}


	

	/**
	 * Report main page
	 */
	public function atom_dealer_setting_model()
	{
		$table = 'main_model';
		$limit = 10;
		$table_view_options  = array( 'model_id','model_number','description','retail_price','date' );

		$view = $this->list_views( $table, $limit , $table_view_options );
		echo '<div class="wrap">'.$view.'</div>';
	
	}

	/**
	 *  Main page
	 */
	public function atom_dealer_setting_general()
	{
		$this->options = get_option('report_option_general');
	?>
		<div class="wrap general-setting-form">
			<!-- <img src="<?php echo plugins_url(); ?>/report payment gateway/assets/images/logo.png"> -->

			<header class="section-header">
				<h2>Welcome to the Admin Module of Atom!</h2>
				<hr>
			</header>

			<?php //$main_model = $this->get_main_model(); ?>


			<br />

		</div>
	<?php
	}


	public  function dealer_save_model(){

		if (isset($_POST['submit']) && $_POST['submit'] == 'Create') {
			if (empty($_POST['report_nonce_field']) && isset($_POST['submit'])) {
				print 'Sorry, your nonce did not verify.';
			} else {
				
				$MainModel = $_POST['MainModel'];
				$arry = array('model_number' => $MainModel['model_number'], 'description' => $MainModel['description'], 'image_name' => $MainModel['image_name'], 'retail_price' => $MainModel['retail_price'], 'dealer_discount' => $MainModel['dealer_discount'], 'substitute_model_number' => $MainModel['substitute_model_number'], 'part_collection' => $MainModel['part_collection'] , 'is_publish' => $MainModel['is_publish'] ,'no_longer_available' => $MainModel['no_longer_available']);

				$table = new Dealer_Query( 'main_model' );
				$updated = $table->insert( $arry );
				 if( $updated ){
					return 'Updated Successfully';
				 }else{
					return 'Error in updating';
				 }
			}
		}
		
	}

	/**
	 * Main Model add
	 */
	public function atom_dealer_model_add()
	{
		$this->options = get_option('report_option_general');
	?>
		<div class="wrap general-setting-form">
			<!-- <img src="<?php echo plugins_url(); ?>/report payment gateway/assets/images/logo.png"> -->
			<?php
				// Update the post
				$save_model = $this->dealer_save_model();
				if( $save_model ) {
					echo '<div class="notice notice-success is-dismissible"><p>'.$save_model.'</p></div>';
				}
			?>
			<header class="section-header">
				<h2>Add Model</h2>
				<hr>
			</header>

			<form enctype="multipart/form-data" id="main-model-form"  method="post">
				<div class="dealer clearfix">
					<div class="form-group">
						<label for="MainModel_model_number" class="required">Model Number <span class="required">*</span></label> <input size="45" maxlength="45" id="modelno" class="text-input" name="MainModel[model_number]" type="text"> <input type="hidden" name="old_model_number" value="">
						<div id="suggestions-container"></div>
					</div>
					<div class="form-group text-right">
						<label for="MainModel_description" class="required">Description <span class="required">*</span></label> <input size="60" maxlength="255" class="text-input" name="MainModel[description]" id="MainModel_description" type="text">
					</div>
				</div>
				<div class="dealer clearfix">
					<div class="form-group model_image">
						<label for="MainModel_image_name">Image Name</label> <input id="ytMainModel_image_name" type="hidden" value="" name="MainModel[image_name]"><input class="M-tp" name="MainModel[image_name]" id="MainModel_image_name" type="file">
					</div>
				</div>
				<div class="dealer clearfix">
					<div class="form-group">
						<label for="MainModel_retail_price" class="required">Retail Price <span class="required">*</span></label> <input class="text-input" name="MainModel[retail_price]" id="MainModel_retail_price" type="text">
					</div>
					<div class="form-group text-right">

						<label for="MainModel_dealer_discount" class="required">Dealer Discount <span class="required">*</span></label> <input class="text-input" name="MainModel[dealer_discount]" id="MainModel_dealer_discount" type="text">
					</div>
				</div>
				<div class="dealer xmargn-lt clearfix">
					<div class="form-group ">
						<label for="MainModel_substitute_model_number">Substitute Model Number</label> <input class="text-input" name="MainModel[substitute_model_number]" id="MainModel_substitute_model_number" type="text" maxlength="255">
					</div>
					<div class="form-group ">
						<div class="checkbox">
							<input id="ytMainModel_part_collection" type="hidden" value="0" name="MainModel[part_collection]"><input name="MainModel[part_collection]" id="MainModel_part_collection" value="1" type="checkbox"> <label for="MainModel_part_collection">Part Collection</label>
						</div>
					</div>
				</div>
				<div class="dealer margn-lt clearfix">
					<div class="radio">
						<input value="1" name="MainModel[is_publish]" id="MainModel_is_publish" type="radio"> <label for="MainModel_is_publish">Publish in Machine &amp; parts list only</label>

					</div>
					<div class="radio">
						<input value="2" id="MainModel_display_model" name="MainModel[is_publish]" type="radio"> <label for="MainModel_display_model">Display model for parts</label>
					</div>
					<div class="radio">
						<input value="0" id="MainModel_reset" name="MainModel[is_publish]" checked="checked" type="radio"> <label for="MainModel_reset">Publish On Both</label>
					</div>
				</div>
				<div class="dealer margn-lt clearfix">
					<div class="form-group">
						<div class="checkbox">
							<input id="ytMainModel_no_longer_available" type="hidden" value="0" name="MainModel[no_longer_available]"><input name="MainModel[no_longer_available]" id="MainModel_no_longer_available" value="1" type="checkbox"> <label for="MainModel_no_longer_available">No Longer Available</label>
						</div>
					</div>
				</div>
				<?php wp_nonce_field('report_nonce_action', 'report_nonce_field'); ?>
				<div class="dealer margn-left checkbox clearfix">
					<div class="form-group">
						<input class="dealer-btn" type="submit" name="submit" value="Create">
					</div>
				</div>

			</form>
			<br />

		</div>
<?php
	}
}

if (is_admin()) {
	$option_page = new Atom_dealer_setting_pages();
}
