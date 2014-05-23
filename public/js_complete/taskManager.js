(function() {
  var refreshTable, reportSN, tdArray;

  reportSN = $("#reportSN").val();

  refreshTable = function() {
    var hgt, paddingTop, wid;
    wid = $("#tasksTable").width();
    hgt = $("#tasksTable").height();
    paddingTop = hgt * 0.4;
    hgt = hgt * 0.6;
    $("#tasksTable").prepend("<div class=\"text-center ajax-loader\" style=\"height:" + hgt + "px; padding-top:" + paddingTop + "px; \"><img src=\"/img/loader.gif\" ></div>");
    setTimeout((function() {
      $("#tasksTable").load("/ajax/reportTable/" + reportSN);
    }), 800);
  };

  refreshTable();

  $("#designer").focus(function() {
    $("#nameBox").show();
  });

  $("input:not(#designer)").focus(function() {
    $("#nameBox").hide();
  });

  $("#nameBox ul li").click(function() {
    var hasNames, name;
    name = $(this).html();
    hasNames = $("#designer").val();
    if (hasNames !== "") {
      $("#designer").val(hasNames + "、" + name);
    } else {
      $("#designer").val(name);
    }
    $("#designer").focus();
  });

  $("#addNewTask").click(function() {
    var cowork, dataStr, designer, pjSN, progress, status, taskName, type, url;
    reportSN = $("#reportSN").val();
    pjSN = $("#pjSN").val();
    taskName = $("#taskName").val();
    type = $("#type").val();
    progress = $("#progress").val();
    status = $("#status").val();
    designer = $("#designer").val();
    cowork = $("#cowork").val();
    url = $("#url").val();
    if (pjSN !== "" && taskName !== "" && type !== "" && progress !== "" && designer !== "") {
      dataStr = {
        reportSN: reportSN,
        pjSN: pjSN,
        taskName: taskName,
        type: type,
        progress: progress,
        status: status,
        designer: designer,
        cowork: cowork,
        url: url
      };
      $.ajax({
        url: "/ajax/taskQuery/add",
        data: dataStr,
        type: "POST",
        success: function(response) {
          $("#addNewTask").after("<div class=\"text-center\" id=\"res\">" + response + "</div>");
          $("#res").delay(1500).fadeOut("slow");
          $("#taskName, #status, #cowork, #url").html("");
          refreshTable();
        }
      });
    } else {
      $("#addNewTask").after("<div class=\"alert text-center\">必要資料未填寫完成!</div>");
      $(".alert").delay(1500).fadeOut("slow");
    }
  });

  tdArray = ["TaskName", "TaskProgress", "TaskStatus", "TaskDesigner", "TaskCowork", "TaskUrl"];

  $("body").on("click", ".manageTask", function() {
    var btnLine, editLine, i, pjSN, str, taskSN, textArray, type, typeKeyArray, typeSelect, typeValArray;
    taskSN = $(this).data("task");
    pjSN = $(this).data("pj");
    type = $(this).data("type");
    editLine = "<td>auto</td>";
    textArray = [];
    i = 0;
    while (i < 6) {
      textArray.push($("#td" + tdArray[i] + taskSN).html());
      editLine += "<td><input type=\"text\" class=\"md\" id=\"edit" + tdArray[i] + taskSN + "\" val=\"\"></td>";
      i++;
    }
    typeKeyArray = ["W", "P", "M"];
    typeValArray = ["網頁", "平面", "多媒體"];
    typeSelect = "<select name=\"editTaskType" + taskSN + "\" id=\"editTaskType" + taskSN + "\">";
    str = "";
    i = 0;
    while (i < 3) {
      typeSelect += "<option value=\"" + typeKeyArray[i] + "\"";
      if (type === typeKeyArray[i]) {
        typeSelect += " selected";
      }
      typeSelect += ">" + typeValArray[i] + "</option>";
      i++;
    }
    typeSelect += "</select>";
    btnLine = "<tr class=\"text-right edit-area" + taskSN + "\"><td colspan=\"7\"><span class=\"margin-rl\" id=\"taskResponse" + taskSN + "\"></span><span>專案類型：" + typeSelect + "</span> <button class=\"btn xs primary editTaskBtn\" data-task=\"" + taskSN + "\" data-pj=\"" + pjSN + "\" data-type=\"" + type + "\">修改</button> <button class=\"btn xs danger delTaskBtn\" data-task=\"" + taskSN + "\">刪除</button> <button class=\"btn xs cancelTaskBtn\" data-task=\"" + taskSN + "\">取消</button></td></tr>";
    $("#task" + taskSN).after("<tr class=\"pj-dt-ct edit-area" + taskSN + "\" id=\"edit" + taskSN + "\"></tr>");
    $("#edit" + taskSN).append(editLine).after(btnLine);
    i = 0;
    while (i < 6) {
      $("#edit" + tdArray[i] + taskSN).val(textArray[i]);
      i++;
    }
    setTimeout((function() {
      $("#task" + taskSN).hide();
    }), 50);
  });

  $("body").on("click", ".editTaskBtn", function() {
    var dataStr, i, pjSN, sendArray, taskSN, type;
    reportSN = $("#reportSN").val();
    taskSN = $(this).data("task");
    pjSN = $(this).data("pj");
    type = $("#editTaskType" + taskSN).val();
    sendArray = [];
    i = 0;
    while (i < 6) {
      sendArray[tdArray[i]] = $("#edit" + tdArray[i] + taskSN).val();
      i++;
    }
    dataStr = {
      reportSN: reportSN,
      taskSN: taskSN,
      pjSN: pjSN,
      taskName: sendArray["TaskName"],
      type: type,
      progress: sendArray["TaskProgress"],
      status: sendArray["TaskStatus"],
      designer: sendArray["TaskDesigner"],
      cowork: sendArray["TaskCowork"],
      url: sendArray["TaskUrl"]
    };
    $.ajax({
      url: "/ajax/taskQuery/edit",
      data: dataStr,
      type: "POST",
      success: function(response) {
        $("#taskResponse" + taskSN).html(response);
        $("#res").delay(1000).fadeOut("fast");
        setTimeout(refreshTable(), 3000);
      }
    });
  });

  $("body").on("click", ".cancelTaskBtn", function() {
    var taskSN;
    taskSN = $(this).data("task");
    $(".edit-area" + taskSN).remove();
    $("#task" + taskSN).show();
  });

  $("body").on("click", ".delTaskBtn", function() {
    var name, taskSN;
    taskSN = $(this).data("task");
    name = $("#editTaskName" + taskSN).val();
    console.log(taskSN, name);
    if (confirm("確定刪除專案 \"" + name + "\" 嗎?")) {
      $.ajax({
        url: "/ajax/taskQuery/del",
        data: {
          taskSN: taskSN
        },
        type: "POST",
        success: function(response) {
          $("#taskResponse" + taskSN).html(response);
          $("#res").delay(1000).fadeOut("fast");
          setTimeout(refreshTable(), 2000);
        }
      });
    }
  });

}).call(this);
