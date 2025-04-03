<?php
/*------------------YDCOZA-----------------------*/
/* Shortcode for ECharts visualization           */
/* Usage: */
/* [wecoza_echart sql_id="9" type="tree" style="width:600px;height:400px;"] */
/* [wecoza_echart sql_id="2" type="sunburst" style="width:600px;height:400px;"] */
/*-----------------------------------------------*/

/*------------------YDCOZA-----------------------*/
/* Shortcode for ECharts visualization           */
/*-----------------------------------------------*/
function wecoza_echart_shortcode($atts) {
    $atts = shortcode_atts(array(
        'sql_id' => '',
        'type' => 'tree',
        'style' => 'width:600px;height:400px;',
    ), $atts);

    $sql_id = intval($atts['sql_id']);
    if (!$sql_id) {
        return '<p>' . __('Invalid SQL ID provided.', 'wecoza') . '</p>';
    }

    $chart_data = wecoza_get_chart_data($sql_id);
    if (is_wp_error($chart_data)) {
        return '<p>' . esc_html($chart_data->get_error_message()) . '</p>';
    }

    $chart_option = wecoza_get_chart_option($atts['type'], $chart_data);
    if (is_wp_error($chart_option)) {
        return '<p>' . esc_html($chart_option->get_error_message()) . '</p>';
    }

    $chart_id = 'wecoza-echart-' . uniqid();
    $output = '<div id="' . esc_attr($chart_id) . '" style="' . esc_attr($atts['style']) . '"></div>';
    $output .= '<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var chart = echarts.init(document.getElementById(' . json_encode($chart_id) . '));
            var option = ' . wp_json_encode($chart_option) . ';
            chart.setOption(option);
        });
    </script>';

    return $output;
}
add_shortcode('wecoza_echart', 'wecoza_echart_shortcode');

function wecoza_enqueue_echarts_script() {
    wp_enqueue_script('echarts', 'https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js', array(), '5.0.0', true);
}
add_action('wp_enqueue_scripts', 'wecoza_enqueue_echarts_script');
