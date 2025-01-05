function toggleMenu() {
  const navLinks = document.querySelector('.navbar-head ul');
  if (navLinks) {
    navLinks.classList.toggle("active");
  }
}

const today = new Date();
const maxDate = new Date(today.getFullYear() - 13, today.getMonth(), today.getDate());
const formattedMaxDate = maxDate.toISOString().split('T')[0];
document.getElementById('datebirth').setAttribute('max', formattedMaxDate);

const dateInput = document.getElementById('datebirth');
dateInput.addEventListener('click', () => {
  dateInput.showPicker();
});

document.addEventListener("DOMContentLoaded", () => {
  const fnameInput = document.getElementById("fname");
  const emailInput = document.getElementById("email");
  const numberInput = document.getElementById("number");
  const addressInput = document.getElementById("address");
  const datebirthInput = document.getElementById("datebirth");
  const genderInput = document.getElementById("gender");

  const saveBtn = document.getElementById("btnSave");
  const changeBtn = document.getElementById("btnChange");

  if (typeof userData === "object" && userData) {
    fnameInput.value = userData.fullname;
    emailInput.value = userData.email;
    numberInput.value = userData.number;
    addressInput.value = userData.address;
    datebirthInput.value = userData.datebirth;
    genderInput.value = userData.gender;

    disableInputs();
  }

  function disableInputs() {
    fnameInput.disabled = true;
    emailInput.disabled = true;
    numberInput.disabled = true;
    addressInput.disabled = true;
    datebirthInput.disabled = true;
    genderInput.disabled = true;
    saveBtn.style.display = "none";
    changeBtn.style.display = "inline";
  }

  function enableInputs() {
    fnameInput.disabled = false;
    emailInput.disabled = false;
    numberInput.disabled = false;
    addressInput.disabled = false;
    datebirthInput.disabled = false;
    genderInput.disabled = false;
    saveBtn.style.display = "inline";
    changeBtn.style.display = "none";
  }

  changeBtn.addEventListener("click", enableInputs);

  saveBtn.addEventListener("click", () => {
    if (
      fnameInput.value &&
      emailInput.value &&
      numberInput.value &&
      addressInput.value &&
      datebirthInput.value &&
      genderInput.value
    ) {
      alert("Your information has been saved successfully");
    } else {
      alert("Please fill out all fields.");
    }
  });
});

