# LOAD TASK TABLE 
reportSN = $("#reportSN").val()
refreshTable = ->
  wid = $("#tasksTable").width()
  hgt = $("#tasksTable").height()
  paddingTop = hgt * 0.4
  hgt = hgt * 0.6
  $("#tasksTable").prepend "<div class=\"text-center ajax-loader\" style=\"height:" + hgt + "px; padding-top:" + paddingTop + "px; \"><img src=\"/img/loader.gif\" ></div>"
  setTimeout (->
    $("#tasksTable").load "/ajax/reportTable/" + reportSN
    return
  ), 800
  return

refreshTable()

# NAME BOX FUNCTION 

# 控制該 NAME BOX 顯示或隱藏 
$("#designer").focus ->
  $("#nameBox").show()
  return

$("input:not(#designer)").focus ->
  $("#nameBox").hide()
  return


# 點擊 NAME BOX 內名字 輸入到 #designer 
$("#nameBox ul li").click ->
  name = $(this).html()
  hasNames = $("#designer").val()
  if hasNames isnt ""
    $("#designer").val hasNames + "、" + name
  else
    $("#designer").val name
  $("#designer").focus()
  return


# ADD NEW TASK 
$("#addNewTask").click ->
  reportSN = $("#reportSN").val()
  pjSN = $("#pjSN").val()
  taskName = $("#taskName").val()
  type = $("#type").val()
  progress = $("#progress").val()
  status = $("#status").val()
  designer = $("#designer").val()
  cowork = $("#cowork").val()
  url = $("#url").val()

  if pjSN isnt "" and taskName isnt "" and type isnt "" and progress isnt "" and designer isnt ""
    dataStr =
      reportSN: reportSN
      pjSN: pjSN
      taskName: taskName
      type: type
      progress: progress
      status: status
      designer: designer
      cowork: cowork
      url: url

    $.ajax
      url: "/ajax/taskQuery/add"
      data: dataStr
      type: "POST"
      success: (response) ->
        $("#addNewTask").after "<div class=\"text-center\" id=\"res\">" + response + "</div>"
        $("#res").delay(1500).fadeOut "slow"
        $("#taskName, #status, #cowork, #url").html ""
        refreshTable()
        return

  else
    $("#addNewTask").after "<div class=\"alert text-center\">必要資料未填寫完成!</div>"
    $(".alert").delay(1500).fadeOut "slow"
  return


# INPUT NAME ARRAY 
tdArray = [
  "TaskName"
  "TaskProgress"
  "TaskStatus"
  "TaskDesigner"
  "TaskCowork"
  "TaskUrl"
]

#  EDIT TASK 

# -- EXPAND EDIT AREA 
$("body").on "click", ".manageTask", ->
  taskSN = $(this).data("task")
  pjSN = $(this).data("pj")
  type = $(this).data("type")
  editLine = "<td>auto</td>"
  textArray = []
  
  # ----構建 編輯區域 HTML 
  i = 0

  while i < 6
    textArray.push $("#td" + tdArray[i] + taskSN).html()
    editLine += "<td><input type=\"text\" class=\"md\" id=\"edit" + tdArray[i] + taskSN + "\" val=\"\"></td>"
    i++
  
  # ----構建 按鈕 HTML 
  
  # ------TYPE SELECT LOOP 
  typeKeyArray = [
    "W"
    "P"
    "M"
  ]
  typeValArray = [
    "網頁"
    "平面"
    "多媒體"
  ]
  typeSelect = "<select name=\"editTaskType" + taskSN + "\" id=\"editTaskType" + taskSN + "\">"
  str = ""
  i = 0

  while i < 3
    typeSelect += "<option value=\"" + typeKeyArray[i] + "\""
    typeSelect += " selected"  if type is typeKeyArray[i]
    typeSelect += ">" + typeValArray[i] + "</option>"
    i++
  typeSelect += "</select>"
  
  # ---- CONSTRUCT INPUT BUTTON LINE 
  btnLine = "<tr class=\"text-right edit-area" + taskSN + "\"><td colspan=\"7\"><span class=\"margin-rl\" id=\"taskResponse" + taskSN + "\"></span><span>專案類型：" + typeSelect + "</span> <button class=\"btn xs primary editTaskBtn\" data-task=\"" + taskSN + "\" data-pj=\"" + pjSN + "\" data-type=\"" + type + "\">修改</button> <button class=\"btn xs danger delTaskBtn\" data-task=\"" + taskSN + "\">刪除</button> <button class=\"btn xs cancelTaskBtn\" data-task=\"" + taskSN + "\">取消</button></td></tr>"
  
  # ----顯示編輯區域和按鈕 
  $("#task" + taskSN).after "<tr class=\"pj-dt-ct edit-area" + taskSN + "\" id=\"edit" + taskSN + "\"></tr>"
  $("#edit" + taskSN).append(editLine).after btnLine
  
  # ----填寫入舊的資料 
  i = 0

  while i < 6
    $("#edit" + tdArray[i] + taskSN).val textArray[i]
    i++
  setTimeout (->
    $("#task" + taskSN).hide()
    return
  ), 50
  return


# -- SEND INPUT DATA 
$("body").on "click", ".editTaskBtn", ->
  reportSN = $("#reportSN").val()
  taskSN = $(this).data("task")
  pjSN = $(this).data("pj")
  type = $("#editTaskType" + taskSN).val()
  sendArray = []
  i = 0

  while i < 6
    sendArray[tdArray[i]] = $("#edit" + tdArray[i] + taskSN).val()
    i++
  dataStr =
    reportSN: reportSN
    taskSN: taskSN
    pjSN: pjSN
    taskName: sendArray["TaskName"]
    type: type
    progress: sendArray["TaskProgress"]
    status: sendArray["TaskStatus"]
    designer: sendArray["TaskDesigner"]
    cowork: sendArray["TaskCowork"]
    url: sendArray["TaskUrl"]

  $.ajax
    url: "/ajax/taskQuery/edit"
    data: dataStr
    type: "POST"
    success: (response) ->
      $("#taskResponse" + taskSN).html response
      $("#res").delay(1000).fadeOut "fast"
      setTimeout refreshTable(), 3000
      return

  return


# -- CANCEL MANAGE TASK 
$("body").on "click", ".cancelTaskBtn", ->
  taskSN = $(this).data("task")
  $(".edit-area" + taskSN).remove()
  $("#task" + taskSN).show()
  return


# DELETE A TASK 
$("body").on "click", ".delTaskBtn", ->
  taskSN = $(this).data("task")
  name = $("#editTaskName" + taskSN).val()
  console.log taskSN, name
  if confirm("確定刪除專案 \"" + name + "\" 嗎?")
    $.ajax
      url: "/ajax/taskQuery/del"
      data:
        taskSN: taskSN

      type: "POST"
      success: (response) ->
        $("#taskResponse" + taskSN).html response
        $("#res").delay(1000).fadeOut "fast"
        setTimeout refreshTable(), 2000
        return

  return
