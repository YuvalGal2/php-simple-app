<?php
require_once "classes/analytics/Calculation.php";

$getNetSales = Calculation::getNetSales();
echo " Net Sales:  {$getNetSales} <br>";

$getProductionCosts = Calculation::getProductionCosts();
echo " ProductionCosts:  {$getProductionCosts} <br>";

$grossProfit = $getNetSales - $getProductionCosts;
echo " grossProfit:  {$grossProfit} <br>";

$grossMargin = ($getNetSales - $getProductionCosts) / $getNetSales * 100;
echo " grossMargin:  {$grossMargin} <br>";


echo "<br>
<pre> 
    Hey Guys, you need to know about me i'm almost always using laravel and oop, 
    i've made some things here and there which are made in order to save some times for this tests but i've also made some extras
    like the InitApp.php which sets up the app for you :) 
    I'm an exprienced team leader but i can always learn more and study more and i'm really open for that;
    i've used vim, phpstorm for this tasks as editor, so sorry if you see some indication problems, tried to fix them all
    </pre>";