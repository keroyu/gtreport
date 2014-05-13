@extends('layouts.master')

@section('content')
<p class="intro-txt"><span class="udl">視覺設計部</span><span>報告人/職稱: 創意總監</span><span class="right">週報表 <?php echo $period; ?> 曹善偉</span></p>

@if ( $mode == 'edit' )
<div class="input-box" id="inputPanel">
	<span><span class="option">專題名稱：</span><select name="pjSN" id="pjSN" class="md"><?php echo $selectPj; ?></select>* <a href="/">新增專題</a></span>
	<span><span class="option">專案名稱：</span><input type="text" class="lg" name="taskName" id="taskName" >*</span>
	<span><span class="option">專案類型：</span><select name="type" id="type"><option value="W">網頁</option><option value="P">平面</option><option value="M">多媒體 </option></select> *</span>
	<span><span class="option">本週進度：</span><select name="progress" id="progress" class="md"><option value="" selected>-</option><option value="已完成_待確認" >已完成_待確認</option><option value="已完成">已完成</option><option value="進行中">進行中</option></select>*</span>
	<span><span class="option">目前狀況：</span><input type="text" class="md" name="status" id="status"></span>
	<span><span class="option">完成日期：</span><input type="text" class="md datepicker" name="finishdate" id="finishdate" readonly="true"></span>
	<span><span class="option">負責人：</span><input type="text" class="md" name="designer" id="designer">*</span>
	<span><span class="option">配合單位：</span><input type="text" class="md" name="cowork" id="cowork"></span>
	<span><span class="option">連結網址：</span><input type="text" class="lg" name="url" id="url"></span>
	<div class="text-center"><button class="btn primary sm" id="addNewTask">確定送出</button></div>
</div>
@endif
	<div class="project" id="tasksTable">
	</div>
	<input type="hidden" id="reportSN" value="<?php echo $sn; ?>" >

@if ( $mode == 'edit' )
<div class="text-center margin-tb"><a class="btn info lg"  href="/report/<?php echo $sn ?>/print" target="_blank">查看列印版</a></div>
@endif

<script>
$(function(){

	$("#tasksTable").html('<div class="text-center"><img src="/img/loader.gif" ></div>').delay(2000).load( "/ajax/reportTable/<?php echo $sn; ?>" );

	$('#addNewTask').click(function(){
		var reportSN = $('#reportSN').val();
			pjSN = $('#pjSN').val(),
			taskName = $('#taskName').val(),
			type = $('#type').val(),
			progress = $('#progress').val(),
			status = $('#status').val(),
			finishdate = $('#finishdate').val(),
			designer = $('#designer').val(),
			cowork = $('#cowork').val(),
			url = $('#url').val();

		if( pjSN!= '' && taskName !='' && type !='' && progress !='' && designer !='' ){
			var dataStr = {
				'reportSN' : reportSN,
				'pjSN': pjSN,
				'taskName': taskName,
				'type': type,
				'progress': progress,
				'status': status,
				'finishdate': finishdate,
				'designer': designer,
				'cowork': cowork,
				'url': url
			};
			$.ajax({
				url: "/ajax/taskAdd",
				data: dataStr,
				type: "POST",
				success: function(response){
					$('#addNewTask').after('<div class="text-center" id="res">'+response+'</div>');
					$('#res').delay(1500).fadeOut('slow');
					$("#tasksTable").load( "/ajax/reportTable/<?php echo $sn; ?>"); 
				}
			});
		}else{
			$('#addNewTask').after('<div class="alert text-center">必要資料未填寫完成!</div>');
			$('.alert').delay(1500).fadeOut('slow');
		}
	});
	
	/* 刪除專案 */
	$('body').on( "click", ".delTask", function(){
		var sn = $(this).data('sn'),
			name = $('#tdTaskName'+sn).html();
		if( confirm('確定刪除專案 "'+name+'" 嗎?') ){
			
			$.ajax({
				url: "/ajax/taskDel",
				data: { 'sn': sn },
				type: "POST",
				success: function(){
					$('#task'+sn).fadeOut('fast');
				}
			});
		}
	});
});
</script>
@stop
