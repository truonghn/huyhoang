<?php
if ( ! defined( 'PB_IMPORTBUDDY' ) || ( true !== PB_IMPORTBUDDY ) ) {
	die( '<html></html>' );
}
Auth::require_authentication(); // Die if not logged in.
pb_backupbuddy::set_greedy_script_limits( true );
pb_backupbuddy::load_view( '_iframe_header');
echo "<script>pageTitle( 'Step 2: Restoring Files' );</script>";
echo "<script>bb_showStep( 'unzippingFiles' );</script>";
pb_backupbuddy::flush();

// Determine selected archive file.
$archiveFile = str_replace( array( '\\', '/' ), '', pb_backupbuddy::_POST( 'file' ) );
if ( ! file_exists( ABSPATH . $archiveFile ) ) {
	die( 'Error #834984: Specified backup archive `' . htmlentities( $archiveFile ) . '` not found. Did you delete it? If the file exists, try again or verify proper read file permissions for PHP to access the file.' );
}

// Instantiate restore class.
require_once( pb_backupbuddy::plugin_path() . '/classes/restore.php' );
$restore = new backupbuddy_restore( 'restore' );
$status = $restore->start( $archiveFile );
if ( false === $status ) {
	$errors = $restore->getErrors();
	if ( count( $errors ) > 0 ) {
		$errorMsg = 'Errors were encountered: ' . implode( ', ', $errors ) . ' If seeking support please click to Show Advanced Details above and provide a copy of the log.';
		pb_backupbuddy::status( 'error', $errorMsg );
	} else {
		$errorMsg = 'Error #894383: Unknown error starting restore. See advanced status log for details.';
	}
	pb_backupbuddy::alert( $errorMsg );
	return;
}

$restore->_state['defaultURL'] = $restore->getDefaultUrl();
$restore->_state['defaultDomain'] = $restore->getDefaultDomain();
$restore->_state = parse_options( $restore->_state );

// Set up state variables.
if ( ( 'db' == $restore->_state['dat']['backup_type'] ) || ( false == $restore->_state['restoreFiles'] ) ) {
	pb_backupbuddy::status( 'details', 'Database backup OR not restoring files.' );
	$restore->_state['tempPath'] = ABSPATH . 'importbuddy/temp_' . pb_backupbuddy::random_string( 12 ) . '/';
	$restore->_state['restoreFileRoot'] = $restore->_state['tempPath'];
	pb_backupbuddy::anti_directory_browsing( $restore->_state['restoreFileRoot'], $die = false );
} else {
	pb_backupbuddy::status( 'details', 'Restoring files.' );
	$restore->_state['restoreFileRoot'] = ABSPATH; // Restore files into current root.
}

// Parse submitted options for saving to state.
function parse_options( $restoreData ) {
	
	if ( '1' == pb_backupbuddy::_POST( 'restoreFiles' ) ) { $restoreData['restoreFiles'] = true; } else { $restoreData['restoreFiles'] = false; }
	if ( '1' == pb_backupbuddy::_POST( 'restoreDatabase' ) ) { $restoreData['restoreDatabase'] = true; } else { $restoreData['restoreDatabase'] = false; }
	if ( '1' == pb_backupbuddy::_POST( 'migrateHtaccess' ) ) { $restoreData['migrateHtaccess'] = true; } else { $restoreData['migrateHtaccess'] = false; }
	
	if ( ( 'all' == pb_backupbuddy::_POST( 'zipMethodStrategy' ) ) || ( 'ziparchive' == pb_backupbuddy::_POST( 'zipMethodStrategy' ) ) || ( 'pclzip' == pb_backupbuddy::_POST( 'zipMethodStrategy' ) ) ) {
		$restoreData['zipMethodStrategy'] = pb_backupbuddy::_POST( 'zipMethodStrategy' );
	}
	
	/*
	if ( ( isset( $_POST['log_level'] ) ) && ( $_POST['log_level'] != '' ) ) {
		pb_backupbuddy::$options['log_level'] = $_POST['log_level'];
	} else {
		pb_backupbuddy::$options['log_level'] = '';
	}
	*/
	
	return $restoreData;
	
} // End parse_options().


// Turn on maintenance mode for WordPress to prevent browsing the site until it is fully imported.
$restore->maintenanceOn();




if ( false === $restore->_state['restoreFiles'] ) {
	pb_backupbuddy::status( 'details', 'SKIPPING restore of files based on settings from Step 1.' );
	echo "<script>bb_action( 'filesRestoreSkipped' );</script>";
} else {
	// Unzip backup archive.
	$results = $restore->restoreFiles();
	if ( true !== $results ) { // Unzip failed.
		pb_backupbuddy::alert( 'File extraction process did not complete successfully. Unable to continue to next step. Manually extract the backup ZIP file and choose to "Skip File Extraction" from the advanced options on Step 1. Details: ' . $restore->getErrors(), true, '9005' );
	} else { // Unzip success.
		echo "<script>bb_action( 'unzipSuccess' );</script>";
		echo "<script>bb_action( 'filesRestoreSuccess' );</script>";
	}
}

// On unzip success OR skipping unzip.
if ( ( false === $restore->_state['restoreFiles'] ) || ( true === $results ) ) {
	$restore->determineDatabaseFiles();
	$restore->renameHtaccessTemp(); // Rename .htaccess to .htaccess.bb_temp until end of migration.
	?>
	<script>
		setTimeout( function(){
			pageTitle( 'Step 3: Database Settings' );
			bb_showStep( 'databaseSettings', <?php echo json_encode( $restore->_state ); ?> );
		}, 2000);
	</script>
	<?php
}


// Load footer.
pb_backupbuddy::load_view( '_iframe_footer');
