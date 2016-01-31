<!DOCTYPE html>
<meta charset="utf8">

<?php
require_once 'gSpider_list.php';
require_once 'simple_html_dom.php';
//Generate your own API key for Google CSE and add to $key variable
$key = 'YOUR-API-KEY';
//Here need to add sites you want to ignore, i.e.: +-gov.com+-mysite.net+-etc.org OR just make this filed empty i.e.: $minussite = '';
$minussite = 'ADD SITES YOU WISH TO NOT PARSE'
foreach($gSpider_list as $inurl) {
              $ch = curl_init();
                  curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/customsearch/v1?key='.$key.'&num=10&gl=BY&q=site:BY+intext:sql+syntax+inurl:'.$inurl.$minussite);
                  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.35 (KHTML, like Gecko) Chrome/42.0.2272.118 Safari/537.36');
                  curl_setopt($ch, CURLOPT_HEADER, 0);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Language: en'));
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                  $encoded_data = curl_exec($ch);
                  curl_close($ch);
                  $data = json_decode($encoded_data);
$splitItems = array();
foreach($data->items as $items) {
	$splitItems[] = $items;
}
 foreach($splitItems as $item) {
 	 $html = str_get_html($item->htmlSnippet);
 	 $check = $html->find('b, 1');
 	 if($check) {
 	 	foreach($html->find('b, 1') as $b){
 	 		$sql_check = $b->plaintext;
 	 	}
 	 }
 	 if($sql_check == 'SQL syntax') {
	 	echo "<pre>".$item->link." | ".$item->htmlSnippet." | ".$item->displayLink."</pre>";
	 }
	
 }
}
?>
