# LOAD PROJECT LIST
$("#projectList").html "<div class=\"text-center ajax-loader\" style=\"padding-top: 20px; \"><img src=\"/img/loader.gif\" ></div>"
$('#projectList').load '/ajax/projectList'

# ADD NEW PROJECT 
$("#confirmNewPj").click ->
  name = $("#pjName").val()
  unless name is ""
    if confirm("確定新增專題嗎？")
      $.ajax
        url: "/ajax/projectAdd"
        data:
          name: name

        type: "POST"
        success: (response) ->
          alert response
          location.reload()
          return         
  return

# projects name autocomplete 
names = $("#pjName").data("names")
$("#pjName").autocomplete source: names

# EDIT PROJECT
$("body").on "click", ".editProject", ->
  $(this).parent().find('.edit-area').show()

$('body').on "click", "i.cancel", ->
  $(this).parent().hide()

#  DEFINE NOTICE FUNCTION
showResponse = (response, sn) ->
  $('#projectLi'+sn).find('.edit-area').hide()
  $('#reportList').before '<div id="response" class="notice-bar success nodisplay"></div>'
  $('#response').html(response).slideToggle()
  setTimeout( ()-> 
    $('#response').slideToggle()
  , 1000)
  setTimeout( ()->
    $('#projectList').load '/ajax/projectList'
  , 1500 )
  return

# SUBMIT DISPLAY CONTROL
$('body').on "click", "i.submit", ->
  sn = $(this).data('sn')
  name = $(this).parent().find('input').val()
  if name != ''
    $.ajax
      url: '/ajax/projectEdit'
      data: 
        sn: sn
        name: name
      type: "POST"
      success: (response, sn) ->
        showResponse(response)      
        return
  else 
    alert '請最少輸入1個字的專題名稱!'

$('body').on "click", "i.controlDisplay", ->
  nowDisplay = $(this).data('display')
  sn = $(this).data('sn')
  if nowDisplay==1 
    newDisplay = 0
  else
    newDisplay =1
  wid = $("#projectList").width()
  hgt = $("#projectList").height()
  paddingTop = hgt * 0.4
  hgt = hgt * 0.6
  $("#projectList").prepend "<div class=\"text-center ajax-loader\" style=\"height:" + hgt + "px; padding-top:" + paddingTop + "px; \"><img src=\"/img/loader.gif\" ></div>"
  $.ajax
    url: '/ajax/projectDisplayControl'
    data:
      sn: sn
      display: newDisplay
    type: "POST"
    success: (response, sn) ->
      $('#projectList').load '/ajax/projectList'
      return
