const urlParams = new URLSearchParams(window.location.search);
const adultsURL = urlParams.get('adults');
const childrenURL = urlParams.get('children');
const totalGuestsURL = urlParams.get('totalGuests');

const flnameINPUT = document.getElementById('flname');
const emailINPUT = document.getElementById('email');
const chckInINPUT = document.getElementById('chckIn');
const chckOutINPUT = document.getElementById('chckOut');
const timeInINPUT = document.getElementById('timeIn');
const timeOutINPUT = document.getElementById('timeOut');
const guestcountINPUT = document.getElementById('guest-count');
const adultscountINPUT = document.getElementById('adults-count');
const childrencountINPUT = document.getElementById('children-count');

const dropdownButton = document.getElementById("guest-dropdown-button");
const dropdownMenu = document.getElementById("guest-dropdown-menu");
const adultsIncrement = document.getElementById("adults-increment");
const adultsDecrement = document.getElementById("adults-decrement");
const childrenIncrement = document.getElementById("children-increment");
const childrenDecrement = document.getElementById("children-decrement");

function toggleMenu() {
  const navLinks = document.querySelector('.navbar-head ul');
  if (navLinks) {
    navLinks.classList.toggle("active");
  }
}

const today = new Date().toISOString().split("T")[0];
chckInINPUT.setAttribute("min", today);

const chckIn = chckInINPUT.value || today;
chckOutINPUT.setAttribute("min", chckIn);

chckInINPUT.addEventListener("change", () => {
  const chckIn = chckInINPUT.value;
  chckOutINPUT.setAttribute("min", chckIn);

  if (chckOutINPUT.value && chckOutINPUT.value < chckIn) {
    chckOutINPUT.value = "";
  }
});

[chckInINPUT, chckOutINPUT].forEach((input) => {
  input.addEventListener("click", () => {
    if (typeof input.showPicker === "function") {
      input.showPicker();
    } else {
      input.focus();
    }
  });
});

timeInINPUT.addEventListener("click", () => {
  timeInINPUT.showPicker();
});

timeOutINPUT.addEventListener("click", () => {
  timeOutINPUT.showPicker();
});

guestcountINPUT.textContent = totalGuestsURL;
adultscountINPUT.textContent = adultsURL;
childrencountINPUT.textContent = childrenURL;

if (dropdownButton && dropdownMenu) {
  dropdownButton.addEventListener("click", (event) => {
    event.preventDefault();
    event.stopPropagation();
    dropdownMenu.style.display =
      dropdownMenu.style.display === "block" ? "none" : "block";
  });

  dropdownMenu.addEventListener("click", (event) => event.stopPropagation());

  document.addEventListener("click", () => {
    dropdownMenu.style.display = "none";
  });
}

let adultsCount = parseInt(adultsURL, 10);
let childrenCount = parseInt(childrenURL, 10);

const updateGuestCount = () => {
  const totalGuests = adultsCount + childrenCount;
  guestcountINPUT.textContent = totalGuests;
  document.getElementById("hidden-adults").value = adultsCount;
  document.getElementById("hidden-children").value = childrenCount;
  document.getElementById("hidden-total-guests").value = totalGuests;
};

if (adultsIncrement && adultsDecrement && adultscountINPUT) {
  const updateDecrementButtonState = () => {
    adultsDecrement.disabled = adultsCount <= 1;
  };

  updateDecrementButtonState();

  adultsIncrement.addEventListener("click", (event) => {
    event.preventDefault();
    adultsCount++;
    adultscountINPUT.textContent = adultsCount;
    updateDecrementButtonState();
    updateGuestCount();
  });

  adultsDecrement.addEventListener("click", (event) => {
    event.preventDefault();
    if (adultsCount > 1) {
      adultsCount--;
      adultscountINPUT.textContent = adultsCount;
      updateDecrementButtonState();
      updateGuestCount();
    }
  });
}

if (childrenIncrement && childrenDecrement && childrencountINPUT) {
  const updateDecrementButtonState = () => {
    childrenDecrement.disabled = childrenCount <= 0;
  };

  updateDecrementButtonState();

  childrenIncrement.addEventListener("click", (event) => {
    event.preventDefault();
    childrenCount++;
    childrencountINPUT.textContent = childrenCount;
    updateDecrementButtonState();
    updateGuestCount();
  });

  childrenDecrement.addEventListener("click", (event) => {
    event.preventDefault();
    if (childrenCount > 0) {
      childrenCount--;
      childrencountINPUT.textContent = childrenCount;
      updateDecrementButtonState();
      updateGuestCount();
    }
  });
}

document.getElementById("bkngForm").addEventListener("submit", (event) => {
  updateGuestCount();
});

const modal = document.getElementById('modal');

function openModal() {
  modal.style.display = 'flex';
}

function closeModal() {
  modal.style.display = 'none';
}

function cnfrmBook() {
  const timeValue = timeInINPUT.value;

  const hours = parseInt(timeValue.split(':')[0]);
  const minutes = parseInt(timeValue.split(':')[1]);

  if ((flnameINPUT.value && emailINPUT.value && chckInINPUT.value && timeInINPUT.value && chckOutINPUT.value && timeOutINPUT.value && 
    guestcountINPUT.textContent) && !(hours >= 20 || hours < 7 || (hours === 7 && minutes <= 30))) {
    const formData = new FormData();

    formData.append('id', id);
    formData.append('username', username);
    formData.append('flname', flnameINPUT.value);
    formData.append('email', emailINPUT.value);
    formData.append('chckIn', chckInINPUT.value);
    formData.append('timeIn', timeInINPUT.value);
    formData.append('chckOut', chckOutINPUT.value);
    formData.append('timeOut', timeOutINPUT.value);
    formData.append('guestcount', guestcountINPUT.textContent);

    fetch('../php/store_booking.php', {
    method: 'POST',
    body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success === true) {
          const queryString = `accommodation=${encodeURIComponent(data.bdata.accommodation)}&fullname=${encodeURIComponent(data.bdata.fullname)}&email=${encodeURIComponent(data.bdata.email)}&checkin=${encodeURIComponent(data.bdata.checkin)}&timein=${encodeURIComponent(data.bdata.timein)}&checkout=${encodeURIComponent(data.bdata.checkout)}&timeout=${encodeURIComponent(data.bdata.timeout)}&guests=${encodeURIComponent(data.bdata.guests)}&price=${encodeURIComponent(data.bdata.price)}`;
          alert("Your booking has been successfully completed!");
          window.location.href = `../php/booking_summary.php?${queryString}`;
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
  } else if (hours >= 20 || hours < 7 || (hours === 7 && minutes <= 30)) {
    alert("Bookings are unavailable between 8:00 PM and 7:30 AM.");
  } else {
    alert("Please fill out the form before proceeding.");
  }
}