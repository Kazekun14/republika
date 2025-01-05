const urlParams = new URLSearchParams(window.location.search);
const accserURL = urlParams.get('accommodation_service');
const checkinDateURL = urlParams.get('checkinDate');
const checkoutTimeURL = urlParams.get('checkoutTime');
const adultsURL = urlParams.get('adults');
const childrenURL = urlParams.get('children');
const totalGuestsURL = urlParams.get('totalGuests');

const labelCheckinDate = document.getElementById('labelCheckinDate');
const labelCheckoutTime = document.getElementById('labelCheckoutTime');

const accserINPUT = document.getElementById('accommodation_service');
const checkinDateINPUT = document.getElementById('checkinDate');
const checkoutTimeINPUT = document.getElementById('checkoutTime');
const guestcountINPUT = document.getElementById('guest-count');
const adultscountINPUT = document.getElementById('adults-count');
const childrencountINPUT = document.getElementById('children-count');

const dropdownButton = document.getElementById("guest-dropdown-button");
const dropdownMenu = document.getElementById("guest-dropdown-menu");
const adultsIncrement = document.getElementById("adults-increment");
const adultsDecrement = document.getElementById("adults-decrement");
const childrenIncrement = document.getElementById("children-increment");
const childrenDecrement = document.getElementById("children-decrement");

const accserSPAN = document.getElementById('acc-ser');
const cinDateSPAN = document.getElementById('cinDate');
const coutTimeSPAN = document.getElementById('coutTime');
const guestsSPAN = document.getElementById('guests');

const editSearch = document.getElementById('editSearch');
const searchForm = document.getElementById('searchForm');
const dtaContainer = document.querySelector('.dta-container');

function toggleMenu() {
  const navLinks = document.querySelector('.navbar-head ul');
  if (navLinks) {
    navLinks.classList.toggle("active");
  }
}

var textReserveBook;

if (["food_and_beverage", "event_catering", "entertainment_and_event"].includes(accserURL)) {

	labelCheckinDate.textContent = "DATE";
    labelCheckoutTime.textContent = "TIME";

    checkoutTime.type = "time";

    if (checkinDateURL && checkoutTimeURL) {
      cinDateSPAN.textContent = "Date: " + checkinDateURL;
      coutTimeSPAN.textContent = "Time: " + checkoutTimeURL;
    } else {
      cinDateSPAN.textContent = "";
      coutTimeSPAN.textContent = "";
      cinDateSPAN.style.margin = 0;
      coutTimeSPAN.style.margin = 0;
    }

    guestsSPAN.textContent = 'Guests: ' + totalGuestsURL;

    textReserveBook = "Reserve";
} else {
    
    labelCheckinDate.textContent = "CHECK-IN";
    labelCheckoutTime.textContent = "CHECK-OUT";

    checkoutTime.type = "date";

    if (checkinDateURL && checkoutTimeURL) {
      cinDateSPAN.textContent = "Check-in: " + checkinDateURL;
      coutTimeSPAN.textContent = "Check-out: " + checkoutTimeURL;
    } else {
      cinDateSPAN.textContent = "";
      coutTimeSPAN.textContent = "";
      cinDateSPAN.style.margin = 0;
      coutTimeSPAN.style.margin = 0;
    }

    guestsSPAN.textContent = 'Guests: ' + totalGuestsURL;

    textReserveBook = "Book";
}

accserINPUT.addEventListener("change", function () {
  const category = this.value;
  const isSpecialCategory = ["food_and_beverage", "event_catering", "entertainment_and_event"].includes(category);

  labelCheckinDate.textContent = isSpecialCategory ? "DATE" : "CHECK-IN";
  labelCheckoutTime.textContent = isSpecialCategory ? "TIME" : "CHECK-OUT";

  checkoutTime.type = isSpecialCategory ? "time" : "date";
});

accserINPUT.value = accserURL;
checkinDateINPUT.value = checkinDateURL;
checkoutTimeINPUT.value = checkoutTimeURL;
adultscountINPUT.textContent = adultsURL;
childrencountINPUT.textContent = childrenURL;
guestcountINPUT.textContent = totalGuestsURL;

const today = new Date().toISOString().split("T")[0];
checkinDateINPUT.setAttribute("min", today);

const checkInDate = checkinDateINPUT.value || today;
checkoutTimeINPUT.setAttribute("min", checkInDate);

checkinDateINPUT.addEventListener("change", () => {
  const checkInDate = checkinDateINPUT.value;
  checkoutTimeINPUT.setAttribute("min", checkInDate);

  if (checkoutTimeINPUT.value && checkoutTimeINPUT.value < checkInDate) {
    checkoutTimeINPUT.value = "";
  }
});

[checkinDateINPUT, checkoutTimeINPUT].forEach((input) => {
  input.addEventListener("click", () => {
    if (typeof input.showPicker === "function") {
      input.showPicker();
    } else {
      input.focus();
    }
  });
});

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

document.getElementById("searchForm").addEventListener("submit", (event) => {
  updateGuestCount();
});

switch (accserURL) {
  case 'room':
    accserSPAN.textContent = 'Room';
    break;
  case 'dorm':
    accserSPAN.textContent = 'Dorm';
    break;
  case 'food_and_beverage':
    accserSPAN.textContent = 'Food and Beverage';
    break;
  case 'event_catering':
    accserSPAN.textContent = 'Event Catering';
    break;
  case 'entertainment_and_event':
    accserSPAN.textContent = 'Entertainment and Event';
    break;
  default:
    accserSPAN.textContent = 'Error';
}

function handleResize() {
  if (window.innerWidth <= 683) {
    
    searchForm.style.display = 'none';
    dtaContainer.style.display = 'flex';
  } else {
    
    searchForm.style.display = 'flex';
    dtaContainer.style.display = 'none';
  }
}

window.addEventListener('resize', handleResize);
handleResize();

if (editSearch && searchForm) {
  editSearch.addEventListener('click', (event) => {
    event.preventDefault();
    event.stopPropagation();
    searchForm.style.display = 'flex';
    dtaContainer.style.display = 'none';
  });

  searchForm.addEventListener('click', (event) => event.stopPropagation());

  document.addEventListener('click', () => {
    if (window.innerWidth <= 683) {
      searchForm.style.display = 'none';
      dtaContainer.style.display = 'flex';
    }
  });
}
