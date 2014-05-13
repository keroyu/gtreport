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
		$finishdate = Input::get('finishdate');
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
		if( $finishdate !='' ) $data['finishdate'] = $finishdate;
		if( $cowork !='' ) $data['cowork'] = $cowork;
		if( $url !='' ) $data['url'] = $url;
		DB::table('task')->insert( $data );

		return '新增專案成功!';
	}

	public function ajaxTaskDel()
	{
		$sn = Input::get('sn');
		DB::table('task')->where('sn',$sn)->delete();
	}
}
?>