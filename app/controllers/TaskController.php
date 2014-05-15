<?php 

class TaskController extends BaseController {

	public function ajaxTaskQuery($action)
	{
		$input = Input::all();

		if( $action=='add' ){
			$data = array(
				'report' => $input['reportSN'],
				'project' => $input['pjSN'],
				'name' => $input['taskName'],
				'type' => $input['type'],
				'progress' => $input['progress'],
				'designer' => $input['designer']
			);
			if( $input['url'] !='' ) $data['url'] = $input['url'];
			if( $input['status'] !='' ) $data['status'] = $input['status'];
			if( $input['cowork'] !='' ) $data['cowork'] = $input['cowork'];

			DB::table('task')->insert( $data );
			return '新增專案成功!';
		}
		if( $action=='edit' ){
			$data = array(
				'report' => $input['reportSN'],
				'project' => $input['pjSN'],
				'name' => $input['taskName'],
				'type' => $input['type'],
				'progress' => $input['progress'],
				'designer' => $input['designer'],
				'status' => $input['status'],
				'cowork' => $input['cowork'],
				'url' => $input['url']
			);

			DB::table('task')->where('sn', $input['taskSN'] )->update( $data );
			return '修改專案成功!';
		}
		if( $action=='del' ){
			DB::table('task')->where('sn', $input['taskSN'])->delete();
			return '刪除專案成功!';
		}
	}
}
?>