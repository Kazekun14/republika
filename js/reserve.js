const fnameINPUT = document.getElementById('fname');
const emlINPUT = document.getElementById('eml');
const dteINPUT = document.getElementById('dte');
const timINPUT = document.getElementById('tim');
const gstcountINPUT = document.getElementById('guest-count');
const adltcountINPUT = document.getElementById('adults-count');
const chldrncountINPUT = document.getElementById('children-count');
const adrsINPUT = document.getElementById('adrs');

const dropdownButton = document.getElementById("guest-dropdown-button");
const dropdownMenu = document.getElementById("guest-dropdown-menu");
const adultsIncrement = document.getElementById("adults-increment");
const adultsDecrement = document.getElementById("adults-decrement");
const childrenIncrement = document.getElementById("children-increment");
const childrenDecrement = document.getElementById("children-decrement");
const inptContaineradrs = document.getElementById("inptContaineradrs");
const modal = document.getElementById("modal");

if (["food_and_beverage", "entertainment_and_event"].includes(service.type)) {
	fnameINPUT.value = userdta1 && userdta1.fullname ? userdta1.fullname : "";
	emlINPUT.value = userdta1 && userdta1.email ? userdta1.email : "";
	dteINPUT.value = userdta2 && userdta2.date ? userdta2.date : "";
	timINPUT.value = userdta2 && userdta2.time ? userdta2.time : "";
	adltcountINPUT.textContent = userdta2.adults;
	chldrncountINPUT.textContent = userdta2.children;
	gstcountINPUT.textContent = userdta2.totalGuests;

	fnameINPUT.disabled = userdta1 && userdta1.fullname ? true : false;
	emlINPUT.disabled = userdta1 && userdta1.email ? true : false;

	inptContaineradrs.style.display = 'none';
	adrsINPUT.removeAttribute("name");

	function confirmReserve() {
		if (fnameINPUT.value && emlINPUT.value && dteINPUT.value && timINPUT.value && gstcountINPUT.textContent && 
			adltcountINPUT.textContent && chldrncountINPUT.textContent) {
			const timeValue = timINPUT.value;

		  	const hours = parseInt(timeValue.split(':')[0]);
		  	const minutes = parseInt(timeValue.split(':')[1]);

		  	if (!(hours >= 20 || hours < 7 || (hours === 7 && minutes <= 30))) {
		  		const frmData = new FormData();

		  		frmData.append('username', username);
		  		frmData.append('fullname', fnameINPUT.value);
		  		frmData.append('email', emlINPUT.value);
		  		frmData.append('date', dteINPUT.value);
		  		frmData.append('time', timINPUT.value);
		  		frmData.append('guests', gstcountINPUT.textContent);
		  		frmData.append('servicename', service.name);
		  		frmData.append('serviceprice', service.price);

		  		fetch('../php/store_reservation.php', {
		  			method: 'POST',
		  			body: frmData
		  		})
		  		.then(response => {
		  			if (!response.ok) {
			            throw new Error('Network response was not ok');
			        }
			        return response.json();
		  		})
		  		.then(data => {
		  			if (data.success === true) {
		  				const queryString = `service=${encodeURIComponent(data.rsrvdata.servicename)}&fullname=${encodeURIComponent(data.rsrvdata.fullname)}&email=${encodeURIComponent(data.rsrvdata.email)}&address=${encodeURIComponent(data.rsrvdata.address)}&date=${encodeURIComponent(data.rsrvdata.date)}&time=${encodeURIComponent(data.rsrvdata.time)}&guests=${encodeURIComponent(data.rsrvdata.guests)}&serviceprice=${encodeURIComponent(data.rsrvdata.serviceprice)}`;
				        alert("Your reservation has been successfully completed!");
				        window.location.href = `../php/reservation_summary.php?${queryString}`;
		  			}
		  		})
		  		.catch((error) => {
        			console.error('Error:', error);
    			});
		  	} else {
		  		alert("Reservations are unavailable from 8:00 PM to 7:30 AM.");
		  	}
		} else {
			alert("Please fill out the form before proceeding.");
		}
	}
} else {
	fnameINPUT.value = userdta1 && userdta1.fullname ? userdta1.fullname : "";
	emlINPUT.value = userdta1 && userdta1.email ? userdta1.email : "";
	adrsINPUT.value = userdta1 && userdta1.address ? userdta1.address : "";
	dteINPUT.value = userdta2 && userdta2.date ? userdta2.date : "";
	timINPUT.value = userdta2 && userdta2.time ? userdta2.time : "";
	adltcountINPUT.textContent = userdta2.adults;
	chldrncountINPUT.textContent = userdta2.children;
	gstcountINPUT.textContent = userdta2.totalGuests;

	fnameINPUT.disabled = userdta1 && userdta1.fullname ? true : false;
	emlINPUT.disabled = userdta1 && userdta1.email ? true : false;
	adrsINPUT.disabled = userdta1 && userdta1.address ? true : false;

	inptContaineradrs.style.display = 'block';
	adrsINPUT.setAttribute("name", "adrs");

	function confirmReserve() {
		if (fnameINPUT.value && emlINPUT.value && adrsINPUT.value && dteINPUT.value && timINPUT.value && gstcountINPUT.textContent && 
			adltcountINPUT.textContent && chldrncountINPUT.textContent) {
			const timeValue = timINPUT.value;

		  	const hours = parseInt(timeValue.split(':')[0]);
		  	const minutes = parseInt(timeValue.split(':')[1]);

		  	if (!(hours >= 20 || hours < 7 || (hours === 7 && minutes <= 30))) {
		  		const frmData = new FormData();

		  		frmData.append('username', username);
		  		frmData.append('fullname', fnameINPUT.value);
		  		frmData.append('email', emlINPUT.value);
		  		frmData.append('address', adrsINPUT.value);
		  		frmData.append('date', dteINPUT.value);
		  		frmData.append('time', timINPUT.value);
		  		frmData.append('guests', gstcountINPUT.textContent);
		  		frmData.append('servicename', service.name);
		  		frmData.append('serviceprice', service.price);

		  		fetch('../php/store_reservation.php', {
		  			method: 'POST',
		  			body: frmData
		  		})
		  		.then(response => {
		  			if (!response.ok) {
			            throw new Error('Network response was not ok');
			        }
			        return response.json();
		  		})
		  		.then(data => {
		  			if (data.success === true) {
		  				const queryString = `service=${encodeURIComponent(data.rsrvdata.servicename)}&fullname=${encodeURIComponent(data.rsrvdata.fullname)}&email=${encodeURIComponent(data.rsrvdata.email)}&address=${encodeURIComponent(data.rsrvdata.address)}&date=${encodeURIComponent(data.rsrvdata.date)}&time=${encodeURIComponent(data.rsrvdata.time)}&guests=${encodeURIComponent(data.rsrvdata.guests)}&serviceprice=${encodeURIComponent(data.rsrvdata.serviceprice)}`;
				        alert("Your reservation has been successfully completed!");
				        window.location.href = `../php/reservation_summary.php?${queryString}`;
		  			}
		  		})
		  		.catch((error) => {
        			console.error('Error:', error);
    			});
		  	} else {
		  		alert("Reservations are unavailable from 8:00 PM to 7:30 AM.");
		  	}
		} else {
			alert("Please fill out the form before proceeding.");
		}
	}
}

function toggleMenu() {
  const navLinks = document.querySelector('.navbar-head ul');
  if (navLinks) {
    navLinks.classList.toggle("active");
  }
}

const today = new Date().toISOString().split("T")[0];
dteINPUT.setAttribute("min", today);

dteINPUT.addEventListener("click", () => {
	dteINPUT.showPicker();
});

timINPUT.addEventListener("click", () => {
	timINPUT.showPicker();
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

let adultsCount = parseInt(userdta2.adults);
let childrenCount = parseInt(userdta2.children);

const updateGuestCount = () => {
  const totalGuests = adultsCount + childrenCount;
  gstcountINPUT.textContent = totalGuests;
  document.getElementById("hidden-adults").value = adultsCount;
  document.getElementById("hidden-children").value = childrenCount;
  document.getElementById("hidden-total-guests").value = totalGuests;
};

if (adultsIncrement && adultsDecrement && adltcountINPUT) {
  const updateDecrementButtonState = () => {
    adultsDecrement.disabled = adultsCount <= 1;
  };

  updateDecrementButtonState();

  adultsIncrement.addEventListener("click", (event) => {
    event.preventDefault();
    adultsCount++;
    adltcountINPUT.textContent = adultsCount;
    updateDecrementButtonState();
    updateGuestCount();
  });

  adultsDecrement.addEventListener("click", (event) => {
    event.preventDefault();
    if (adultsCount > 1) {
      adultsCount--;
      adltcountINPUT.textContent = adultsCount;
      updateDecrementButtonState();
      updateGuestCount();
    }
  });
}

if (childrenIncrement && childrenDecrement && chldrncountINPUT) {
  const updateDecrementButtonState = () => {
    childrenDecrement.disabled = childrenCount <= 0;
  };

  updateDecrementButtonState();

  childrenIncrement.addEventListener("click", (event) => {
    event.preventDefault();
    childrenCount++;
    chldrncountINPUT.textContent = childrenCount;
    updateDecrementButtonState();
    updateGuestCount();
  });

  childrenDecrement.addEventListener("click", (event) => {
    event.preventDefault();
    if (childrenCount > 0) {
      childrenCount--;
      chldrncountINPUT.textContent = childrenCount;
      updateDecrementButtonState();
      updateGuestCount();
    }
  });
}

document.getElementById("frmReserve").addEventListener("submit", (event) => {
  updateGuestCount();
});

function openModal() {
  modal.style.display = 'flex';
}

function closeModal() {
  modal.style.display = 'none';
}
