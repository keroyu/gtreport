@extends('layouts.master')

@section('content')
@include('layouts.breadcrumb')
	<div id="reportList"></div>

	<div class="margin-tb">
		<a href="#" class="btn primary md toggle-btn" data-target="#addNewReport">+ 新增週報表</a>
		<a href="/projects" class="btn primary md">管理專題</a>

	</div>
	<div class="data-box" id="addNewReport">
	<h3>+ 新增週報表</h3>
		開始日期： <input type="text" id="startDate" readonly="true" class="datepicker">
		結束日期： <input type="text" id="endDate"  readonly="true" class="datepicker"> <button class="btn primary sm" id="confirmNewRp">確定</button>
	</div>
<script src="/js/reportList.min.js"></script>
@stop