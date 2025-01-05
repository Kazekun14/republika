document.getElementById("accommodation_service").addEventListener("change", function () {
  const category = this.value;
  const labelCheckinDate = document.getElementById("labelCheckinDate");
  const labelCheckoutTime = document.getElementById("labelCheckoutTime");
  const checkoutTime = document.getElementById("checkoutTime");

  if (["food_and_beverage", "event_catering", "entertainment_and_event"].includes(category)) {

    labelCheckinDate.textContent = "DATE";
    labelCheckoutTime.textContent = "TIME";

    checkoutTime.type = "time";
  } else {
    
    labelCheckinDate.textContent = "CHECK-IN";
    labelCheckoutTime.textContent = "CHECK-OUT";

    checkoutTime.type = "date";
  }
});

const today = new Date().toISOString().split("T")[0];
const checkInInput = document.getElementById("checkinDate");
const checkOutInput = document.getElementById("checkoutTime");

checkInInput.setAttribute("min", today);

const checkInDate = checkInInput.value || today;
checkOutInput.setAttribute("min", checkInDate);

checkInInput.addEventListener("change", () => {
  const checkInDate = checkInInput.value;
  checkOutInput.setAttribute("min", checkInDate);
  if (checkOutInput.value && checkOutInput.value < checkInDate) {
    checkOutInput.value = "";
  }
});

[checkInInput, checkOutInput].forEach((input) => {
  input.addEventListener("click", () => {
    if (typeof input.showPicker === "function") {
      input.showPicker();
    } else {
      input.focus();
    }
  });
});

function toggleMenu() {
  const navLinks = document.querySelector(".navigation");
  if (navLinks) {
    navLinks.classList.toggle("active");
  }
}

const dropdownButton = document.getElementById("guest-dropdown-button");
const dropdownMenu = document.getElementById("guest-dropdown-menu");

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

const guestCount = document.getElementById("guest-count");
const adultsCountElem = document.getElementById("adults-count");
const childrenCountElem = document.getElementById("children-count");

const adultsIncrement = document.getElementById("adults-increment");
const adultsDecrement = document.getElementById("adults-decrement");
const childrenIncrement = document.getElementById("children-increment");
const childrenDecrement = document.getElementById("children-decrement");

let adultsCount = 1;
let childrenCount = 0;

const updateGuestCount = () => {
  const totalGuests = adultsCount + childrenCount;
  guestCount.textContent = totalGuests;
  document.getElementById("hidden-adults").value = adultsCount;
  document.getElementById("hidden-children").value = childrenCount;
  document.getElementById("hidden-total-guests").value = totalGuests;
};

if (adultsIncrement && adultsDecrement && adultsCountElem) {
  adultsIncrement.addEventListener("click", (event) => {
    event.preventDefault();
    adultsCount++;
    adultsCountElem.textContent = adultsCount;
    adultsDecrement.disabled = adultsCount <= 1;
    updateGuestCount();
  });

  adultsDecrement.addEventListener("click", (event) => {
    event.preventDefault();
    if (adultsCount > 1) {
      adultsCount--;
      adultsCountElem.textContent = adultsCount;
      adultsDecrement.disabled = adultsCount <= 1;
      updateGuestCount();
    }
  });
}

if (childrenIncrement && childrenDecrement && childrenCountElem) {
  childrenIncrement.addEventListener("click", (event) => {
    event.preventDefault();
    childrenCount++;
    childrenCountElem.textContent = childrenCount;
    childrenDecrement.disabled = childrenCount <= 0;
    updateGuestCount();
  });

  childrenDecrement.addEventListener("click", (event) => {
    event.preventDefault();
    if (childrenCount > 0) {
      childrenCount--;
      childrenCountElem.textContent = childrenCount;
      childrenDecrement.disabled = childrenCount <= 0;
      updateGuestCount();
    }
  });
}

document.getElementById("searchForm").addEventListener("submit", (event) => {
  updateGuestCount();
});

const carousel = document.getElementById("carousel");
const prevButton = document.getElementById("prevButton");
const nextButton = document.getElementById("nextButton");

let currentIndex = 0;

function updateCarousel() {
  const visibleWidth = carousel.parentElement.offsetWidth;
  const imageWidth = carousel.querySelector(".carousel-item").offsetWidth + 10;
  const totalImages = carousel.children.length;


  const visibleImages = Math.floor(visibleWidth / imageWidth);

  const maxIndex = Math.max(0, totalImages - visibleImages);

  currentIndex = Math.min(currentIndex, maxIndex);

  carousel.style.transform = `translateX(-${currentIndex * imageWidth}px)`;

  prevButton.style.display = currentIndex === 0 ? "none" : "block";
  nextButton.style.display = currentIndex >= maxIndex ? "none" : "block";
}

prevButton.addEventListener("click", () => {
  if (currentIndex > 0) {
    currentIndex--;
    updateCarousel();
  }
});

nextButton.addEventListener("click", () => {
  const visibleWidth = carousel.parentElement.offsetWidth;
  const imageWidth = carousel.querySelector(".carousel-item").offsetWidth + 10;
  const totalImages = carousel.children.length;
  const visibleImages = Math.floor(visibleWidth / imageWidth);
  const maxIndex = Math.max(0, totalImages - visibleImages);

  if (currentIndex < maxIndex) {
    currentIndex++;
    updateCarousel();
  }
});

window.addEventListener("resize", updateCarousel);

updateCarousel();

const adultsDef = 1;
const childrenDef = 0;
const totalGuests = adultsDef + childrenDef;
const defaultDateTime = "";

function navigateToService(service) {
    const queryString = `accommodation_service=${encodeURIComponent(service)}&checkinDate=${encodeURIComponent(defaultDateTime)}&checkoutTime=${encodeURIComponent(defaultDateTime)}&adults=${encodeURIComponent(adultsDef)}&children=${encodeURIComponent(childrenDef)}&totalGuests=${encodeURIComponent(totalGuests)}`;

    window.location.href = `php/accommodation-service.php?${queryString}`;
}

function room() {
    navigateToService('room');
}

function dorm() {
    navigateToService('dorm');
}

function foodBeverage() {
    navigateToService('food_and_beverage');
}

function eventCatering() {
    navigateToService('event_catering');
}

function entertainmentEvent() {
    navigateToService('entertainment_and_event');
}
