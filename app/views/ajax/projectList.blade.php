<ul class="report-list project-list" id="reportList">
<?php foreach ($projectList as $project){ 
	$class = '';  $icon = 'fa-circle-o';
	if( $project->display != 1 ) { 
		$class='class="hidden"'; $icon='fa-circle'; 
		} ?>
	<li id="projectLi{{ $project->sn }}" {{ $class }}><i class="fa {{$icon}} controlDisplay" data-display="{{ $project->display }}" data-sn="{{ $project->sn }}"></i><span class="txt">{{ $project->name }}</span><p class="panel"><i class="fa fa-edit editProject"></i>
		<span class="edit-area">
			<input type="text" class="lg edit-input" value="{{ $project->name }}">
			<i class="fa fa-check submit" data-sn="{{ $project->sn }}"></i>
			<i class="fa fa-times cancel"></i>
		</span>
	</p></li>
<?php } ?>
</ul>