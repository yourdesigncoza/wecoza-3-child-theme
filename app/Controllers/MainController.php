<?php
/**
 * MainController.php
 *
 * Controller for handling theme-wide shared data and functionality
 */

namespace WeCoza\Controllers;

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
     * Additional shared methods can be added here
     */
}
