<?php
require_once "classes/db/DBConnection.php";
class Calculation {
    public static function getSumOfFields($sumField, $additionalCondition = false)
    {
        // could made it generic via just putting an "in" statement and checking the condition dynamiclliy..
        $db = DBConnection::getDB();
        $query = "SELECT sum({$sumField}) as sum 
           FROM `shop_orders` where `financial_status` = 'paid'
           OR `financial_status` = 'partially_paid' ";
        if ($additionalCondition) {
            $query .= " AND '{$additionalCondition[0]}' = '{$additionalCondition[1]}'";
        }

        $resource = $db->query($query);
        $row = $resource->fetch_assoc();
        return $row['sum'];
    }
    public static function getNetSales() {
        return self::getSumOfFields('total_price');
    }
    public static function getProductionCosts() {
        return self::getSumOfFields('total_production_cost', ['fulfillment_status','fulfilled' ]);
    }

}