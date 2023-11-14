var pw = document.getElementById('pw');
var k_pw = document.getElementById('kon_pw');

function validasi() {
	if (pw.value != k_pw.value) {
		k_pw.setCustomValidity("Input Password Tidak Sama");
	}else{
		k_pw.setCustomValidity("");
	}
}

pw.onchange = validasi;
k_pw.onchange = validasi;