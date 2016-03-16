function findDetails(e){
	$.ajax({
		url: '/Amber/Util/detail.php',
		data: {'id': e},
		type: 'POST',
		success: function(a){
			d = a.getElementsByTagName('block');
			for(var i=0; i<d.length; i++){
				var id = $(d[i]).find('id').text();
				var title = $(d[i]).find('title').text();
				var description = $(d[i]).find('desc').text();
				var by = $(d[i]).find('C').text();
				var on = $(d[i]).find('c').text();
				var severity = $(d[i]).find('S').text();
				var detail = "<div class='modal-header'>" +
							"<h4 class='modal-title' id='myModalLabel'>" +
								"<a href='/issue/"+ id +"'>ISSUE "+ id +"</a>" +
								"<span class='badge pull-right severity-"+ severity +"'>Level "+ severity +"</span>" +
							"</h4>" +
						"</div>" +
						"<div class='modal-body'>" +
							"<ul class='pager'>";
				var tags = $(d[i]).find('tags').text().split('-');
				for (var i=0; i<tags.length; i++)
					detail += "<li><a>" + tags[i] + "</a></li>";
				detail += "</ul>" +
							"<div class='col s12'>"+ title +"</div>" +
							"<div class='col s12'>"+ description +"</div>" +
							"<span class='creator'> Created By: "+ by +" </span>" +
							"<span class='time'> "+ on +" </span>" +
						"</div>" +
						"<div class='modal-footer'>" +
							"<button type='button' class='btn btn-success' onclick='javascript: resolved("+ id +");' >Mark as Resolved</button>" +
							"<button type='button' class='btn btn-info' onclick='javascript: edit("+ id +");' >Edit Details</button>" +
						"</div>";
				$("#issue-detail").html(detail);
			}
		}
	});
}