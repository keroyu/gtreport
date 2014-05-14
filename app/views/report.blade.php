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
	<span><span class="option">配合單位：</span><input type="text" class="md" name="cowork" id="cowork" data-names='<?php echo $coworkers; ?>'></span>
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
<script src="/js/taskManager.min.js"></script>
@stop
