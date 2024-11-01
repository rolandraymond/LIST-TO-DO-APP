function log_in(event) {
  event.preventDefault(); // Prevent form from submitting normally

  const form = document.forms['form'];
  const User_Name = form['User_Name'].value;
  const password = form['password'].value;
  const errorMsg = document.getElementById('error-msg');

  errorMsg.innerHTML = ''; // Clear previous messages

  if (!User_Name || !password) {
    errorMsg.innerHTML = 'Username and password are required.';
    return false;
  }

  const formData = new FormData();
  formData.append('User_Name', User_Name);
  formData.append('password', password);

  formData.forEach((value, key) => {
    console.log(`${key}:${value}`);
  });

  fetch('checkpass.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      console.log('Server response:', data); // Log server response
      if (data.includes('Login successful')) {
        window.location.href = 'tasks.php'; // Redirect if login is successful
      } else {
        errorMsg.innerHTML = data; // Show error message from the server
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      // errorMsg.innerHTML = error('Error,error');
    });
}
