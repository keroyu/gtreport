(function() {
  var names, showResponse;

  $("#projectList").html("<div class=\"text-center ajax-loader\" style=\"padding-top: 20px; \"><img src=\"/img/loader.gif\" ></div>");

  $('#projectList').load('/ajax/projectList');

  $("#confirmNewPj").click(function() {
    var name;
    name = $("#pjName").val();
    if (name !== "") {
      if (confirm("確定新增專題嗎？")) {
        $.ajax({
          url: "/ajax/projectAdd",
          data: {
            name: name
          },
          type: "POST",
          success: function(response) {
            alert(response);
            location.reload();
          }
        });
      }
    }
  });

  names = $("#pjName").data("names");

  $("#pjName").autocomplete({
    source: names
  });

  $("body").on("click", ".editProject", function() {
    return $(this).parent().find('.edit-area').show();
  });

  $('body').on("click", "i.cancel", function() {
    return $(this).parent().hide();
  });

  showResponse = function(response, sn) {
    $('#projectLi' + sn).find('.edit-area').hide();
    $('#reportList').before('<div id="response" class="notice-bar success nodisplay"></div>');
    $('#response').html(response).slideToggle();
    setTimeout(function() {
      return $('#response').slideToggle();
    }, 1000);
    setTimeout(function() {
      return $('#projectList').load('/ajax/projectList');
    }, 1500);
  };

  $('body').on("click", "i.submit", function() {
    var name, sn;
    sn = $(this).data('sn');
    name = $(this).parent().find('input').val();
    if (name !== '') {
      return $.ajax({
        url: '/ajax/projectEdit',
        data: {
          sn: sn,
          name: name
        },
        type: "POST",
        success: function(response, sn) {
          showResponse(response);
        }
      });
    } else {
      return alert('請最少輸入1個字的專題名稱!');
    }
  });

  $('body').on("click", "i.controlDisplay", function() {
    var hgt, newDisplay, nowDisplay, paddingTop, sn, wid;
    nowDisplay = $(this).data('display');
    sn = $(this).data('sn');
    if (nowDisplay === 1) {
      newDisplay = 0;
    } else {
      newDisplay = 1;
    }
    wid = $("#projectList").width();
    hgt = $("#projectList").height();
    paddingTop = hgt * 0.4;
    hgt = hgt * 0.6;
    $("#projectList").prepend("<div class=\"text-center ajax-loader\" style=\"height:" + hgt + "px; padding-top:" + paddingTop + "px; \"><img src=\"/img/loader.gif\" ></div>");
    return $.ajax({
      url: '/ajax/projectDisplayControl',
      data: {
        sn: sn,
        display: newDisplay
      },
      type: "POST",
      success: function(response, sn) {
        $('#projectList').load('/ajax/projectList');
      }
    });
  });

}).call(this);
