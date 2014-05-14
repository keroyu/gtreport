<?php 

class ReportController extends BaseController {
	
	public function index() 
	{
		return View::make('report_list');
	}

	public function ajaxReportList() 
	{
		$reports = DB::table('report')->get();
		$reportPrint = '';
		foreach( $reports as $report ){
			$reportPrint .= '<li><a href="report/' 
				. $report->sn . '/edit">週報表'. $report->start . '~' . $report->end . '</a></li>';
		}
		return $reportPrint;
	}

	public function ajaxReportAdd()
	{
		$start = Input::get('start');
		$end = Input::get('end');
		DB::table('report')->insert(
			array( 'start' => $start, 'end' => $end )
		);
		echo $start.' ~ '.$end;
	}

	public function showReport($id,$mode) 
	{
		$data['sn'] = $id;
		$data['mode'] = $mode;

		$res = DB::table('report')->where('sn', $id)->first();
		$print = $res->start .'~'. $res->end;
		$data['period'] = $print;

		$projects = DB::table('project')->get();
		$print = '<option value="">-</option>';
		foreach( $projects as $project)
		{
			$print .= '<option value="' . $project->sn.'">' . $project->name . '</option>';
		}
		$data['selectPj'] = $print;

		return View::make('report', $data);
	}

	public function ajaxReportTable($id)
	{
		/* 取得該 report 涵蓋的所有 project */
		$res = DB::table('task')->where('report', $id)->get();
		if( count($res) >0 ){
			foreach( $res as $tasks )
			{
				$projectArray[] = $tasks->project;
			}
			$projectArray = array_unique($projectArray);
			$print = '';
			/* GET TASKS OF THIS PROJECT */
			foreach( $projectArray as $projectSN )
			{
				/* GET PROJECT NAME */
				$res = DB::table('project')->where('sn',$projectSN)->pluck('name');
				$print .= '<p class="project-title">' . $res . '</p>';

				/* GET ALL TYPE */
				$res = DB::table('task')->select('type')->distinct()->orderBy('type', 'desc')->where('report',$id)->where('project', $projectSN)->get();
				unset($typeArray);
				foreach( $res as $type ){  $typeArray[] = $type->type; };

				/* PRINT ALL TYPES */
				foreach( $typeArray as $type )
				{
					switch( $type ){
						case 'W': $typeName = '網頁'; break;
						case 'P': $typeName = '平面'; break;
						case 'M': $typeName = '多媒體'; break;
					}
					$tasks = DB::table('task')->where('project',$projectSN)->where('type',$type)->where('report',$id)->get();
					$print .= '<p class="pj-type">' . $typeName . '</p>
					<table cellspacing="0" cellpadding="3">
						<tr class="pj-dt-hd"><td width="4%" class="first" >項目</td><td width="16%">專案名稱</td><td width="12%">本週進度</td><td width="28%">目前狀況</td><td width="9%">負責人</td><td width="10%">配合單位</td><td width="21%" class="last">連結網址</td></tr>';
					$order = 1;
					foreach( $tasks as $task )
					{
						$print .= ' <tr class="pj-dt-ct" id="task'. $task->sn .'"">
					        <td class="order">' . $order . '<span class="manageTask" data-task="'. $task->sn .'" data-pj="'.$projectSN.'" data-type="'.$task->type.'"><i class="fa fa-pencil-square-o"></i></span></td>
					        <td id="tdTaskName'. $task->sn .'">' . $task->name . '</td>
					        <td id="tdTaskProgress'. $task->sn .'">' . $task->progress . '</td>
					        <td id="tdTaskStatus'. $task->sn .'">' . $task->status . '</td>
					        <td id="tdTaskDesigner'. $task->sn .'">' . $task->designer . '</td>
					        <td id="tdTaskCowork'. $task->sn .'">' . $task->cowork . '</td>
					        <td id="tdTaskUrl'. $task->sn .'">' . $task->url . '</td>
				        </tr>';
				        $order++;
					}
					$print .= '</table>';
				}

			} /*  FOREACH PROJECT END */
			return $print;
		}else{
			return '目前沒有資料，來填寫第一筆吧!';
		}		
	} /* public function ajaxReportTable end */
}

?>