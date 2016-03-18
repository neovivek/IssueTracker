function findDetails(e){
	var globalKey = new global();
	$.ajax({
		url: globalKey.baseAddress + '/Util/detail.php',
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
								"ISSUE "+ id +
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
							"<button type='button' class='btn btn-info' onclick='javascript: edit(this)' data-target='"+ id +"' >Edit Details</button>" +
						"</div>";
				$("#issue-detail").html(detail);
				$("#issueModal").modal();
			}
		}
	});
}

function edit(e){
	window.location = '/issue/' + $(e).attr('data-target');
}

function resolved(e){
	var globalKeys = new global();
	$.ajax({
		url: globalKeys.baseAddress + '/Util/markResolved.php',
		data: {'key': e},
		success: function(a){
			d = a.getElementsByTagName('status').content;
			if(d == 'success'){
				$("#issueModal").modal('toggle');
				method.setIssueStatus('success', e);
			}else{
				method.setIssueStatus('failed');
			}
		}
	});
}