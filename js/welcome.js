(function(){
	var io = method;
	$("#welcome-body form").attr("action", window.location);
	$("#welcome-name .fa-chevron-circle-right").click(function(){
		var name = $("#welcome-user-name").val();
		if(name.length < 3) {
			io.printErrorBasic("#welcome-error-container", "Please enter atleast 3 characters.");
			return;
		}
		$("#welcome-name").css("margin-left", "-150%");
		var updatedData = "<kbd><a href='javascript: restore();' class='breadcrumb'>" + name + "</a>" +
				"<a class='breadcrumb'>Project</a></kbd>";
		$("#welcome-head .col").html(updatedData);
		$("#welcome-error-container").html("");
	});
	$("#welcome-project .fa-chevron-circle-right").click(function(){
		var project = $("#welcome-project-name").val();
		if(project.length < 3) {
			io.printErrorBasic("#welcome-error-container", "Please enter atleast 3 characters.");
			return;
		}
		var projects = $("#project-suggestion-container .suggestion");
		for(var i=0; i<projects.length; i++){
			if(project === $(projects[i]).html()) break;
		}
		if(i == projects.length) {
			io.printErrorBasic("#welcome-error-container", "Please select project names from the list on right.");
			return;
		}
		$("#welcome-error-container").html("");
		$("#welcome-body form").submit();
	});
	$(".special").on("keyup", function(){
		var value = $(this).val().trim();
		if(value === ""){
			if($(this).attr("id") == 'welcome-user-name')
				$("#welcome-head .breadcrumb:last-child").html("Name");
			else $("#welcome-head .breadcrumb:last-child").html("Project");
		}else{
			$("#welcome-head .breadcrumb:last-child").html($(this).val());
		}
	});
	$("#project-suggestion").click(function(){
		var state = $("#project-suggestion-container").css("display");
		if(state == "none") $("#project-suggestion-container").css("display", "block");
		else $("#project-suggestion-container").css("display", "none");
	});
	$("#project-suggestion-container .suggestion").click(function(){
		var name = $(this).html();
		$("#welcome-project-name").val(name);
		$("#project-suggestion-container").css("display", "none");
	});
})()
function restore(){
	$("#welcome-name").css("margin-left", "0");
	var name = $("#welcome-user-name").val();
	var updatedData = "<kbd><a class='breadcrumb'>" + name + "</a></kbd>";
	$("#welcome-head .col").html(updatedData);
}