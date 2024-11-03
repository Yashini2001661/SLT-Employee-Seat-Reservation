<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Employee Seat Reservation System</title>
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">

  </head>
  <body>
    <header>
    <div class="navbar">
        <ul>
          <li><a href='/homeRoute'>Home</a></li>
          <li><a href="#footer">About</a></li>
          <li><a href="#footer">Contact</a></li>
        </ul>
    </div>
    </header>

    <main class="hero-section">
      <div class="hero-content">
        <h1>Welcome to the Employee Seat Reservation System</h1>
        <p>Reserve your seat at the office efficiently and easily.</p>
        <form action="{{ route('login.view') }}" method="GET">
          <button type="submit" class="btn btn-lg btn-primary w-100 fs-6 custom-button">Get Started</button>
        </form>
      </div>
    </main>

    <footer id="footer" class="footer">
      <div class="footer-container">
        <div class="contact-details">
          <h3>Contact us</h3>
          <p>support@slt.lk | +94 11 2 123456</p>
        </div>

        <div class="social-media">
          <div class="contact-details">
            <h3>Follow us</h3>
          <a
            href="https://www.facebook.com/slt"
            target="_blank"
            aria-label="Facebook"
          >
          <img src="{{ asset('assets/images/facebook-icon.png') }}" alt="Facebook" />
          </a>
          <a
            href="https://www.twitter.com/slt"
            target="_blank"
            aria-label="Twitter"
          >
          <img src="{{ asset('assets/images/twitter-icon.png') }}" alt="Twitter" />
          </a>
          <a
            href="https://www.instagram.com/slt"
            target="_blank"
            aria-label="Instagram"
          >
          <img src="{{ asset('assets/images/instagram-icon.png') }}" alt="Instagram" />
          </a>
          <a
            href="https://www.youtube.com/slt"
            target="_blank"
            aria-label="YouTube"
          >
          <img src="{{ asset('assets/images/youtube-icon.png') }}" alt="You Tube" />
          </a>
        </div>
      </div>

      <div class="footer-content">
        <p>
          &copy; 2024 SLT Employee Seat Reservation System. All rights reserved.
        </p>
      </div>
    </footer>
  </body>
</html>
