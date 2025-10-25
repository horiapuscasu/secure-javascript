<?PHP
?>
<script>
	session_sec = '<?=$sess_name;?>=<?=$cookie;?>';
	var ck_name='<?=$sess_name;?>';
	var ck_value='<?=$cookie;?>';
	function getCookie(cname) {
		const name = cname + "=";
		const decodedCookie = decodeURIComponent(document.cookie);
		const ca = decodedCookie.split(';');
		
		for(let i = 0; i < ca.length; i++) {
			let c = ca[i];
			while (c.charAt(0) === ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) === 0) {
				return c.substring(name.length, c.length);
			}
		}
		
		return "";
	}
	
	function setCookie(cname, cvalue, exdays) {
		const d = new Date();
		
		d.setTime(d.getTime() + (exdays*24*60*60*exdays));
		
		const expires = "expires="+ d.toUTCString();
		
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	
	const hasCookieConsent = getCookie(ck_name);
	
	if (!hasCookieConsent) {
		setCookie(ck_name, ck_value, 1);
	}
		
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