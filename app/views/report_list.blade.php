@extends('layouts.master')

@section('content')
	<ul class="report-list" id="reportList">
	</ul>

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
		名稱： <input type="text" id="pjName" name="pjName" class="lg" > <button class="btn primary sm" id="confirmNewPj">確定</button>
		<div id="response" class="margin-tb"></div>
	</div>
<script>
	$(function(){
	$('#reportList').html('<div class="text-center"><img src="/img/loader.gif" ></div>');
	$('#reportList').delay(1500).load('ajax/reportList');
	});

	/* 新增週報表 */
	$('#confirmNewRp').click(function(){
		var start = $('#startDate').val(),
			end = $('#endDate').val();

		if( start != '' && end != '' ){
			if( confirm('確定新增週報表嗎？') ){

				$.ajax({
					url: "ajax/reportAdd",
					data: { 'start': start, 'end': end },
					type: "POST",
					success: function(response){
						var msg = '成功新增 '+response+' 的週報表!!';
						alert(msg);
						$('#reportList').html('<div class="text-center"><img src="/img/loader.gif" ></div>').load('ajax/reportList');
					}
				});
			}
		}else{
			alert('未填寫開始日期或結束日期');
		}
	});

	/* 新增專題 */
	$('#confirmNewPj').click(function(){
		var name = $('#pjName').val();

		if( name != '' ){
			if( confirm('確定新增專題嗎？') ){
				$.ajax({
					url: "/ajax/projectAdd",
					data: { 'name': name },
					type: "POST",
					success: function(response){
						$('#response').html(response);
						$('#pjName').html('');
					}
				});
			}
		}
	});
</script>
@stop
