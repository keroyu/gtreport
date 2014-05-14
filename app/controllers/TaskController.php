<?php 

class TaskController extends BaseController {

	public function ajaxTaskAdd()
	{
		$reportSN = Input::get('reportSN');
		$pjSN = Input::get('pjSN');
		$taskName = Input::get('taskName');
		$type = Input::get('type');
		$progress = Input::get('progress');
		$status = Input::get('status');
		$designer = Input::get('designer');
		$cowork = Input::get('cowork');
		$url = Input::get('url');

		$data = array(
			'report' => $reportSN,
			'project' => $pjSN,
			'name' => $taskName,
			'type' => $type,
			'progress' => $progress,
			'designer' => $designer
		);

		if( $status !='' ) $data['status'] = $status;
		if( $cowork !='' ) $data['cowork'] = $cowork;
		if( $url !='' ) $data['url'] = $url;
		DB::table('task')->insert( $data );

		return '新增專案成功!';
	}

	public function ajaxTaskEdit()
	{
		$reportSN = Input::get('reportSN');
		$taskSN = Input::get('taskSN');
		$pjSN = Input::get('pjSN');
		$taskName = Input::get('taskName');
		$type = Input::get('type');
		$progress = Input::get('progress');
		$status = Input::get('status');
		$designer = Input::get('designer');
		$cowork = Input::get('cowork');
		$url = Input::get('url');

		$data = array(
			'report' => $reportSN,
			'project' => $pjSN,
			'name' => $taskName,
			'type' => $type,
			'progress' => $progress,
			'designer' => $designer
		);

		if( $status !='' ) $data['status'] = $status;
		if( $cowork !='' ) $data['cowork'] = $cowork;
		if( $url !='' ) $data['url'] = $url;
		try{
			DB::table('task')->where('sn', $taskSN )->update( $data );
			return '修改專案成功!';
		}catch(\Exception $e){
			return '修改專案失敗!';
		}
	}

	public function ajaxTaskDel()
	{
		$sn = Input::get('sn');
		DB::table('task')->where('sn',$sn)->delete();
		return '刪除專案成功!';
	}
}
?>