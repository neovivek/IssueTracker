var method = {
		printErrorBasic: function(location, msg){
			msg = msg || "";
			$(location).html(msg);
			$(location).attr("title", msg);
			if(msg !== "") $(location).append("<span onclick='javascript: method.printErrorBasic(\"" + location + "\");' class='white-text' style='cursor:pointer;'> x </span>");
		},
		printAutoDestructingAlert: function(location, msg, delay){
			delay = delay || 3000;
			alertMsg = "<div class='alert alert-danger' role='alert'><b>Request falied !</b>".msg."</div>";
			$(location).prepend(alertMsg);
			window.setTimeout(function(){ $(this).remove() }, delay);
		},
		printErrorAlert: function(location, msg){
			alertMsg = "<div class='alert alert-danger' role='alert'>" +
					"<button type="button" class="close" data-dismiss="alert" aria-label="Close">" +
							"<span aria-hidden="true">&times;</span>" +
					"</button>" +
					"<b>Request falied !</b>".msg."</div>";
			$(location).prepend(alertMsg);
		}
		setIssueStatus: function(status, id){
			if(status == 'failed'){
				this.printAutoDestructingAlert("#issueModal", "Try again in a few seconds.");
			}else if (status == 'success'){
				$("iss"+e).style("margin-top", "-100%");
				window.setTimeout(function(){$("iss"+e).style("display", "none");}, 1500);
			}
		}
}

var global = function(){
	var intermediateBase = window.location.pathname;
	intermediateBase.replace('/\\$/', '');
	
//	Stores directory address of current file to baseAddress attribute.
	this.baseAddress = intermediateBase.substring(0, intermediateBase.lastIndexOf('/'));
}