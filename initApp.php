<?php

require_once("classes/db/DBConnection.php");
define("API_USERNAME","tzinch");
define("API_PASSWORD","r#eD21mA%gNU");
define("URL","https://www.become.co/api/rest/test");
class Initialize {
  
  public function checkIfInitalized() {
    $dbConnection = new DBConnection();
	$this->database = $dbConnection->connect();
	$this->createAppFromMockData();

  }  
  private function createAppFromMockData(){
    $response = $this->sendRequest();
    $response = json_decode($response);
	$dbRes = $response->data;
	$this->createTables();
	$this->insertDataToDB($dbRes);
  }	
  private function insertDataToDB($payload = null) {
	  foreach($payload as $row) {
		 var_dump($row);
		$this->database->query('insert into shops(shop_id,closed_at)
	    values('.$row->shop_ID.', 0 )
		');
		
		$this->database->query(
		'insert into shop_items ( shop_id, total_order_shipping_cost, total_order_handling_cost,  total_production_cost) 
		values(
		'.$row->shop_ID.','.$row->total_order_shipping_cost.','
		.$row->total_order_handling_cost.','.$row->total_production_cost.')');
				
		$this->database->query(
		'insert into shop_orders ( total_items, order_id, shop_id,created_at, updated_at, total_price,subtotal_price, 
		total_weight,total_tax,currency, financial_status,name,
		processed_at,fulfillment_status,country,province ) 
		values(
		'.$row->total_items.','.$row->order_ID.','.$row->shop_ID.','.$row->created_at.','
		.$row->updated_at.','.$row->total_price.','.$row->subtotal_price.','.$row->total_weight.','
		.$row->total_tax.','.$row->currency.','.$row->financial_status.','
		.$row->name.','.$row->processed_at.','.$row->fulfillment_status.','.$row->country.','
		.$row->province.'
		)
		');
	  }
  }
  private function createTables(){  
	  // could split.. but i dont have enough time.
	 $queries = [
	 "CREATE TABLE shops (
        shop_id varchar(99) PRIMARY KEY UNIQUE,
        closed_at varchar(99) )", // wanted to do it timestamp, but because of bugs of null (nullable didn't work) and time..
		
	 "CREATE TABLE customers (
        customer_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY)",	
		
	 "CREATE TABLE customers_orders (
	   customer_id INT(6) UNSIGNED,
	   order_id INT(32) UNSIGNED)",
	   
	"CREATE TABLE shop_orders (
	  total_items INT(6),
	  order_id INT(32),
	  shop_id varchar(99),
	  created_at varchar(99),
	  updated_at varchar(99),
	  total_price INT(6),
	  subtotal_price INT(6),
	  total_weight INT(6),
	  total_tax INT(6),
	  currency VARCHAR(10),
	  financial_status VARCHAR(12),
	  total_discounts INT(6),
	  name VARCHAR(12),
	  processed_at TIMESTAMP NULL,
	  fulfillment_status VARCHAR(32),
	  country VARCHAR(6),
	  province VARCHAR(6) NULL
	  )",
	
	"CREATE TABLE shop_items (
	  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      shop_id varchar(99),
	  total_order_shipping_cost INT(6),
	  total_order_handling_cost INT(6),
	  total_production_cost INT(6))"
	  ];
	  
	 foreach( $queries as $query) {
		  $this->database->query($query);
	 }
  }
  private function sendRequest() {
  $opts = array(
    'http'=>array(
      'method'=>"GET",
      'header' => "Authorization: Basic " . base64_encode(API_USERNAME.':'.API_PASSWORD)
    )
  );
  $context = stream_context_create($opts);
  $response = file_get_contents(URL, false, $context);
  return $response;
  }
}

$init = new Initialize();
$init->checkIfInitalized();
?>`
