<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="images/main.jpg" type="image/x-icon" />
  <title>Healthcare</title>
  <link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="100">
  <!-- Top Navbar -->

  <div class="top-nav d-none d-md-block">
    <div class="container">
      <div class="contact">
        <div class="mail d-flex align-items-center">
          <i class="ri-mail-line"></i>
          <a href="mailto:healthcare@email.com">healthcare@email.com</a>
        </div>
        <div class="loc d-flex">
          <i class="ri-map-pin-line"></i>
          <p>Find our Location</p>
        </div>
      </div>
      <div class="icons">
        <a href="#"><i class="ri-facebook-fill"></i></a>
        <a href="#"><i class="ri-twitter-fill"></i></a>
        <a href="#"><i class="ri-linkedin-fill"></i></a>
      </div>
    </div>
  </div>

  <!-- Main Navbar -->

  <nav class="navbar navbar-expand-lg navigation-wrap">
    <div class="container">
      <a class="navbar-brand ms-3" href="#">
        <img src="images/logo.webp" alt="logo" class="img-fluid logo-img" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">HOME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="trends/index.php">HEALTH TRENDS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="userspage.php">LOGIN</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Section -->

  <div class="main-content d-flex align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
          <h1>
            Making Healthcare <br />
            Better Together
          </h1>
          <p>
            At HealthCare, we bridge the gap between patients, doctors, and administrators through a secure,
            intuitive,
            and modern platform. Whether you're booking appointments, managing health records, or accessing
            personalized
            care – everything you need is just a click away.
          </p>
          <div class="btns">
          <button class="btn1" onclick="location.href='#appointment'">Make An Appointment</button>
          <button class="btn2" onclick="location.href='#services'">View Services</button>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Information Section -->

  <section class="information">
    <div class="container">
      <div class="box">
        <div class="para">
          <i class="ri-mental-health-line"></i>
          <h4>Primary Care</h4>
        </div>
        <p>
          Comprehensive and continuous care for your everyday health needs, from routine checkups to chronic
          condition
          management.
        </p>
      </div>
      <div class="box">
        <div class="para">
          <i class="ri-heart-pulse-line"></i>
          <h4>Emergency Cases</h4>
        </div>
        <p>
          Rapid response and support for urgent medical conditions — our team is available around the clock
          when it
          matters most.
        </p>
      </div>
      <div class="box">
        <div class="para">
          <i class="ri-customer-service-2-fill"></i>
          <h4>Appointment</h4>
        </div>
        <p>
          Book consultations easily from the comfort of your home with our secure and seamless online
          appointment
          system.
        </p>
      </div>
    </div>
  </section>


  <!-- Health Services -->
  <section id="services" class="services py-5" style="background-color: #f9f9f9;">
    <div class="container">
      <div class="row mb-4">
        <div class="col-md-5">
          <h1 class="fw-bold" style="font-family: 'Segoe UI', sans-serif;">Services</h1>
        </div>
        <div class="col-md-7">
          <p style="color: #444;">
            Our comprehensive services cover every stage of care, from prevention and diagnostics to
            advanced
            treatments. We are committed to excellence and compassion in healthcare delivery.
          </p>
        </div>
      </div>

      <div class="row g-4">
        <!-- Neurology -->
        <div class="col-12 col-md-6 col-lg-4 d-flex">
          <div class="box bg-white p-4 rounded shadow-sm w-100 text-center">
            <div class="icon mb-3"><i class="ri-brain-line" style="font-size: 2rem; color: #007bff;"></i>
            </div>
            <h4 class="mb-2">Neurology</h4>
            <p>Expert diagnosis and treatment for brain, spine, and nervous system disorders with
              compassionate care.
            </p>
          </div>
        </div>

        <!-- Orthopedics -->
        <div class="col-12 col-md-6 col-lg-4 d-flex">
          <div class="box bg-white p-4 rounded shadow-sm w-100 text-center">
            <div class="icon mb-3"><i class="ri-walk-line" style="font-size: 2rem; color: #007bff;"></i>
            </div>
            <h4 class="mb-2">Orthopedics</h4>
            <p>Comprehensive care for bone, joint, and muscle conditions, from fractures to sports injuries.
            </p>
          </div>
        </div>

        <!-- Cardiology -->
        <div class="col-12 col-md-6 col-lg-4 d-flex">
          <div class="box bg-white p-4 rounded shadow-sm w-100 text-center">
            <div class="icon mb-3"><i class="ri-heart-pulse-line" style="font-size: 2rem; color: #007bff;"></i></div>
            <h4 class="mb-2">Cardiology</h4>
            <p>Advanced heart care including diagnostics, intervention, and long-term cardiac health
              management.</p>
          </div>
        </div>

        <!-- Pharma Pipeline -->
        <div class="col-12 col-md-6 col-lg-4 d-flex">
          <div class="box bg-white p-4 rounded shadow-sm w-100 text-center">
            <div class="icon mb-3"><i class="ri-flask-line" style="font-size: 2rem; color: #007bff;"></i>
            </div>
            <h4 class="mb-2">Pharma Pipeline</h4>
            <p>Research and development pipeline focused on cutting-edge treatments and innovative drug
              delivery.</p>
          </div>
        </div>

        <!-- Pharma Team -->
        <div class="col-12 col-md-6 col-lg-4 d-flex">
          <div class="box bg-white p-4 rounded shadow-sm w-100 text-center">
            <div class="icon mb-3"><i class="ri-team-line" style="font-size: 2rem; color: #007bff;"></i>
            </div>
            <h4 class="mb-2">Pharma Team</h4>
            <p>Experienced pharmaceutical experts driving precision medicine and regulatory excellence in
              drug
              development.</p>
          </div>
        </div>

        <!-- High-Quality Treatment -->
        <div class="col-12 col-md-6 col-lg-4 d-flex">
          <div class="box bg-white p-4 rounded shadow-sm w-100 text-center">
            <div class="icon mb-3"><i class="ri-hospital-line" style="font-size: 2rem; color: #007bff;"></i>
            </div>
            <h4 class="mb-2">High-Quality Treatment</h4>
            <p>Evidence-based, patient-centered care with advanced technology and expert clinical teams.</p>
          </div>
        </div>
      </div>
    </div>
  </section>




  <!-- FAQ + Appointment Section -->
  <section id="appointment" class="form py-5">
    <div class="container">
      <div class="row g-4">
        <!-- FAQ Column -->
        <div class="col-md-6">
          <div class="box">
            <h3>Have Some Questions?</h3>

            <div class="faq-item">
              <div class="faq-question">
                <p>What services can I book online?</p>
                <i class="ri-add-line"></i>
              </div>
              <div class="faq-answer">
                <p>You can book consultations, lab tests, vaccinations, and follow-up appointments
                  through our platform.</p>
              </div>
            </div>

            <div class="faq-item">
              <div class="faq-question">
                <p>Can I reschedule my appointment?</p>
                <i class="ri-add-line"></i>
              </div>
              <div class="faq-answer">
                <p>Yes, appointments can be rescheduled up to 24 hours in advance from your dashboard.
                </p>
              </div>
            </div>

            <div class="faq-item">
              <div class="faq-question">
                <p>Are online consultations secure?</p>
                <i class="ri-add-line"></i>
              </div>
              <div class="faq-answer">
                <p>Absolutely. All communication is encrypted and complies with HIPAA standards.</p>
              </div>
            </div>

            <div class="faq-item">
              <div class="faq-question">
                <p>How do I access my medical records?</p>
                <i class="ri-add-line"></i>
              </div>
              <div class="faq-answer">
                <p>Your records are available under the 'My Health' tab once you log in to your account.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Appointment Form Column -->
        <div class="col-md-6">
          <div class="box px-2">
            <h3>Make An Appointment</h3>
            <form>
              <label for="name">Full Name</label>
              <input type="text" id="name" placeholder="Your Name" class="form-control mb-3" />

              <label for="email">Email</label>
              <input type="email" id="email" placeholder="Your Email" class="form-control mb-3" />

              <label for="message">Message</label>
              <textarea id="message" placeholder="Message" class="form-control mb-3"></textarea>

              <button type="submit" class="btn btn-primary w-100">Make An Appointment</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Emergency Section -->

  <div class="emergency">
    <h4 style="font-family: static, 'Times New Roman'">Emergency hotline</h4>
    <h1> 1256 567 550</h1>
    <p>
      We provide 24/7 customer support. Please feel free to contact us <br />
      for emergency case.
    </p>
  </div>


  <!-- Footer -->

  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-lg-2 mt-5">
          <div class="foot">
            <h4>Top Medical Services</h4>
            <a href="#">General Consultation</a> <br />
            <a href="#">Health Checkups</a> <br />
            <a href="#">Specialist Appointments</a> <br />
            <a href="#">Emergency Care</a>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-2 mt-5">
          <div class="foot">
            <h4>Quick Links</h4>
            <a href="#">Jobs</a> <br />
            <a href="#">Brand Assets</a> <br />
            <a href="#">Investor Relations</a> <br />
            <a href="#">Terms of Service</a>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-2 mt-5">
          <div class="foot">
            <h4>Features</h4>
            <a href="#">Jobs</a> <br />
            <a href="#">Brand Assets</a> <br />
            <a href="#">Investor Relations</a> <br />
            <a href="#">Terms of Service</a>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-2 mt-5">
          <div class="foot">
            <h4>Resources</h4>
            <a href="#">Guides</a> <br />
            <a href="#">Research</a> <br />
            <a href="#">Experts</a> <br />
            <a href="#">Agencies</a>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-5">
          <div class="foot">
            <h4>Newsletter</h4>
            <a href="#">You can trust us. we only send promo offers,</a>
            <div class="inpu">
              <input type="text" placeholder="Your Email Address" />
              <a href="mailto:healthcare@email.com">
                <div class="but"><i class="ri-arrow-right-line"></i></div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="last-footer">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-6">
          <p>
            Copyright © 2025 All rights reserved
          </p>
        </div>
        <div class="col-12 col-md-6 right">
          <a href="#">
            <div class="icon"><i class="ri-facebook-fill"></i></div>
          </a>
          <a href="#">
            <div class="icon"><i class="ri-twitter-fill"></i></div>
          </a>
          <a href="#">
            <div class="icon"><i class="ri-global-line"></i></div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <script src="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
  document.querySelectorAll(".faq-question").forEach((item) => {
    item.addEventListener("click", () => {
      const parent = item.parentElement;
      parent.classList.toggle("active");
      const icon = item.querySelector("i");

      // Toggle between 'plus' and 'minus' using a single icon
      if (parent.classList.contains("active")) {
        icon.classList.remove("ri-add-line");
        icon.classList.add("ri-remove-line"); // Using remove-line for the minus icon
      } else {
        icon.classList.remove("ri-remove-line");
        icon.classList.add("ri-add-line"); // Revert back to plus sign
      }
    });
  });
</script>


</html>