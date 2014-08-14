/* This file controls the client-side behavior of the syllabus forms. */

$(function() {
   $("#manage-course").click(function() {
      $(this).addClass('selected');
      $("#manage-master").removeClass('selected');
      $("#master-syllabus-body").hide();
      $("#course-syllabus-body").show();
   });
   $("#manage-master").click(function() {
      $(this).addClass('selected');
      $("#manage-course").removeClass('selected');
      $("#master-syllabus-body").show();
      $("#course-syllabus-body").hide();
   });
   $("#add-new-master-syllabus-button").click(function() {
      $("#master-syllabus-view-all").hide();
      $("#master-syllabus-add-new").show();
   });
   $("#add-new-master-syllabus-link").click(function(e) {
      e.preventDefault();
      $("#master-syllabus-view-all").hide();
      $("#master-syllabus-add-new").show();
   });
   $("#heading").val("Western Oklahoma State College");  
   var selected = $("#title option:selected").val();
   var course_ids = new Array();
  
   alert(course_ids);
   var course_id = course_ids[selected];
   //alert(course_id);
   $("#course_id").val(course_id);
   $("#title").change(function() {
       
       selected = $("#title option:selected").val();
       course_id = course_ids[selected];
       
       $("#course_id").val(course_id);
   });
   
});