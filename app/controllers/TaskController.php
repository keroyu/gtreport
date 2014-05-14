<?php 

class TaskController extends BaseController {

	public function ajaxTaskQuery($action)
	{
		$input = Input::all();
		$data = array(
			'report' => $input['reportSN'],
			'project' => $input['pjSN'],
			'name' => $input['taskName'],
			'type' => $input['type'],
			'progress' => $input['progress'],
			'designer' => $input['designer'],
			'status' => $input['status'],
			'cowork' => $input['cowork']
		);
		if( $input['url'] !='' ) $data['url'] = $input['url'];

		if( $action=='add' ){
			DB::table('task')->insert( $data );
			return '新增專案成功!';
		}
		if( $action=='edit' ){
			DB::table('task')->where('sn', $input['taskSN'] )->update( $data );
			return '修改專案成功!';
		}
		if( $action=='del' ){
			DB::table('task')->where('sn',$input['taskSN'])->delete();
			return '刪除專案成功!';
		}
	}
}
?>