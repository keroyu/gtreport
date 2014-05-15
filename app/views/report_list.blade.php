@extends('layouts.master')

@section('content')
	<div id="reportList"></div>

	<div class="margin-tb">
		<a href="#" class="btn primary md toggle-btn" data-target="#addNewReport">+ 新增週報表</a>
	<a href="#" class="btn primary md toggle-btn" data-target="#addNewProject">+ 新增專題 (遊戲名稱)</a>
	</div>
	<div class="data-box" id="addNewReport">
	<h3>+ 新增週報表</h3>
		開始日期： <input type="text" id="startDate" readonly="true" class="datepicker">
		結束日期： <input type="text" id="endDate"  readonly="true" class="datepicker"> <button class="btn primary sm" id="confirmNewRp">確定</button>
	</div>
	<div class="data-box" id="addNewProject">
	<h3>+ 新增專題 (遊戲名稱)</h3>
		名稱： <input type="text" id="pjName" name="pjName" class="lg" data-names='<?php echo $projects; ?>'> <button class="btn primary sm" id="confirmNewPj">確定</button>
		<div id="response" class="margin-tb"></div>
	</div>
<script src="/js/reportList.min.js"></script>
@stop