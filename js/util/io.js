var method = {
		printErrorBasic: function(location, msg){
			msg = msg || "";
			$(location).html(msg);
			$(location).attr("title", msg);
			if(msg !== "") $(location).append("<span onclick='javascript: method.printErrorBasic(\"" + location + "\");' class='white-text' style='cursor:pointer;'> x </span>");
		}
}