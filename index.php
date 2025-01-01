<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="icon" href="gambar/download.jpg" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">Meng</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#article">Article </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#gallery">Gallery </a>
            </li>
            <li class="nav-item">
              <a class="btn btn-primary" href="Login.php" role="button">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <section id="hero" class="text-center text-sm-start p-5 bg-danger-subtle">
      <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
          <img src="gambar/kucing2.jpg" class="img-fluid" width="700" alt="" />
          <div>
            <h1 class="fw-bold display-4">Kucing</h1>
            <h4 class="lead display-6 p-5">
              Meow Meow Meow
            </h4>
          </div>
        </div>
      </div>
    </section>
    <section container id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Article</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
          <div class="col">
            <div class="card h-100">
              <img src="gambar/kucing.jpeg" class="card-img-top" alt="..." />
              <div class="card-body">
                <h5 class="card-title">Kucing</h5>
                <p class="card-text">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum ad sed deserunt, officiis earum fugit sunt doloribus impedit error facere.
                </p>
              </div>
              <div class="card-footer">
                <small class="text-body-secondary">Last updated 3 mins ago</small>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <img src="gambar/kucing3.jpg" class="card-img-top" alt="..." />
              <div class="card-body">
                <h5 class="card-title">Kucing</h5>
                <p class="card-text">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia minus impedit asperiores ullam maiores aspernatur obcaecati laudantium explicabo. Iste, laborum.
                </p>
              </div>
              <div class="card-footer">
                <small class="text-body-secondary">Last updated 3 mins ago</small>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <img src="gambar/kucing4.jpg" class="card-img-top" alt="..." />
              <div class="card-body">
                <h5 class="card-title">Kucing</h5>
                <p class="card-text">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi ipsum numquam ratione laboriosam tenetur autem reiciendis. Fugiat ducimus adipisci minus.
                </p>
              </div>
              <div class="card-footer">
                <small class="text-body-secondary">Last updated 3 mins ago</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="gallery" class="text-center p-5 bg-danger-subtle">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Gallery</h1>
        <img src="gambar/kucing.jpeg" alt="">
      </div>
    </section>
    <footer class="text-center">
      <div >
        <a href="https://www.instagram.com/"><i class="bi bi-instagram h2 p-2 text-dark"></i></a>
        <a href="https://facebook.com/"><i class="bi bi-facebook h2 p-2 text-dark"></i></a>
        <a href="https://web.whatsapp.com/"><i class="bi bi-whatsapp h2 p-2 text-dark"></i></a>
      </div>
      <div >Pramudya Putra Pratama</div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
  <style></style>
</html>
