var globalKey = new global();
function findDetails(e){
	$.ajax({
		url: globalKey.baseAddress + '/Util/detail.php',
		data: {'id': e, 'a': 1},
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
				for (var j=0; j<tags.length; j++)
					detail += "<li><a>" + tags[j] + "</a></li>";
				detail += "</ul>" +
							"<div class='col s12'>"+ title +"</div>" +
							"<div class='col s12'>"+ description +"</div>" +
							"<span class='creator'> Created By: "+ by +" </span>" +
							"<span class='time'> "+ on +" </span>" +
						"</div>" +
						"<div class='modal-footer'>";
				if($(d[i]).find('R').text() == 0)
				detail += "<button type='button' class='btn btn-success' onclick='javascript: resolved("+ id +");' >Mark as Resolved</button>";
				else
				detail += "<button type='button' class='btn btn-success' onclick='javascript: reopen("+ id +");' >Reopen Issue </button>";
				detail += "<button type='button' class='btn btn-info' onclick='javascript: edit(this)' data-target='"+ id +"' >Edit Details</button>" +
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
	$.ajax({
		url: globalKey.baseAddress + '/Util/markResolved.php',
		data: {'key': e, 'type': 1},
		type: 'POST',
		success: function(a){
			d = a.getElementsByTagName('status')[0].getAttribute('content');
			if(d == 'success'){
				if($('.modal').is(":visible")) $("#issueModal").modal('toggle');
				method.setIssueStatus('resolved', e);
			}else{
				method.setIssueStatus('failed');
			}
		}
	});
}

function reopen(e){
	$.ajax({
		url: globalKey.baseAddress + '/Util/markResolved.php',
		data: {'key': e, 'type': 2},
		type: "POST",
		success: function(a){
			d = a.getElementsByTagName('status')[0].getAttribute('content');
			if(d == 'success'){
				if($('.modal').is(":visible")) $("#issueModal").modal('toggle');
				method.setIssueStatus('reopened', e);
			}else{
				method.setIssueStatus('failed');
			}
		}
	});
}
$(function () {
	  $(".project-selector").hover(function(e){
		  var id = $(this).attr('data-target');
		  var parent = this;
		  $.ajax({
			 url: globalKey.baseAddress + '/Util/detail.php',
			 data: {'id': id, "a": 2},
			 type: "POST",
			 success: function(d){
				 data = d.getElementsByTagName('status')[0].innerHTML;
				 $(parent).find('a').attr('data-content', data).popover('toggle');
			 }
		  });
	  });
	  $(".bay li").click(function(){
		  val = $(this).attr('data-value');
		  fam = $(this).attr('data-family');
		  loc = window.location.href;
		  if(loc.indexOf('?') == -1) loc += '?' + fam + '-' + val;
		  else loc += '+' + fam + '-' + loc;
		  window.location = loc;
	  });
})