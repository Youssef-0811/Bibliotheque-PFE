<footer class="footer">
    <div class="containerF">
      <div class="footer-brand">
        <a class="brand" href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="Footericon">
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"></path>
          </svg>
          <span class="brand-name">Bibliotheque</span>
        </a>
        <p class="footer-text">Discover the world of knowledge at our library. Explore our vast collection of books, journals, and digital resources.</p>
      </div>
      <div class="footer-links">
        <div class="footer-section">
          <h4 class="footer-title">Quick Links</h4>
          <nav class="footer-nav">
            <a class="footer-nav-link" href="#">About</a>
            <a class="footer-nav-link" href="#">Contact</a>
            <a class="footer-nav-link" href="#">Privacy Policy</a>
          </nav>
        </div>
        <div class="footer-section">
          <h4 class="footer-title">Resources</h4>
          <nav class="footer-nav">
            <a class="footer-nav-link" href="#">Catalog</a>
            <a class="footer-nav-link" href="#">Events</a>
            <a class="footer-nav-link" href="#">Services</a>
          </nav>
        </div>
      </div>
      <div class="footer-contact">
        <h4 class="footer-title">Contact</h4>
        <p class="footer-text">123 Main Street, Anytown USA<br>Phone: (123) 456-7890</p>
      </div>
    </div>
  </footer>
  <style>





.brand {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: white;
}

.Footericon {
  width: 32px;
  height: 32px;
  color: #ecc94b;
}

.brand-name {
  font-size: 1.5rem;
  font-weight: bold;
  margin-left: 0.5rem;
}



.footer {
  background-color: #1a202c;
  padding: 3rem;
}

.footer .containerF {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: 2rem;
}

.footer-brand,
.footer-links,
.footer-contact {
  display: flex;
  flex-direction: column;
}

.footer-brand .brand {
  margin-bottom: 1rem;
}

.footer-text {
  color: #a0aec0;
  font-size: 0.875rem;
}

.footer-title {
  font-size: 1.125rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: white;
}

.footer-nav {
  display: flex;
  flex-direction: column;
}

.footer-nav-link {
  color: #a0aec0;
  font-size: 0.875rem;
  text-decoration: none;
  margin-bottom: 0.25rem;
  transition: color 0.3s;
}

.footer-nav-link:hover {
  color: #ecc94b;
}

@media (min-width: 768px) {
  .nav {
    display: flex;
  }

  .footer .containerF {
    grid-template-columns: repeat(3, 1fr);
  }
}



  </style>
