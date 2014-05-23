<?php 
class Common extends Eloquent{
	$menuItems = [ 
		'/' => , 'Home',
		'project' => '專題管理頁面',
		'report' => '報告頁'
	];

	public function showSomething(){
		return '111111';
	}
}
 ?>