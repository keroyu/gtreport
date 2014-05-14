@extends('layouts.master')

@section('content')
<p class="intro-txt"><span class="udl">視覺設計部</span><span>報告人/職稱: 創意總監</span><span class="right">週報表 <?php echo $period; ?> 曹善偉</span></p>

@if ( $mode == 'edit' )
<div class="input-box" id="inputPanel">
	<span><span class="option">專題名稱：</span><select name="pjSN" id="pjSN" class="md"><?php echo $selectPj; ?></select>*<a href="/">新增專題</a></span>
	<span><span class="option">專案名稱：</span><input type="text" class="lg" name="taskName" id="taskName" >*</span>
	<span><span class="option">專案類型：</span><select name="type" id="type"><option value="W">網頁</option><option value="P">平面</option><option value="M">多媒體 </option></select> *</span>
	<span><span class="option">本週進度：</span><select name="progress" id="progress" class="md"><option value="" selected>-</option><option value="已完成">已完成</option><option value="進行中">進行中</option><option value="其他">其他</option></select>*</span>
	<span><span class="option">目前狀況：</span><input type="text" class="lg" name="status" id="status"></span>
	<span><span class="option">負責人：</span><input type="text" class="lg" name="designer" id="designer">*<div class="name-box" id="nameBox"><ul><li>Sam</li><li>Mori</li><li>阿堡</li><li>姐姐</li><li>盧卡斯</li><li>Kero</li><li>虎牙</li><li>阿泰</li><li>小瑜</li><li>屁屁</li><li>Sai</li><li>阿港</li><li>阿男</li><li>Jimi</li></ul></div></span>
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

	var refreshTable = function(){
		var wid = $("#tasksTable").width(), 
			hgt = $("#tasksTable").height(),
			paddingTop =hgt*0.4, hgt = hgt * 0.6;
		$("#tasksTable").prepend('<div class="text-center ajax-loader" style="height:'+hgt+'px; padding-top:'+paddingTop+'px; "><img src="/img/loader.gif" ></div>');
		setTimeout( function(){ 
			$("#tasksTable").load( "/ajax/reportTable/<?php echo $sn; ?>" ) 
		}, 800 );
	}
	refreshTable();
	

	/* NAME BOX FUNCTION */
	/* 控制該 NAME BOX 顯示或隱藏 */
	$('#designer').focus(function(){
		$('#nameBox').show();
	});
	$('input:not(#designer)').focus(function(){
		$('#nameBox').hide();
	});
	/* 點擊 NAME BOX 內名字 輸入到 #designer */
	$('#nameBox ul li').click(function(){
		var name = $(this).html(),
			hasNames = $('#designer').val();
		if( hasNames !== '' ){
			$('#designer').val( hasNames + '、' + name );
		}else{
			$('#designer').val(name);
		}
		$('#designer').focus();
	});


	/* ADD NEW TASK */
 	$('#addNewTask').click(function(){
		var reportSN = $('#reportSN').val();
			pjSN = $('#pjSN').val(),
			taskName = $('#taskName').val(),
			type = $('#type').val(),
			progress = $('#progress').val(),
			status = $('#status').val(),
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
					$('#taskName, #status, #cowork, #url').html('');
					refreshTable();
				}
			});
		}else{
			$('#addNewTask').after('<div class="alert text-center">必要資料未填寫完成!</div>');
			$('.alert').delay(1500).fadeOut('slow');
		}
	});


/* INPUT NAME ARRAY */

var tdArray = [
	'TaskName', 'TaskProgress', 'TaskStatus', 
	'TaskDesigner', 'TaskCowork', 'TaskUrl'
]

	/*  EDIT TASK */

	/* -- EXPAND EDIT AREA */
	$('body').on( "click", ".manageTask", function(){
		var taskSN = $(this).data('task'),
			pjSN = $(this).data('pj'),
			type= $(this).data('type'),
			editLine = '<td>auto</td>',
			textArray = [];

		/* ----構建 編輯區域 HTML */
		for( var i=0; i<6; i++ ){
			textArray.push ( $('#td'+tdArray[i]+taskSN).html() );
			editLine += '<td><input type="text" class="md" id="edit'+tdArray[i]+taskSN+'" val=""></td>';
		}

		/* ----構建 按鈕 HTML */
		/* ------TYPE SELECT LOOP */
		var typeKeyArray = ['W', 'P', 'M'],
			typeValArray = [ '網頁', '平面', '多媒體' ],
			typeSelect = '<select name="editTaskType'+taskSN+'" id="editTaskType'+taskSN+'">',
			str = '';
		for( var i=0; i<3; i++ ){
			typeSelect += '<option value="'+typeKeyArray[i]+'"';
			if( type == typeKeyArray[i] ) typeSelect += ' selected';
			typeSelect += '>'+typeValArray[i]+'</option>';
		}
		typeSelect += '</select>';
		/* ---- CONSTRUCT INPUT BUTTON LINE */
		var	btnLine = '<tr class="text-right edit-area'+taskSN+'"><td colspan="7"><span class="margin-rl" id="taskResponse'+taskSN+'"></span><span>專案類型：'+ typeSelect +'</span> <button class="btn xs primary editTaskBtn" data-task="'+taskSN+'" data-pj="'+pjSN+'" data-type="'+type+'">修改</button> <button class="btn xs danger delTaskBtn" data-task="'+taskSN+'">刪除</button> <button class="btn xs cancelTaskBtn" data-task="'+taskSN+'">取消</button></td></tr>';

		/* ----顯示編輯區域和按鈕 */
		$('#task'+taskSN).after('<tr class="pj-dt-ct edit-area'+taskSN+'" id="edit'+taskSN+'"></tr>');
		$('#edit'+taskSN).append(editLine).after(btnLine);

		/* ----填寫入舊的資料 */
		for( var i=0; i<6; i++ ){
			$( '#edit'+tdArray[i]+taskSN ).val( textArray[i] );
		}
		setTimeout( function(){ $('#task'+taskSN).hide(); }, 50 );
	});
	/* -- SEND INPUT DATA */
	$('body').on( "click", ".editTaskBtn", function(){
		var reportSN = $('#reportSN').val(),
			taskSN = $(this).data('task'),
			pjSN = $(this).data('pj'),
			type = $('#editTaskType'+taskSN).val(),
			sendArray = [];
		for( var i=0; i<6; i++ ){
			sendArray[ tdArray[i] ] = $('#edit'+tdArray[i]+taskSN ).val();
		}
		var dataStr = {
			'reportSN': reportSN,
			'taskSN': taskSN,
			'pjSN': pjSN,
			'taskName': sendArray['TaskName'],
			'type': type,
			'progress': sendArray['TaskProgress'],
			'status': sendArray['TaskStatus'],
			'designer': sendArray['TaskDesigner'],
			'cowork': sendArray['TaskCowork'],
			'url': sendArray['TaskUrl']
		};
		$.ajax({
			url: "/ajax/taskEdit",
			data: dataStr,
			type: "POST",
			success: function(response){
				 $('#taskResponse'+taskSN).html(response);
				 $('#res').delay(1500).fadeOut('fast');
				 setTimeout( refreshTable(), 3000 );
			}
		});
	});

	/* -- CANCEL MANAGE TASK */
	$('body').on( "click", ".cancelTaskBtn", function(){
		var taskSN = $(this).data('task');
		$('.edit-area'+taskSN).remove();
		$('#task'+taskSN).show();
	});
	
	/* DELETE A TASK */
	$('body').on( "click", ".delTaskBtn", function(){
		var sn = $(this).data('task'),
			name = $('#editTaskName'+sn).val();
		if( confirm('確定刪除專案 "'+name+'" 嗎?') ){
			$.ajax({
				url: "/ajax/taskDel",
				data: { 'sn': sn },
				type: "POST",
				success: function(response){
					$('#taskResponse'+sn).html(response);
					$('#res').delay(1500).fadeOut('fast');
					setTimeout( refreshTable(), 3000 );
				}
			});
		}
	});

});
</script>
@stop
