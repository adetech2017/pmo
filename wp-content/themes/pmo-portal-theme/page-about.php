<?php
/**
 * About Us Page - Premium Government Design
 *
 * @package PMO_Portal_Theme
 */

get_header();
?>

<main id="main-content" class="site-content">

  <!-- Hero Section -->
  <section class="section about-hero">
    <div class="container">
      <h1>About the Parastatals Monitoring Office</h1>
      <p>Institutional overview, mandate, and strategic direction</p>
    </div>
  </section>

  <!-- Who We Are & Strategic Focus Section -->
  <section class="section who-strategic-section">
    <div class="container">
      <div class="who-we-are-grid">
        <!-- Who We Are Column -->
        <div class="who-we-are-card">
          <div class="card-ornament card-ornament-top-left"></div>
          <div class="card-ornament card-ornament-bottom-right"></div>

          <div class="card-content">
            <div class="section-badge">About Us</div>
            <h2>Who We Are</h2>
            <p>The Lagos State Parastatals Monitoring Office (PMO) is a critical government agency dedicated to ensuring that state-owned enterprises and parastatals operate efficiently, transparently, and in accordance with established guidelines.</p>

            <p>Led by the Special Adviser to the Governor on Parastatals Monitoring, the PMO drives the T.H.E.M.E.S+ agenda through rigorous performance audits, comprehensive inspections, and promotion of good governance practices.</p>

            <p>Our approach focuses on sustainable development and reducing dependency on government funding while maximizing public value delivery.</p>
          </div>
        </div>

        <!-- Strategic Focus Column -->
        <div class="strategic-focus-card">
          <div class="card-ornament card-ornament-top-right"></div>
          <div class="card-ornament card-ornament-bottom-left"></div>

          <div class="card-content">
            <div class="section-badge">Our Mission</div>
            <h3>Our Strategic Focus</h3>

            <ul class="strategic-focus-list">
              <li>
                <span class="focus-icon"><i class="fas fa-crosshairs"></i></span>
                <span class="focus-text">Strategic monitoring of state enterprises</span>
              </li>
              <li>
                <span class="focus-icon"><i class="fas fa-chart-line"></i></span>
                <span class="focus-text">Performance evaluation and optimization</span>
              </li>
              <li>
                <span class="focus-icon"><i class="fas fa-balance-scale"></i></span>
                <span class="focus-text">Corporate governance enhancement</span>
              </li>
              <li>
                <span class="focus-icon"><i class="fas fa-coins"></i></span>
                <span class="focus-text">Financial sustainability improvement</span>
              </li>
              <li>
                <span class="focus-icon"><i class="fas fa-graduation-cap"></i></span>
                <span class="focus-text">Capacity building and training</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== THEMES+ AGENDA ========== -->
  <section class="section" style="background: var(--color-gray-50);">
    <div class="container">
      <div class="section-header">
        <h2>The THEMES+ Agenda</h2>
        <p>The strategic roadmap for the "Greater Lagos" vision</p>
      </div>

      <div style="max-width: 800px; margin: 0 auto var(--space-12) auto; text-align: center;">
        <p style="font-size: var(--font-size-body-lg); color: var(--color-gray-700); line-height: var(--line-height-relaxed);">
          The Lagos State Government operates under the THEMES+ Agenda, which is the strategic roadmap for the "Greater Lagos" vision. This agenda is designed to ensure sustainable development and improve the quality of life for all residents.
        </p>
      </div>

      <div class="themes-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 320px), 1fr)); gap: var(--space-6);">
        <div class="themes-card">
          <div class="themes-letter">T</div>
          <h3>Traffic Management and Transportation</h3>
          <p>Enhancing mobility through the expansion of the rail network (Blue and Red Lines), water transportation, and road infrastructure.</p>
        </div>

        <div class="themes-card">
          <div class="themes-letter">H</div>
          <h3>Health and Environment</h3>
          <p>Improving healthcare delivery through the ILERA EKO health insurance scheme and maintaining a cleaner environment through the Lagos State Waste Management Authority (LAWMA).</p>
        </div>

        <div class="themes-card">
          <div class="themes-letter">E</div>
          <h3>Education and Technology</h3>
          <p>Investing in digital literacy, STEM education, and fostering innovation through the Ministry of Innovation, Science and Technology (MIST).</p>
        </div>

        <div class="themes-card">
          <div class="themes-letter">M</div>
          <h3>Making Lagos a 21st Century Economy</h3>
          <p>Focusing on ease of doing business, tax administration via LIRS, and startup support through LASRIC and LSETF.</p>
        </div>

        <div class="themes-card">
          <div class="themes-letter">E</div>
          <h3>Entertainment and Tourism</h3>
          <p>Promoting the creative industry and cultural heritage as key economic drivers.</p>
        </div>

        <div class="themes-card">
          <div class="themes-letter">S</div>
          <h3>Security and Governance</h3>
          <p>Ensuring the safety of lives and property while maintaining transparent and efficient public service delivery.</p>
        </div>

        <div class="themes-card themes-plus">
          <div class="themes-letter">+</div>
          <h3>The Plus</h3>
          <p>Represents the cross-cutting themes of Social Inclusion, Gender Equality, and Youth Empowerment, ensuring no resident is left behind in the development process.</p>
        </div>
      </div>
    </div>

    <style>
      .themes-card {
        padding: var(--space-8);
        background: var(--color-white);
        border: 1px solid var(--color-gray-100);
        border-left: 5px solid var(--color-primary);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        transition: all var(--transition-base);
      }

      .themes-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-6px);
      }

      .themes-card.themes-plus {
        border-left-color: var(--color-accent-dark);
      }

      .themes-letter {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-primary);
        color: var(--color-white);
        font-size: 1.75rem;
        font-weight: 800;
        border-radius: var(--radius-md);
        margin-bottom: var(--space-4);
      }

      .themes-plus .themes-letter {
        background: var(--color-accent);
      }

      .themes-card h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--color-primary-700);
        margin-bottom: var(--space-3);
        line-height: 1.4;
      }

      .themes-card p {
        color: var(--color-gray-600);
        font-size: var(--font-size-small);
        line-height: var(--line-height-relaxed);
        margin: 0;
      }
    </style>
  </section>

  <!-- Core Values Grid -->
  <section class="section core-values-section">
    <div class="container">
      <div class="core-values-header">
        <h2>Core Values</h2>
        <p>The principles guiding our institutional excellence</p>
      </div>

      <div class="grid grid-3 core-values-grid">
        <div class="core-value-gradient-card transparency-card">
          <div class="card-ornament card-ornament-top-left"></div>
          <div class="card-ornament card-ornament-bottom-right"></div>

          <div class="value-badge">Value 01</div>
          <div class="core-value-icon">
            <i class="fas fa-eye"></i>
          </div>
          <h4>Transparency</h4>
          <p>Open, honest, and accountable operations in all our activities and reporting.</p>
        </div>

        <div class="core-value-gradient-card excellence-card">
          <div class="card-ornament card-ornament-top-right"></div>
          <div class="card-ornament card-ornament-bottom-left"></div>

          <div class="value-badge">Value 02</div>
          <div class="core-value-icon">
            <i class="fas fa-star"></i>
          </div>
          <h4>Excellence</h4>
          <p>Commitment to highest standards of professionalism and institutional quality.</p>
        </div>

        <div class="core-value-gradient-card collaboration-card">
          <div class="card-ornament card-ornament-top-left"></div>
          <div class="card-ornament card-ornament-bottom-right"></div>

          <div class="value-badge">Value 03</div>
          <div class="core-value-icon">
            <i class="fas fa-handshake"></i>
          </div>
          <h4>Collaboration</h4>
          <p>Partnership with stakeholders to achieve shared governance objectives.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Strategic Objectives -->
  <section class="section">
    <div class="container" style="max-width: 900px;">
      <div class="objectives-header">
        <h2>Strategic Objectives</h2>
        <p>How we drive institutional performance and excellence</p>
      </div>

      <div class="objectives-grid">
        <div class="objective-card primary">
          <h4>Performance Monitoring</h4>
          <p>Conduct regular audits and evaluations of parastatal operations and financial management.</p>
        </div>

        <div class="objective-card accent">
          <h4>Capacity Development</h4>
          <p>Provide training and guidance to improve management and operational standards.</p>
        </div>

        <div class="objective-card success">
          <h4>Best Practice Implementation</h4>
          <p>Promote adoption of international standards and governance best practices.</p>
        </div>

        <div class="objective-card info">
          <h4>Public Engagement</h4>
          <p>Ensure transparency and accountability through public reporting and stakeholder engagement.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="section about-cta-section">
    <div class="container">
      <div class="about-cta-content">
        <h2>Learn More About Our Work</h2>
        <p>Explore our programmes, meet the directorate, and discover how PMO drives excellence.</p>
        <div class="about-cta-buttons">
          <a href="/pmo/the-directorate/" class="btn btn-light">Meet The Directorate</a>
          <a href="/pmo/programmes/" class="btn btn-outline" style="border-color: var(--color-white); color: var(--color-white);">View Programmes</a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
