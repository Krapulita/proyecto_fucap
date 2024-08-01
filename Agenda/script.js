const form = document.getElementById('reservation-form');

form.addEventListener('submit', (e) => {
  e.preventDefault();

  const service = document.getElementById('service');
  const date = document.getElementById('date');
  const time = document.getElementById('time');
  const name = document.getElementById('name');
  const email = document.getElementById('email');
  const phone = document.getElementById('phone');

  // Validate form fields
  if (service.value === '') {
    alert('Por favor seleccione un servicio.');
    return;
  }

  if (date.value === '') {
    alert('Por favor seleccione una fecha.');
    return;
  }

  if (time.value === '') {
    alert('Por favor seleccione una hora.');
    return;
  }

  if (name.value === '') {
    alert('Por favor ingrese su nombre.');
    return;
  }

  if (email.value === '') {
    alert('Por favor ingrese su correo electrónico.');
    return;
  }

  if (!validateEmail(email.value)) {
    alert('Por favor ingrese un correo electrónico válido.');
    return;
  }

  if (phone.value === '') {
    alert('Por favor ingrese su teléfono.');
    return;
  }

  // If everything is valid, submit the form
  form.submit();
});

function validateEmail(email) {
  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}