<?php
/* This file controls the client-side behavior of the syllabus forms. */

require_once("../../config.php");
require_once("lib.php");
global $DB;



//get all course ids from Moodle
$result = $DB->get_records_sql("SELECT id FROM {course}");


$ids = array();

foreach($result as $key => $value) {

    $id = $value->id;
    $ids[] = $id;
}


?>
$(function() {
    $(".delete-master").click(function() {
        return confirm('Are you sure you want to delete this master syllabus?');
    });
    $(".delete-course").click(function() {
        return confirm('Are you sure you want to delete this course syllabus?');
    });
    var $_GET = {};

    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
        function decode(s) {
            return decodeURIComponent(s.split("+").join(" "));
        }

        $_GET[decode(arguments[1])] = decode(arguments[2]);
    });
    $("#master-add-new-cancel").click(function(e) {
        e.preventDefault();
        $("#master-syllabus-add-new").hide();
        $("#master-syllabus-view-all").show();
    });
    $("#course-add-new-cancel").click(function(e) {
        e.preventDefault();
        $("#course-syllabus-add-new").hide();
        $("#course-syllabus-view-all").show();
    });
    $("#master-edit-cancel").click(function(e) {
        e.preventDefault();
        window.location.replace('edit.php?course=' + $_GET['course_id'] + '&instance_id=' + $_GET['instance_id'] + '');
    });
    $("#course-add-cancel").click(function(e) {
        e.preventDefault();
        window.location.replace('edit.php?course=' + $_GET['course_id'] + '&instance_id=' + $_GET['instance_id'] + '');
    });
    $("#course-edit-cancel").click(function(e) {
        e.preventDefault();
        window.location.replace('edit.php?course=' + $_GET['course_id'] + '&instance_id=' + $_GET['instance_id'] + '');
    });
    $("#master-add-new").validate();
    $("#master-edit").validate();
    $("#course-add-new").validate();
    $("#course-edit").validate();
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
   $("#add-new-course-syllabus-button").click(function() {
      $("#course-syllabus-view-all").hide();
      $("#course-syllabus-add-new").show();
   });
   $("#add-new-course-syllabus-link").click(function(e) {
      e.preventDefault();
      $("#course-syllabus-view-all").hide();
      $("#course-syllabus-add-new").show();
   });
   $("#heading").val("Western Oklahoma State College");  
   var selected = $("#title option:selected").index();
   var course_ids = new Array();
<?php
foreach($ids as $key => $value) {
    echo 'course_ids['.$key.'] = '.$value.';';
}    
?>  
//alert(selected);
   var course_id = course_ids[selected];
   //alert(course_id);
   $("#course_id").val(course_id);
   $("#title").change(function() {
       
       selected = $("#title option:selected").index();
       course_id = course_ids[selected];
       
       $("#course_id").val(course_id);
   });
   
});


