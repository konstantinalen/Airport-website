//Εμφανίζει τα links στο bar menu της μικρής οθόνης όταν ο χρήστης πατάει το κουμπί
function Show_Links() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}


window.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const showForm = urlParams.get("showForm");
  const errorRU = urlParams.get("errorRU");

  const rform = document.getElementById("RegisterForm");
  const lform = document.getElementById("LoginForm");

  if (showForm === "register") {
    if (rform) rform.style.display = "block";
    if (lform) lform.style.display = "none";
  }
});

//Όταν ο χρήστης πατάει το register here εμφανίζεται η φόρμα για εγγραφή και κρύβεται η φόρμα για σύνδεση
function Show_Register() {
  var rform = document.getElementById("RegisterForm");

  if (rform.style.display === "none")
  {
    rform.style.display = "block";
  } 
  else 
  {
    rform.style.display = "none";
  }

  var lform = document.getElementById("LoginForm");
  lform.style.display = "none";
}

//Εμφανίζει τα αεροδρόμια στο dropdown menu ώστε να επιλέξει ο χρήστης
document.addEventListener("DOMContentLoaded", function () {
  let airports = [];

  const depSelect = document.getElementById("airport-select");
  const arrSelect = document.getElementById("airport_select");

  fetch('Air.php')
    .then(response => response.json())
    .then(data => {
      airports = data;
      updateSelects();
      
      depSelect.innerHTML = '';
      arrSelect.innerHTML = '';

      const defaultDep = new Option("Select departure airport", "", true, true);
      defaultDep.disabled = true;
      const defaultArr = new Option("Select arrival airport", "", true, true);
      defaultArr.disabled = true;

      depSelect.add(defaultDep);
      arrSelect.add(defaultArr);

      data.forEach(airport => {
        const option1 = new Option(`${airport.name} ${airport.code}`, airport.name);
        const option2 = new Option(`${airport.name} ${airport.code}`, airport.name);

        depSelect.add(option1);
        arrSelect.add(option2);
      });
    })
    .catch(error => {
      console.error("Error loading airports:", error);
    });

  function updateSelects(){
    const selectedDeparture = depSelect.value;
    const selectedArrival = arrSelect.value;

    fillSelect(depSelect, "Departure Airport", selectedArrival); 
    fillSelect(arrSelect, "Arrival Airport", selectedDeparture);  

    if (selectedDeparture) depSelect.value = selectedDeparture;
    if (selectedArrival) arrSelect.value = selectedArrival;
  }

  function fillSelect(selectElement, label, excludeValue) {
    selectElement.innerHTML = "";
    const defaultOption = document.createElement("option");
    defaultOption.disabled = true;
    defaultOption.selected = true;
    defaultOption.textContent = `Select ${label}`;
    selectElement.appendChild(defaultOption);

    airports.forEach(airport => {
      const airportName = airport.name;
      if (airportName !== excludeValue) { // Αποκλείει την επιλογή που έχει γίνει
        const option = document.createElement("option");
        option.value = airportName;
        option.textContent = `${airport.name} ${airport.code}`;
        selectElement.appendChild(option);
      }
    });
  }

  depSelect.addEventListener("change", updateSelects);
  arrSelect.addEventListener("change", updateSelects);
});

//Ελέγχει την τιμή του ονόματος που πληκτρολογεί ο χρήστης όταν κάνει εγγραφή
function Check_FName() {
  const fname = document.getElementById("fname").value;
  const name = document.getElementById("fname");

  const validName = /^[a-zA-Zα-ωΑ]+$/;

  if (!validName.test(fname) || fname == "") 
  {
    name.classList.add("input-error");
  } 
  else 
  {
    name.classList.remove("input-error");
  }

  allValid();
}

//Ελέγχει την τιμή του επωνύμου που πληκτρολογεί ο χρήστης όταν κάνει εγγραφή
function Check_LName() {
  const lname = document.getElementById("lname").value;
  const name = document.getElementById("lname");

  const validName = /^[a-zA-Z]+$/;

  if (!validName.test(lname)) 
  {
    name.classList.add("input-error");
  } 
  else 
  {
    name.classList.remove("input-error");
  }

  allValid();
}

//Ελέγχει την τιμή του username που πληκτρολογεί ο χρήστης όταν κάνει εγγραφή
function Check_Username() {
  const username = document.getElementById("username").value;
  const name = document.getElementById("username");

  if (username == "") 
  {
    name.classList.add("input-error");
  } 
  else 
  {
    name.classList.remove("input-error");
  }
}

//Ελέγχει την τιμή του password που πληκτρολογεί ο χρήστης όταν κάνει εγγραφή
function Check_Password() {
  const password = document.getElementById("password").value;
  const pass = document.getElementById("password");

  const validPassword = /^[a-zA-Z0-9]{4,10}$/;
  const hasDigit = /\d/;

  if (!validPassword.test(password) || !hasDigit.test(password)) {
    pass.classList.add("input-error");
  } 
  else 
  {
    pass.classList.remove("input-error");
  }

  allValid();
}

//Ελέγχει την τιμή του email που πληκτρολογεί ο χρήστης όταν κάνει εγγραφή
function Check_Email() {
  const email = document.getElementById("email").value;
  const em = document.getElementById("email");
  const valid = /.+@.+\..+/;

  if (!valid.test(email))
  {
    em.classList.add("input-error");
  } 
  else 
  {
    em.classList.remove("input-error");
  }

  allValid();
}

//Όταν ο χρήστης πατήσει πάνω σε ένα πεδίο καλεί όλες τις συνερτήσεις ελέγχου των πεδίων για να μην αφήσει κάποιο πεδίο κενό
document.addEventListener("input", () => {
  Check_FName();
  Check_LName();
  Check_Email();
  Check_Password();
  Check_Username();
});

//Αν όλα τα πεδία είναι σωστά, ενεργοποιείται το κουμπί ώστε να μπορεί να κάνει εγγραφή
function allValid() {
  const button = document.getElementById("regBtn");
  const errors = document.querySelectorAll(".input-error");
  button.disabled = errors.length > 0;
}

//Ελέγχει αν είναι σωστές οι τιμές στα πεδία που συμπληρώνουν οι υπόλοιποι επιβάτες ακτός του πρώτου και ανάλογα εμφανίζει ή κρύβει το διάγραμμα επιλογής θέσεων
document.addEventListener("DOMContentLoaded", function () {
  const inputs = document.querySelectorAll(".check_input");
  const seatDiv = document.getElementById("choose_seat");
  number = Seats;

  if (number >= 2) 
  {
    inputs.forEach(input => {
      input.addEventListener("input", validateFields);
    });

    function validateFields() {
      let allValid = true;
      const valid = /^[A-Za-zΑ-Ωα-ω]{3,20}$/;

      inputs.forEach(input => {
          const val = input.value.trim();
          if (!valid.test(val))
          {
            allValid = false;
          }
      });

      seatDiv.style.display = allValid ? "block" : "none";
    }
  }
  else
  {
    seatDiv.style.display = "block";
  }
  
});

//Παίρνει τις θέσεις που έχει επιλέξει ο χρήστης και τις προσθέτει στην κλάση "selected". Αν οι ο αριθμός θέσεων είναι ίδιος με τον αριθμό επιβατών, εμφανίζει τα στοιχεία κράτησης
let count = 0;
let selectedSeats = [];
let seats = 0;
function selectedSeat(id) {
  const el = document.getElementById(id);
  const display = document.getElementById("selected-seat");
  display.textContent =  el.id.replace("highlight-", "");
  const wasSelected = el.classList.contains("selected");
  const button = document.getElementById("reserveButton");
  console.log(el);
  el.classList.toggle("selected");

  if (wasSelected) 
  {
    count--;
    const index = selectedSeats.indexOf(display.textContent);
    if (index !== -1)
    {
      selectedSeats.splice(index, 1);
    }
  } 
  else 
  {
    count++;
    if (count > number) 
    {
      alert("You can only choose " + number + " seats");
      el.classList.remove("selected");
      count--;
    }
    else
    {
      selectedSeats.push(display.textContent);
    }
  }

  display.textContent = selectedSeats.join(", ");

  if (count == number)
  {
    const details = document.getElementById("details");
    details.style.display = "flex";

    button.style.display = "flex";
    button.disabled = false;
  }
  else
  {
    button.disabled = true;
  }
  seatCost(selectedSeats.length);
}

//Υπολογίζει το κόστος της θέσης και καλεί την συνάρτηση totalCost για τον υπολογισμό του συνολικού κόστους
let seat_cost = 0;
function seatCost() {
  let cost = 0;
  for (let i = 0; i < selectedSeats.length; i++) {
    const seat = selectedSeats[i];

    const seatNumber = parseInt(seat.match(/\d+/)[0]);
    if (seatNumber === 1 || seatNumber === 11 || seatNumber === 12) {
      cost += 20;
    } else if (seatNumber === 10 || (seatNumber >= 2 && seatNumber <= 10)) {
      cost += 10;
    }
  }
  seat_cost = cost;
  totalCost("0",cost, selectedSeats.length);
}


//Υπολογισμός του συνολικού κόστους
let totalTaxes = 0;
let d = 0;
let Count = 0;
function totalCost(tax, SEAT, number) {
  const cost = document.getElementById("totalCost");

  if (Count == 0)
  {
    let data = tax.match(/\d+.\d+|\d+/g);

    totalTaxes = Number(data[0]) + Number(data[1]);

      let dep_lat = Number(data[2]) * (Math.PI / 180);
      let dep_long = Number(data[3]) * (Math.PI / 180);
      let arr_lat = Number(data[4]) * (Math.PI / 180);
      let arr_long = Number(data[5]) * (Math.PI / 180);

    d = (2*6371 * Math.asin(Math.sqrt(Math.sin((arr_lat-dep_lat)/2)**2)+Math.cos(dep_lat)*Math.cos(arr_lat)*Math.sin((arr_long-dep_long)/2)**2))/10;

    Count++;
  }
  else
  {
    let totalCost = SEAT + (d + totalTaxes)*number;
    cost.textContent = parseInt(totalCost) + '$';
  }
}

//Στέλνει τις θέσεις στην php με όνομα InsertTrips.php με την χρήση fetch
function SendSeats() {
  const seatList = selectedSeats;
  formData.append('seatList', seatList);
  formData.append('taxes', totalTaxes);
  formData.append('cost', seat_cost);

  fetch('InsertTrips.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {

    console.log(data);

  })
  .catch(error => console.error('Σφάλμα:', error));
}

//Ακύρωση κράτησης
function Cancel_Res(res_id) {
  const reservationId = res_id;
  const row = document.getElementById('reservation-' + reservationId);

  if (confirm("Do you want to cancel the reservation?")) {
    fetch('cancel_reservation.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'reservation_id=' + reservationId
    })
    .then(response => response.json())
    .then(data => {

      if (data.success) 
      {
        location.reload();
      } 
    })
  }
}  

//Ελέγχει η ημερομηνία αναχώρησης να είναι μετά την τωρινή
function CheckDate() {
  const date = document.getElementById("date").value;
  console.log(date);
  let today = new Date();

  if (date < today.toISOString().split('T')[0])
  {
    alert("Please put a valid date");
  }
}