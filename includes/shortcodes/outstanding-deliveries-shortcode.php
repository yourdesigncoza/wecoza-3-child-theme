<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Function to generate demo data
function wecoza_get_demo_deliveries() {
    return [
        [
            'client_name' => 'Acme Corporation',
            'subject' => 'Introduction to Programming',
            'site' => 'Cape Town Campus',
            'start_date' => '2024-03-15',
            'delivery_date' => '2024-03-10',
            'status' => 'Overdue'
        ],
        [
            'client_name' => 'TechSolutions Ltd',
            'subject' => 'Advanced Database Management',
            'site' => 'Johannesburg Office',
            'start_date' => '2024-03-22',
            'delivery_date' => '2024-03-18',
            'status' => 'Pending'
        ],
        [
            'client_name' => 'Global Innovations',
            'subject' => 'Artificial Intelligence Basics',
            'site' => 'Durban Learning Center',
            'start_date' => '2024-04-01',
            'delivery_date' => '2024-03-25',
            'status' => 'Pending'
        ],
        [
            'client_name' => 'EduTech Systems',
            'subject' => 'Web Development Fundamentals',
            'site' => 'Pretoria Hub',
            'start_date' => '2024-03-18',
            'delivery_date' => '2024-03-12',
            'status' => 'Overdue'
        ],
        [
            'client_name' => 'Quantum Learning',
            'subject' => 'Data Science Essentials',
            'site' => 'Bloemfontein Center',
            'start_date' => '2024-03-29',
            'delivery_date' => '2024-03-22',
            'status' => 'Pending'
        ]
    ];
}

// Shortcode for outstanding deliveries
function wecoza_outstanding_deliveries_shortcode() {
    // SQL query for outstanding deliveries
    $query = "
        SELECT c.id AS class_id, c.subject, c.site, c.start_date, d.delivery_date, cl.name AS client_name
        FROM classes c
        JOIN deliveries d ON c.id = d.class_id
        JOIN clients cl ON c.client_id = cl.id
        WHERE d.delivery_type = 'Book Supply'
        AND d.status != 'delivered'
        ORDER BY d.delivery_date ASC
    ";

    /*------------------YDCOZA-----------------------*/
    /* Initialize database connection and execute    */
    /* the query to fetch results.                   */
    /*-----------------------------------------------*/
    try {
        $db = new Wecoza3_DB();
        $pdo = $db->get_pdo();
    } catch (\Exception $e) {
        return wecoza_display_error_alert('Database Connection Error', 'There was an error connecting to the database. Please check your database settings and try again.');
    }

    try {
        $stmt = $pdo->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return wecoza_display_error_alert('Query Execution Error', 'There was an error executing the query. Please check the SQL and try again.');
    }

    // Use demo data if no results from the database
    if (empty($results)) {
        $results = wecoza_get_demo_deliveries();
    }
    
    $output = '<div class="table-responsive">
        <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>Client</th>
                <th>Subject</th>
                <th>Site</th>
                <th>Class Start Date</th>
                <th>Delivery Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';
    
    foreach ($results as $row) {
        $status = $row['status'] ?? (strtotime($row['delivery_date']) < time() ? 'Overdue' : 'Pending');
        $status_class = ($status === 'Overdue') ? 'text-danger fw-bold' : 'text-warning';
        
        $output .= "<tr>
            <td>{$row['client_name']}</td>
            <td>{$row['subject']}</td>
            <td>{$row['site']}</td>
            <td>" . date('Y-m-d', strtotime($row['start_date'])) . "</td>
            <td>" . date('Y-m-d', strtotime($row['delivery_date'])) . "</td>
            <td class='{$status_class}'>{$status}</td>
        </tr>";
    }
    
    $output .= '</tbody></table></div>';
    
    return $output;
}

// Register the shortcode
add_shortcode('wecoza_outstanding_deliveries', 'wecoza_outstanding_deliveries_shortcode');