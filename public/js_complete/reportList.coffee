$("#reportList").html "<div class=\"text-center\"><img src=\"img/loader.gif\" ></div>"
$("#reportList").delay(1500).load "ajax/reportList"

# 新增週報表 
$("#confirmNewRp").click ->
  start = $("#startDate").val()
  end = $("#endDate").val()
  if start isnt "" and end isnt ""
    if confirm("確定新增週報表嗎？")
      $.ajax
        url: "ajax/reportAdd"
        data:
          start: start
          end: end

        type: "POST"
        success: (response) ->
          msg = "成功新增 " + response + " 的週報表!!"
          alert msg
          $("#reportList").html("<div class=\"text-center\"><img src=\"img/loader.gif\" ></div>").load "ajax/reportList"
          return

  else
    alert "未填寫開始日期或結束日期"
  return