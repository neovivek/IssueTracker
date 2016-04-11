var basicHandler = function(){
	this.fetchAttr = function(node, searchitem){
		attri = $(node).attributes;
		output = [];
		for(var i=0; i<attri.length; i++){
			if(attri[i].nodeName == searchItem){
				temp = attri[i].nodeValue;
				output = temp.split(' ');
				break;
			}
		}
		return output;
	}
	
}