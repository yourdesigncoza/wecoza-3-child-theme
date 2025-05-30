<?php
/**
 * MainController.php
 *
 * Controller for handling theme-wide shared data and functionality
 */

namespace WeCoza\Controllers;

use WeCoza\Controllers\ClassTypesController;

class MainController {
    /**
     * Constructor
     */
    public function __construct() {
        // Register WordPress hooks if needed
    }

    /**
     * Get all SETA options
     *
     * @return array List of SETA options
     */
    public static function getSeta() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            ['id' => 'AgriSETA', 'name' => 'AgriSETA'],
            ['id' => 'BANKSETA', 'name' => 'BANKSETA'],
            ['id' => 'CATHSSETA', 'name' => 'CATHSSETA'],
            ['id' => 'CETA', 'name' => 'CETA'],
            ['id' => 'CHIETA', 'name' => 'CHIETA'],
            ['id' => 'ETDP SETA', 'name' => 'ETDP SETA'],
            ['id' => 'EWSETA', 'name' => 'EWSETA'],
            ['id' => 'FASSET', 'name' => 'FASSET'],
            ['id' => 'FP&M SETA', 'name' => 'FP&M SETA'],
            ['id' => 'FoodBev SETA', 'name' => 'FoodBev SETA'],
            ['id' => 'HWSETA', 'name' => 'HWSETA'],
            ['id' => 'INSETA', 'name' => 'INSETA'],
            ['id' => 'LGSETA', 'name' => 'LGSETA'],
            ['id' => 'MICT SETA', 'name' => 'MICT SETA'],
            ['id' => 'MQA', 'name' => 'MQA'],
            ['id' => 'PSETA', 'name' => 'PSETA'],
            ['id' => 'SASSETA', 'name' => 'SASSETA'],
            ['id' => 'Services SETA', 'name' => 'Services SETA'],
            ['id' => 'TETA', 'name' => 'TETA'],
            ['id' => 'W&RSETA', 'name' => 'W&RSETA'],
            ['id' => 'merSETA', 'name' => 'merSETA']
        ];
    }

    /**
     * Get all products from the database
     *
     * @return array List of products
     */
    public static function getProducts() {
        try {
            // Get database connection
            $db = \WeCoza\Services\Database\DatabaseService::getInstance();

            // Query the products table
            $query = "SELECT product_id, product_name, product_duration, learning_area,
                      learning_area_duration, parent_product_id
                      FROM products
                      ORDER BY product_name ASC";

            $stmt = $db->query($query);
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // If no products found, return empty array
            if (empty($products)) {
                return [];
            }

            // Format the products for the view
            $formatted_products = [];
            foreach ($products as $product) {
                // Create a basic product entry with required fields
                $formatted_product = [
                    'id' => isset($product['product_id']) ? $product['product_id'] : (isset($product['id']) ? $product['id'] : 0),
                    'name' => isset($product['product_name']) ? $product['product_name'] : (isset($product['name']) ? $product['name'] : 'Unknown Product')
                ];

                // Add optional fields if they exist
                if (isset($product['product_duration'])) {
                    $formatted_product['duration'] = $product['product_duration'];
                }

                if (isset($product['learning_area'])) {
                    $formatted_product['learning_area'] = $product['learning_area'];
                }

                if (isset($product['learning_area_duration'])) {
                    $formatted_product['learning_area_duration'] = $product['learning_area_duration'];
                }

                if (isset($product['parent_product_id'])) {
                    $formatted_product['parent_product_id'] = $product['parent_product_id'];
                }

                $formatted_products[] = $formatted_product;
            }

            return $formatted_products;
        } catch (\Exception $e) {
            // Log only critical errors
            error_log('Error fetching products: ' . $e->getMessage());

            // Return empty array in case of error
            return [];
        }
    }

    /**
     * Get all class types
     *
     * @return array List of class types
     */
    public static function getClassType() {
        // Use the dedicated ClassTypesController to get class types
        return ClassTypesController::getClassTypes();
    }

    /**
     * Get Yes/No options
     *
     * @return array List of Yes/No options
     */
    public static function getYesNoOptions() {
        return [
            ['id' => 'Yes', 'name' => 'Yes'],
            ['id' => 'No', 'name' => 'No']
        ];
    }

    /**
     * Get class notes options
     *
     * @return array List of class notes options
     */
    public static function getClassNotesOptions() {
        return [
            ['id' => 'Agent Absent', 'name' => 'Agent Absent'],
            ['id' => 'Client Cancelled', 'name' => 'Client Cancelled'],
            ['id' => 'Poor attendance', 'name' => 'Poor attendance'],
            ['id' => 'Learners behind schedule', 'name' => 'Learners behind schedule'],
            ['id' => 'Learners unhappy', 'name' => 'Learners unhappy'],
            ['id' => 'Client unhappy', 'name' => 'Client unhappy'],
            ['id' => 'Learners too fast', 'name' => 'Learners too fast'],
            ['id' => 'Class on track', 'name' => 'Class on track'],
            ['id' => 'Bad QA report', 'name' => 'Bad QA report'],
            ['id' => 'Good QA report', 'name' => 'Good QA report'],
            ['id' => 'Incomplete workbooks', 'name' => 'Incomplete workbooks']
        ];
    }

    /**
     * Get all clients
     *
     * @return array List of clients
     */
    public static function getClients() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            ['id' => 11, 'name' => 'Aspen Pharmacare'],
            ['id' => 14, 'name' => 'Barloworld'],
            ['id' => 9, 'name' => 'Bidvest Group'],
            ['id' => 8, 'name' => 'FirstRand'],
            ['id' => 4, 'name' => 'MTN Group'],
            ['id' => 15, 'name' => 'Multichoice Group'],
            ['id' => 5, 'name' => 'Naspers'],
            ['id' => 12, 'name' => 'Nedbank Group'],
            ['id' => 10, 'name' => 'Sanlam'],
            ['id' => 1, 'name' => 'Sasol Limited'],
            ['id' => 3, 'name' => 'Shoprite Holdings'],
            ['id' => 2, 'name' => 'Standard Bank Group'],
            ['id' => 13, 'name' => 'Tiger Brands'],
            ['id' => 6, 'name' => 'Vodacom Group'],
            ['id' => 7, 'name' => 'Woolworths Holdings']
        ];
    }

    /**
     * Get all sites
     *
     * @return array List of sites grouped by client
     */
    public static function getSites() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            11 => [ // Aspen Pharmacare
                ['id' => '11_1', 'name' => 'Aspen Pharmacare - Head Office'],
                ['id' => '11_2', 'name' => 'Aspen Pharmacare - Production Unit'],
                ['id' => '11_3', 'name' => 'Aspen Pharmacare - Research Centre']
            ],
            14 => [ // Barloworld
                ['id' => '14_1', 'name' => 'Barloworld - Northern Branch'],
                ['id' => '14_2', 'name' => 'Barloworld - Southern Branch'],
                ['id' => '14_3', 'name' => 'Barloworld - Central Branch']
            ],
            // Additional clients would be added here
        ];
    }

    /**
     * Get site addresses
     *
     * @return array Mapping of site IDs to addresses
     */
    public static function getSiteAddresses() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            // Aspen Pharmacare
            "11_1" => "Aspen Pharmacare - Head Office, 100 Pharma Rd, Durban, 4001",
            "11_2" => "Aspen Pharmacare - Production Unit, 101 Pharma Rd, Durban, 4001",
            "11_3" => "Aspen Pharmacare - Research Centre, 102 Pharma Rd, Durban, 4001",

            // Barloworld
            "14_1" => "Barloworld - Northern Branch, 10 Northern Ave, Johannesburg, 2001",
            "14_2" => "Barloworld - Southern Branch, 20 Southern St, Johannesburg, 2002",
            "14_3" => "Barloworld - Central Branch, 30 Central Blvd, Johannesburg, 2003",

            // Additional sites would be added here
        ];
    }

    /**
     * Get all agents
     *
     * @return array List of agents
     */
    public static function getAgents() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            ['id' => 1, 'name' => 'Michael M. van der Berg'],
            ['id' => 2, 'name' => 'Thandi T. Nkosi'],
            ['id' => 3, 'name' => 'Rajesh R. Patel'],
            ['id' => 4, 'name' => 'Lerato L. Moloi'],
            ['id' => 5, 'name' => 'Johannes J. Pretorius'],
            ['id' => 6, 'name' => 'Nomvula N. Dlamini'],
            ['id' => 7, 'name' => 'David D. O\'Connor'],
            ['id' => 8, 'name' => 'Zanele Z. Mthembu'],
            ['id' => 9, 'name' => 'Pieter P. van Zyl'],
            ['id' => 10, 'name' => 'Fatima F. Ismail'],
            ['id' => 11, 'name' => 'Sipho S. Ndlovu'],
            ['id' => 12, 'name' => 'Anita A. van Rensburg'],
            ['id' => 13, 'name' => 'Themba T. Mkhize'],
            ['id' => 14, 'name' => 'Sarah S. Botha'],
            ['id' => 15, 'name' => 'Lwazi L. Zuma']
        ];
    }

    /**
     * Get all supervisors
     *
     * @return array List of supervisors
     */
    public static function getSupervisors() {
        // This would typically come from a database query
        // For now, returning static data
        return [
            ['id' => 1, 'name' => 'Ethan J. Williams'],
            ['id' => 2, 'name' => 'Aisha K. Mohamed'],
            ['id' => 3, 'name' => 'Carlos M. Rodriguez'],
            ['id' => 4, 'name' => 'Emily R. Thompson'],
            ['id' => 5, 'name' => 'Samuel B. Johnson'],
            ['id' => 6, 'name' => 'Lungile T. Mthethwa'],
            ['id' => 7, 'name' => 'David C. Martins'],
            ['id' => 8, 'name' => 'Zanele P. Khumalo'],
            ['id' => 9, 'name' => 'Johan D. Venter'],
            ['id' => 10, 'name' => 'Fatima H. Desai'],
            ['id' => 11, 'name' => 'Sipho M. Zondi'],
            ['id' => 12, 'name' => 'Annelize S. du Preez'],
            ['id' => 13, 'name' => 'Themba L. Sithole'],
            ['id' => 14, 'name' => 'Sophia V. Naidoo'],
            ['id' => 15, 'name' => 'Mandla N. Dube']
        ];
    }

    /**
     * Get all learners for exam selection
     *
     * @return array List of learners available for exam classes
     */
    public static function getLearnersExam() {
        // This would typically come from a database query
        // For now, returning static data for exam selection
        return [
            ['id' => 1, 'name' => 'John J.M. Smith'],
            ['id' => 2, 'name' => 'Nosipho N. Dlamini'],
            ['id' => 3, 'name' => 'Ahmed A. Patel'],
            ['id' => 4, 'name' => 'Lerato L. Moloi'],
            ['id' => 5, 'name' => 'Pieter P. van der Merwe'],
            ['id' => 6, 'name' => 'Thandi T. Nkosi'],
            ['id' => 7, 'name' => 'Daniel D. O\'Connor'],
            ['id' => 8, 'name' => 'Zinhle Z. Mthembu'],
            ['id' => 9, 'name' => 'Willem W. Botha'],
            ['id' => 10, 'name' => 'Nomsa N. Tshabalala'],
            ['id' => 11, 'name' => 'Raj R. Singh'],
            ['id' => 12, 'name' => 'Emma E. van Wyk'],
            ['id' => 13, 'name' => 'Sibusiso S. Ngcobo'],
            ['id' => 14, 'name' => 'Charmaine C. Pillay'],
            ['id' => 15, 'name' => 'Themba T. Maseko'],
            ['id' => 23, 'name' => 'Sibusiso eryery. Montgomery'],
            ['id' => 24, 'name' => 'John2 ey. Montgomery'],
            ['id' => 25, 'name' => 'John2 y ery. Montgomery3'],
            ['id' => 35, 'name' => 'Peter P.J. Wessels'],
            ['id' => 36, 'name' => 'Peter 2 P.J. Wessels2'],
            ['id' => 37, 'name' => 'Comm Nume. Wessels']
        ];
    }

    /**
     * Additional shared methods can be added here
     */
}
