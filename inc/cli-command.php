<?php
/**
 * WP-CLI command for forced refresh of the API data.
 * Command: wp gs-api-data refresh
 *
 * @package gabischiopu
 */

declare( strict_types=1 );

namespace GS\AM\CLICommand;

use function GS\AM\APIFunctions\make_data_request;
use WP_CLI;

if ( ! defined( 'WP_CLI' ) ) {
    return;
}

/**
 * Refresh the API data.
 */
class GS_CLI_Refresh_Command {

    public function refresh() {
        make_data_request(true);
        WP_CLI::success( 'Data refreshed successfully!' );
    }
}

/**
 * Register the CLI command.
 */
function register_cli_command() {
    WP_CLI::add_command( 'gs-api-data', __NAMESPACE__ . '\\GS_CLI_Refresh_Command' );
}

add_action( 'cli_init', __NAMESPACE__ . '\\register_cli_command' );
