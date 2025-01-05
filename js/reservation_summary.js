const urlParam = new URLSearchParams(window.location.search);
const srvcURL = urlParam.get('service');
const fnameURL = urlParam.get('fullname');
const emlURL = urlParam.get('email');
const adrsURL = urlParam.get('address');
const dteURL = urlParam.get('date');
const timURL = urlParam.get('time');
const gstsURL = urlParam.get('guests');
const prcURL = urlParam.get('serviceprice');

const srvcINPUT = document.getElementById('srvcData');
const fnameINPUT = document.getElementById('fnameData');
const emlINPUT = document.getElementById('emlData');
const adrsINPUT = document.getElementById('adrsData');
const dteINPUT = document.getElementById('dteData');
const timINPUT = document.getElementById('timData');
const prceINPUT = document.getElementById('prcData');
const gstsINPUT = document.getElementById('gstsData');

const lbladrs = document.getElementById('labeladrs');

function toggleMenu() {
  const navLinks = document.querySelector('.navbar-head ul');
  if (navLinks) {
    navLinks.classList.toggle("active");
  }
}


srvcINPUT.textContent = srvcURL;
fnameINPUT.textContent = fnameURL;
emlINPUT.textContent = emlURL;
dteINPUT.textContent = dteURL;
timINPUT.textContent = timURL;
prceINPUT.textContent = prcURL;
gstsINPUT.textContent = gstsURL;

if (adrsURL) {
  lbladrs.style.display = 'block';
  adrsINPUT.style.display = 'block';
  adrsINPUT.textContent = adrsURL;
} else {
  lbladrs.style.display = 'none';
  adrsINPUT.style.display = 'none';
  adrsINPUT.removeAttribute("name");
}

function savePage() {
  window.print();
}