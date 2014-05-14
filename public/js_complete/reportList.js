$('#reportList').html('<div class="text-center"><img src="/img/loader.gif" ></div>');
$('#reportList').delay(1500).load('ajax/reportList');

/* projects name autocomplete */

var names = $('#pjName').data('names'),
		projects = [];
	$.each( names, function( key, val){
		projects.push( val );
	} );
	$( "#pjName" ).autocomplete({ source: projects });

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