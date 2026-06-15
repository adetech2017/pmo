<?php
/**
 * Contact Page - Professional Government Contact Experience
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">

  <!-- Hero Section -->
  <section class="contact-hero">
    <div class="contact-hero-bg"></div>
    <div class="container" style="position: relative; z-index: 2;">
      <h1>Contact Us</h1>
      <p>Get in touch with the Lagos State Parastatals Monitoring Office</p>
    </div>
  </section>

  <!-- Main Contact Section -->
  <section class="section">
    <div class="container">
      <div class="contact-grid">
        <!-- Contact Form -->
        <div class="contact-form-card">
          <h3>Send us a Message</h3>
          <form method="post" class="contact-form">
            <div class="form-group">
              <label for="name">Full Name *</label>
              <input type="text" id="name" name="name" required placeholder="Your full name">
            </div>

            <div class="form-group">
              <label for="email">Email Address *</label>
              <input type="email" id="email" name="email" required placeholder="your.email@example.com">
            </div>

            <div class="form-group">
              <label for="subject">Subject *</label>
              <input type="text" id="subject" name="subject" required placeholder="What is this about?">
            </div>

            <div class="form-group">
              <label for="message">Message *</label>
              <textarea id="message" name="message" required rows="5" placeholder="Your message here..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Send Message</button>
          </form>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
          <div class="contact-card">
            <div class="contact-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <h4>Physical Address</h4>
            <p>Block 1 Secretariat<br>Alausa, Ikeja<br>Lagos State, Nigeria</p>
          </div>

          <div class="contact-card">
            <div class="contact-icon">
              <i class="fas fa-phone"></i>
            </div>
            <h4>Telephone</h4>
            <p>+234 (0) 1 XXX XXXX<br><span class="contact-hours">Mon - Fri: 9:00 AM - 5:00 PM</span></p>
          </div>

          <div class="contact-card">
            <div class="contact-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <h4>Email</h4>
            <p><a href="mailto:info@pmo.lagosstate.gov.ng">info@pmo.lagosstate.gov.ng</a><br><span class="contact-hours">We'll respond within 24 hours</span></p>
          </div>

          <div class="contact-card emergency">
            <div class="contact-icon">
              <i class="fas fa-exclamation-circle"></i>
            </div>
            <h4>Emergency Contact</h4>
            <p>For urgent matters:<br><a href="tel:+2341xxxxxxxxx">+234 (0) 1 XXX XXXX</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Department Directory -->
  <section class="section contact-departments">
    <div class="container">
      <div class="section-header">
        <h2>Department Directory</h2>
        <p>Reach out to specific departments</p>
      </div>

      <div class="departments-list">
        <div class="department-item">
          <div class="department-content">
            <h5>Monitoring & Evaluation</h5>
            <p>Performance audits and institutional assessments</p>
          </div>
          <a href="mailto:me@pmo.lagosstate.gov.ng" class="department-link">
            <span>Contact</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>

        <div class="department-item">
          <div class="department-content">
            <h5>Research & Policy</h5>
            <p>Strategic research and policy development</p>
          </div>
          <a href="mailto:research@pmo.lagosstate.gov.ng" class="department-link">
            <span>Contact</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>

        <div class="department-item">
          <div class="department-content">
            <h5>Capacity Building</h5>
            <p>Training and institutional development</p>
          </div>
          <a href="mailto:training@pmo.lagosstate.gov.ng" class="department-link">
            <span>Contact</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
