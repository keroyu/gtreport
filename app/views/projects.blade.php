@extends('layouts.master')

@section('content')

	@include('layouts.breadcrumb')
	<a href="#" class="btn primary md toggle-btn" data-target="#addNewProject">+ 新增專題 (遊戲名稱)</a>
	<div class="data-box" id="addNewProject">
		<h3>+ 新增專題 (遊戲名稱)</h3>
			名稱： <input type="text" id="pjName" name="pjName" class="lg" data-names='<?php echo $projectJson; ?>'> <button class="btn primary sm" id="confirmNewPj">確定</button>
		</div>
	<div id="projectList">
	</div>
	<script src="/js/projects.min.js"></script>
@stop