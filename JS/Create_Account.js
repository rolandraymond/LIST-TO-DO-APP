function CheckFormMethod(event) {
  event.preventDefault();
  const form = document.forms['Form'];
  const User_Name = form['User_Name'].value;
  const password = form['password'].value;
  const repassword = form['repassword'].value;
  const errorMsg = document.getElementById('error-msg');

  errorMsg.innerHTML = '';

  if (!User_Name) {
    errorMsg.innerHTML = 'User_name is required';

    return false;
  }
  if (password.length < 6) {
    errorMsg.innerHTML = 'password must be at least 6 characters';

    return false;
  }
  if (repassword !== password) {
    errorMsg.innerHTML = 'the password not match ';
    return false;
  }
  const formData = new FormData(form);

  fetch('handlers.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      console.log('Server response:', data);
      if (data.includes('Account created successfully!')) {
        errorMsg.innerHTML = 'Account created successfully!';
        location.href = 'index.html';
      } else {
        errorMsg.innerHTML = data;
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      errorMsg.innerHTML = error('Error,error');
    });
}
