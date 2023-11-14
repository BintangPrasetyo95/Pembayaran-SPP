var pwb = document.getElementById('pw_baru');
var k_pw = document.getElementById('pw_konf');

function validasi() {
if (pwb.value != k_pw.value) {
    k_pw.setCustomValidity("Input Password Tidak Sama Dengan Password Baru");
}else{
    k_pw.setCustomValidity("");
}
}

pwb.onchange = validasi;
k_pw.onchange = validasi;

let uploadButton = document.getElementById("upload-button");
let chosenImage = document.getElementById("chosen-image");
let fileName = document.getElementById("file-name");

uploadButton.onchange = () => {
let reader = new FileReader();
reader.readAsDataURL(uploadButton.files[0]);
console.log(uploadButton.files[0]);
reader.onload = () => {
    chosenImage.setAttribute("src",reader.result);
}
fileName.textContent = uploadButton.files[0].name;
}

function hilangPreview() {
var j = document.getElementById("myPreview");
j.style.display = "none";
}

function showPreview() {
var j = document.getElementById("myPreview");
j.style.display = "block";
}

function getPics() {}
const imgs = document.querySelectorAll('#myAvatar img');
const fullimage = document.getElementById('#fullimage');

imgs.forEach(img => {
img.addEventListener('click', function () {
    fullimage.style.backgroundImage = 'url(' + img.src + ')';
    fullimage.style.display = 'block';
});
});