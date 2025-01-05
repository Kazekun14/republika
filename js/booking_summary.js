const urlParam = new URLSearchParams(window.location.search);
const accURL = urlParam.get('accommodation');
const fnameURL = urlParam.get('fullname');
const emlURL = urlParam.get('email');
const chckInURL = urlParam.get('checkin');
const timInURL = urlParam.get('timein');
const chckOutURL = urlParam.get('checkout');
const timOutURL = urlParam.get('timeout');
const gstsURL = urlParam.get('guests');
const prceURL = urlParam.get('price');

const accINPUT = document.getElementById('accData');
const fnameINPUT = document.getElementById('flnameData');
const emlINPUT = document.getElementById('emailData');
const chckInINPUT = document.getElementById('chckInData');
const timInINPUT = document.getElementById('timeInData');
const chckOutINPUT = document.getElementById('chckOutData');
const timOutINPUT = document.getElementById('timeOutData');
const prceINPUT = document.getElementById('priceData');
const gstsINPUT = document.getElementById('gstsData');

function toggleMenu() {
  const navLinks = document.querySelector('.navbar-head ul');
  if (navLinks) {
    navLinks.classList.toggle("active");
  }
}

accINPUT.textContent = accURL;
fnameINPUT.textContent = fnameURL;
emlINPUT.textContent = emlURL;
chckInINPUT.textContent = chckInURL;
timInINPUT.textContent = timInURL;
chckOutINPUT.textContent = chckOutURL;
timOutINPUT.textContent = timOutURL;
prceINPUT.textContent = prceURL;
gstsINPUT.textContent = gstsURL;

function savePage() {
  window.print();
}