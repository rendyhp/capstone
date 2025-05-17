@extends('layouts.header')
@section('container')
@section('title', 'Home | Bdim’s Stock')

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
    <div class="row">
      <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
      <h1 data-aos="fade-up">BdiM's Stock</h1>
      <h2 data-aos="fade-up" data-aos-delay="400">BdiM’s Stock adalah aplikasi monitoring stok
        untuk memantau Stok Barang dan Bahan di Kafe BdiM.</h2>
      <div data-aos="fade-up" data-aos-delay="800">
        <ul class="btn-get-started scrollto">
        @auth
      <form action="/logout" method="post">
        @csrf
        <button class="btn btn-dark" type="submit"><i class="fas fa-sign-out-alt"></i>
        Logout</button>
      </form>
      @else
      <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i>Login</a>
      @endauth
        </ul>
      </div>
      </div>
      <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left" data-aos-delay="200">
      <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
      </div>
    </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
      <h2>About Us</h2>
      </div>

      <div class="row content">
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="150">
        <p>
        Manfaat monitoring stok:
        </p>
        <ul>
        <li><i class="ri-check-double-line"></i> Akurasi Persediaan</li>
        <li><i class="ri-check-double-line"></i> Deteksi Kehilangan Barang</li>
        <li><i class="ri-check-double-line"></i> Perencanaan dan Pengelolaan Persediaan yang Lebih Baik</li>
        </ul>
      </div>
      <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-up" data-aos-delay="300">
        <p>
        BdiM’s Stock bertujuan untuk membandingkan jumlah fisik bahan dengan catatan pada aplikasi.
        </p>
        <!-- <a href="#" class="btn-learn-more">Learn More</a> -->
      </div>
      </div>

    </div>
    </section><!-- End About Us Section -->
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
    class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  </body>

  </html>
@endsection