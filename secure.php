<?PHP
?>
<script>
	session_sec = '<?=$sess_name;?>=<?=$cookie;?>';
	
	var open = XMLHttpRequest.prototype.open;
	
	XMLHttpRequest.prototype.open = function(method, url, async, user, password) {
		var url = url+((session_sec.length>1 && url.indexOf('<?=$sess_name;?>')<0)?((url.indexOf('?')>=0?'&':'?')+session_sec):'');
		/*this.addEventListener("readystatechange", function () {
			//console.log('readystate: ' + this.readyState);
			if(this.responseText !== '') {
			this.responseText=this.responseText.replace(/\\|\//g,'');
			}
		}, false);*/
		arguments[1] = url;
		return open.apply(this, arguments);
	}
	var send = XMLHttpRequest.prototype.send;
	
	XMLHttpRequest.prototype.send = function(data) {
		this.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		send.apply(this, arguments);
	}
	
	
	//this you to modify and set with PHP if you wand with session
	var g_SID = session_sec;
	var aTmpSID = g_SID.split('=');
	addSessionToAllForms();
	addSessionToAllLinks();
	function addSessionToForm(obj_form){
		//first check to see if already present
		//alert('addSessionToForm(obj_form)' + obj_form);
		//dprint('obj_form.id = '+obj_form.id);
		var bExists = false;
		var aChildren = obj_form.querySelectorAll('input');
		for (var i=0; i<aChildren.length; i++){
			//dprint('test ['+aChildren[i].name+'] ['+aTmpSID[0]+']');
			if (aChildren[i].name == aTmpSID[0]){
				bExists = true;
				break;
			}
		}
		//dprint('bExists = '+bExists);
		
		if (!bExists){
			var ctrl = document.createElement('input');
			ctrl.setAttribute("type", "hidden");
			ctrl.setAttribute("name", aTmpSID[0]);
			ctrl.setAttribute("id", aTmpSID[0]);
			ctrl.setAttribute("value", aTmpSID[1]);
			//alert('obj_form.appendChild ' + ctrl);
			obj_form.appendChild(ctrl);
		}
	}
	function addSessionToLink(obj_link){
		//first check to see if already present
		//alert('addSessionToForm(obj_form)' + obj_form);
		//dprint('obj_form.id = '+obj_form.id);
		var bExists = false;
		if(obj_link.getAttribute('href').indexOf('.php')>=0 && obj_link.getAttribute('href').indexOf('?')>=0){
			if(obj_link.getAttribute('href').indexOf('PHPSESSID')>=0){
				bExists = true;
			}
		}
		if(!bExists){
			var ahref = obj_link.getAttribute('href');
			obj_link.setAttribute('href',ahref+(ahref.indexOf('?')>=0?'':'?')+'&'+g_SID);
		}
	}
	
	function addSessionToAllForms(){
		var aForms = document.querySelectorAll('form');
		for (var f=0;f<aForms.length;f++){
			addSessionToForm(aForms[f]);
		}
	}
	function addSessionToAllLinks(){
		var aLinks = document.querySelectorAll('a');
		for (var f=0;f<aLinks.length;f++){
			addSessionToLink(aLinks[f]);
		}
	}
</script>				