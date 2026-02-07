<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background-color: #f9f9f9;
      color: #333;
      margin: 0;
      padding: 0;
    }
    .contact-container {
      width: 90%;
      max-width: 600px;
      margin: 60px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: #633fe4;
    }
    label {
      font-weight: 600;
      margin-top: 10px;
      display: block;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
    }
    input:invalid, textarea:invalid {
      border-color: red;
    }
    input:valid, textarea:valid {
      border-color: #633fe4;
    }
    button {
      background-color: #633fe4;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 6px;
      margin-top: 15px;
      cursor: pointer;
      width: 100%;
      transition: 0.3s;
    }
    button:hover {
      background-color: #4b29c4;
    }
    footer {
      text-align: center;
      margin-top: 40px;
      padding-top: 15px;
      font-size: 14px;
      color: #555;
      border-top: 1px solid #ddd;
    }
    footer a {
      color: #633fe4;
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
    }
    footer a:hover {
      text-decoration: underline;
    }
    .error {
      color: red;
      font-size: 14px;
      margin-top: 3px;
    }

    /* Modal styling */
    .modal {
      display: none;
      position: fixed;
      z-index: 10;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-content {
      background: white;
      margin: 15% auto;
      padding: 25px;
      border-radius: 10px;
      width: 90%;
      max-width: 400px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .modal-content h2 {
      color: #633fe4;
      margin-bottom: 10px;
    }
    .modal-content p {
      color: #555;
      font-size: 15px;
    }
    .modal-buttons {
      margin-top: 20px;
      display: flex;
      justify-content: space-around;
    }
    .modal-buttons button {
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 15px;
      transition: 0.3s;
    }
    .btn-open {
      background-color: #633fe4;
      color: white;
    }
    .btn-open:hover {
      background-color: #4b29c4;
    }
    .btn-cancel {
      background-color: #ccc;
      color: black;
    }
    .btn-cancel:hover {
      background-color: #aaa;
    }
  </style>
</head>
<body>
  <div class="contact-container">
    <h1>Contact Us</h1>
    <form id="contactForm" action="contact.html" method="POST" class="contact-form" novalidate>
      <label for="name">Name :</label>
      <input type="text" name="name" id="name" required />
      <div id="nameError" class="error"></div>

      <label for="email">Email :</label>
      <input type="email" name="email" id="email" required />
      <div id="emailError" class="error"></div>

      <label for="subject">Subject :</label>
      <input type="text" name="subject" id="subject" required />
      <div id="subjectError" class="error"></div>

      <label for="message">Message :</label>
      <textarea name="message" id="message" rows="5" required></textarea>
      <div id="messageError" class="error"></div>

      <button type="submit">Send Message</button>
    </form>

    <footer>
      <p>📧 Contact us :
        <a href="blog-info.html">khyasii1208@gmail.com</a>
      </p>
      <p>🏠 Address : Our Banglows, Near The Straight Society, Rajkot - 360006</p>
    </footer>
  </div>

  
  <script>
    // Form validation logic
    document.getElementById('contactForm').addEventListener('submit', function(event) {
      let isValid = true;
      document.querySelectorAll('.error').forEach(e => e.textContent = '');
      const name = document.getElementById('name').value.trim();
      if (!/^[A-Za-z\s]+$/.test(name) || name.length < 2) {
        document.getElementById('nameError').textContent = "Please enter a valid name (letters only).";
        isValid = false;
      }
      const email = document.getElementById('email').value.trim();
      const gmailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
      if (!gmailPattern.test(email)) {
        document.getElementById('emailError').textContent = "Please enter a valid Gmail address (example@gmail.com).";
        isValid = false;
      }
      const subject = document.getElementById('subject').value.trim();
      if (subject.length < 8) {
        document.getElementById('subjectError').textContent = "Subject must be at least 8 characters.";
        isValid = false;
      }
      const message = document.getElementById('message').value.trim();
      if (message.length < 10) {
        document.getElementById('messageError').textContent = "Message must be at least 10 characters.";
        isValid = false;
      }
      if (!isValid) event.preventDefault();
    });

     </script>
</body>
</html>
