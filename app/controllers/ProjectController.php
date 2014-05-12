<?php 

class ProjectController extends BaseController {

	public function ajaxProjectAdd()
	{
		$name = Input::get('name');
		$res = DB::table('project')->where('name', $name)->get();
		if( count( $res ) >0 ){
			return '<span class="alert">這個專題名稱已經存在!</span>';
		}else{
			DB::table('project')->insert( array ('name' => $name) );
			return  '專題名稱新增成功!';
		}
	}
}
?>