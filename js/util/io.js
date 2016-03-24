var method = {
		printErrorBasic: function(location, msg){
			msg = msg || "";
			$(location).html(msg);
			$(location).attr("title", msg);
			if(msg !== "") $(location).append("<span onclick='javascript: method.printErrorBasic(\"" + location + "\");' class='white-text' style='cursor:pointer;'> x </span>");
		},
		printAutoDestructingAlert: function(location, msg, delay){
			delay = delay || 2000;
			alertMsg = "<div class='alert alert-danger' role='alert'><b>Request falied ! </b>"+ msg +"</div>";
			$(location).prepend(alertMsg);
			window.setTimeout(function(){
				$(location).find(".alert:first-child").css('opacity', '0.2');
				window.setTimeout(function(){
					$(location).find(".alert:first-child").remove();
				}, delay - 200); 
			}, delay);
		},
		printErrorAlert: function(location, msg){
			alertMsg = "<div class='alert alert-danger' role='alert'>" +
					"<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
							"<span aria-hidden='true'>&times;</span>" +
					"</button>" +
					"<b>Request falied ! </b>"+ msg +"</div>";
			$(location).prepend(alertMsg);
		},
		setIssueStatus: function(status, e){
			if(status == 'failed'){
				this.printAutoDestructingAlert("#issueModal", "Try again in a few seconds.");
			}else if (status == 'resolved'){
				var id = $("#iss-"+e).find('issue-footer').attr('data-target');
				$("#iss-"+e).find('.issue-footer').html('<a href="javascript: reopen('+ e +');" class="issue-open" data-target="'+id+'">Reopen Issue</a>');
			}else if (status == 'reopened'){
				var id = $("#iss-"+e).find('issue-footer').attr('data-target');
				$("#iss-"+e).find('.issue-footer').html('<a href="javascript: resolved('+ e +');" class="issue-open" data-target="'+id+'">Close Issue</a>');
			}
		}
}

var global = function(){
	var intermediateBase = window.location.pathname;
	intermediateBase.replace('/\/$/', '');
	this.baseAddress = intermediateBase.substring(0, intermediateBase.lastIndexOf('/'));
}