<?php 

class ProjectController extends BaseController {

	public function showProjectPage()
	{	
		$data['thisPage'] = 'projects';

		/* GET ALL AVAILABLE PROJECTS */
		$res =DB::table('project')->lists('name');
		$data['projectJson'] = json_encode($res);

		return View::make('projects', $data);
	}

	public function ajaxProjectList()
	{
		$projectList = DB::table('project')->orderBy('sn', 'desc')->get();
		$data['projectList'] = $projectList;
		return View::make('ajax/projectList', $data);
	}

	public function ajaxProjectAdd()
	{
		$name = Input::get('name');
		$res = DB::table('project')->where('name', $name)->get();
		if( count( $res ) >0 ){
			return '這個專題名稱已經存在!';
		}else{
			DB::table('project')->insert( array ('name' => $name) );
			return  '專題名稱新增成功!';
		}
	}

	public function ajaxProjectEdit()
	{
		$sn = Input::get('sn');
		$name = Input::get('name');
		$data = array ( 'name' => $name );
		DB::table('project')->where('sn', $sn )->update( $data );
		return '修改專題名稱成功!';
	}
	public function ajaxProjectDisplayControl()
	{
		$sn = Input::get('sn');
		$display = Input::get('display');
		$data = array ( 'display' => $display );
		DB::table('project')->where('sn', $sn)->update( $data );
		return '修改專題顯示狀態成功!';
	}
}
?>