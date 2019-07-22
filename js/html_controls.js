/*
 * ----------------------------------------------------------------------------------------
 * get sub categories on category selection
 * ----------------------------------------------------------------------------------------
 */
function filterSubCat(a, b, c, d, e, f, userId="") {
	var xhr, res, subCat, x,
		loading = document.getElementsByClassName('loading_contents')[f],
		d = document.getElementById(d),
		url = baseURL()+'controllers/htmlcontrol.php',
		dataString = 'action='+e+'&id='+a+"&tbl="+b+"&col="+c+"&userId="+userId;

		d.innerHTML = "";
		
		if(a !== '') {
			loading.innerHTML = '<p class="loading"><i class="ion fa-spin ion-load-b"></i>Loading...</p>';
			loading.style.display = "block";
			xhr = new XMLHttpRequest();
			xhr.open('POST', url, true);
			xhr.onloadend = function() {
			    if(xhr.status == 404) {
			    	loading.innerHTML = '<p class="error"><i class="ion ion-close"></i>Page not found. <span class="try_again" onclick="javascript:filterSubCat('+ a +', \''+b+'\')">Try again.</span></p>';
			        throw new Error(url + ' replied 404');
			    }
			}
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 3){}
				if(xhr.readyState == 4 && xhr.status == 200) {
					if(xhr.responseText) {
						
						d.innerHTML += xhr.responseText;
						loading.innerHTML = '';
						loading.style.display = "none";
					}
					else {
						d.innerHTML = '<option value="">-- Select --</option>';
						loading.innerHTML = '';
						loading.style.display = "none";
					}	
				}
			}
			xhr.timeout = 30000;
			xhr.ontimeout = function() {
				loading.innerHTML = '<p class="error"><i class="ion ion-close"></i>Network error. <span class="try_again" onclick="javascript:filterSubCat('+ a +', \''+b+'\')">Try again.</span></p>';
				loading.style.display = "block";
			}
			xhr.send(dataString);
		}
		else {
			d.innerHTML = '<option value="">-- Select --</option>';
			loading.innerHTML = "";
			loading.display = "none";
		}
}