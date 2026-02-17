<?php
/**
 * Functions for ECharts data processing.
 *
 * @package WeCoza_3_Child_Theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Get chart data from a stored SQL query.
 *
 * @param int $sql_id The stored query ID.
 * @return array|WP_Error Chart data array or error.
 */
function wecoza_get_chart_data( int $sql_id ): array|WP_Error {
    $query_data = Wecoza3_Logger::get_query_by_id( $sql_id );

    if ( ! $query_data ) {
        return new WP_Error( 'query_not_found', __( 'SQL query not found.', 'wecoza' ) );
    }

    try {
        $db      = new Wecoza3_DB();
        $pdo     = $db->get_pdo();
        $stmt    = $pdo->query( $query_data->sql_query );
        $results = $stmt->fetchAll( PDO::FETCH_ASSOC );
    } catch ( PDOException $e ) {
        error_log( 'WeCoza chart query error: ' . $e->getMessage() );
        return new WP_Error( 'query_execution_error', __( 'Failed to execute chart query.', 'wecoza' ) );
    }

    // The query returns a single row with a 'data' column containing the JSON.
    if ( isset( $results[0]['data'] ) ) {
        $data = json_decode( $results[0]['data'], true );
        if ( is_array( $data ) ) {
            return $data;
        }
    }

    return new WP_Error( 'invalid_data_format', __( 'The SQL query did not return data in the expected format.', 'wecoza' ) );
}

/**
 * Get ECharts option configuration for a chart type.
 *
 * @param string $type Chart type (tree, sunburst).
 * @param array  $data Chart data.
 * @return array|WP_Error Chart options or error.
 */
function wecoza_get_chart_option( string $type, array $data ): array|WP_Error {
    return match ( $type ) {
        'tree'     => wecoza_get_tree_option( $data ),
        'sunburst' => wecoza_get_sunburst_option( $data ),
        default    => new WP_Error( 'invalid_chart_type', __( 'Invalid chart type.', 'wecoza' ) ),
    };
}

/**
 * Get tree chart configuration.
 *
 * @param array $data Tree data.
 * @return array ECharts tree option.
 */
function wecoza_get_tree_option( array $data ): array {
    return [
        'tooltip' => [
            'trigger' => 'item',
            'triggerOn' => 'mousemove'
        ],
        'series' => [
            [
                'type' => 'tree',
                'data' => $data,
                'top' => '1%',
                'left' => '7%',
                'bottom' => '1%',
                'right' => '20%',
                'symbolSize' => 7,
                'label' => [
                    'position' => 'left',
                    'verticalAlign' => 'middle',
                    'align' => 'right',
                    'fontSize' => 9
                ],
                'leaves' => [
                    'label' => [
                        'position' => 'right',
                        'verticalAlign' => 'middle',
                        'align' => 'left'
                    ]
                ],
                'emphasis' => [
                    'focus' => 'descendant'
                ],
                'expandAndCollapse' => true,
                'animationDuration' => 550,
                'animationDurationUpdate' => 750
            ]
        ]
    ];
}

/**
 * Get sunburst chart configuration.
 *
 * @param array $data Sunburst data.
 * @return array ECharts sunburst option.
 */
function wecoza_get_sunburst_option( array $data ): array {
    return [
        'tooltip' => [
            'trigger' => 'item'
        ],
        'series' => [
            [
                'type' => 'sunburst',
                'data' => $data,
                'radius' => [0, '90%'],
                'label' => [
                    'rotate' => 'radial'
                ],
                'itemStyle' => [
                    'borderRadius' => 7,
                    'borderWidth' => 2
                ],
                'levels' => [
                    [],
                    [
                        'r0' => '15%',
                        'r' => '35%',
                        'itemStyle' => [
                            'borderWidth' => 2
                        ],
                        'label' => [
                            'rotate' => 'tangential'
                        ]
                    ],
                    [
                        'r0' => '35%',
                        'r' => '70%',
                        'label' => [
                            'align' => 'right'
                        ]
                    ],
                    [
                        'r0' => '70%',
                        'r' => '72%',
                        'label' => [
                            'position' => 'outside',
                            'padding' => 3,
                            'silent' => false
                        ],
                        'itemStyle' => [
                            'borderWidth' => 3
                        ]
                    ]
                ]
            ]
        ]
    ];
}
