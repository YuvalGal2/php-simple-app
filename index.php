<?php
require_once "classes/analytics/Calculation.php";


$getNetSales = Calculation::getProductionCosts();
echo " Net Sales:  {$getNetSales}";