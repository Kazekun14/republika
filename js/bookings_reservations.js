function toggleMenu() {
  const navLinks = document.querySelector('.navbar-head ul');
  if (navLinks) {
    navLinks.classList.toggle("active");
  }
}

function showRecord(action) {
    const slider = document.getElementById('slider');
    const bRecord = document.getElementById('bRecord');
    const rRecord = document.getElementById('rRecord');

    if (action === 'bRecord') {
        slider.style.left = '0';
        bRecord.style.display = 'block';
        rRecord.style.display = 'none';
    } else if (action === 'rRecord') {
        slider.style.left = '50%';
        rRecord.style.display = 'block';
        bRecord.style.display = 'none';
    }
}



