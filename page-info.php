<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">


  <title>user about me section - Bootdey.com</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="header-footer2.css">
  <style type="text/css">
    body {
      margin-top: 20px;
    }

    .card-style1 {
      box-shadow: 0px 0px 10px 0px rgb(89 75 128 / 9%);
    }

    .border-0 {
      border: 0 !important;
    }

    .card {
      position: relative;
      display: flex;
      flex-direction: column;
      min-width: 0;
      word-wrap: break-word;
      background-color: #fff;
      background-clip: border-box;
      border: 1px solid rgba(0, 0, 0, .125);
      border-radius: 0.25rem;
    }

    section {
      padding: 120px 0;
      overflow: hidden;
      background: #fff;
    }

    .mb-2-3,
    .my-2-3 {
      margin-bottom: 2.3rem;
    }

    .section-title {
      font-weight: 600;
      letter-spacing: 2px;
      text-transform: uppercase;
      margin-bottom: 10px;
      position: relative;
      display: inline-block;
    }

    .text-primary {
      color: #ceaa4d !important;
    }

    .text-secondary {
      color: #15395A !important;
    }

    .font-weight-600 {
      font-weight: 600;
    }

    .display-26 {
      font-size: 1.3rem;
    }

    @media screen and (min-width: 992px) {
      .p-lg-7 {
        padding: 4rem;
      }
    }

    @media screen and (min-width: 768px) {
      .p-md-6 {
        padding: 3.5rem;
      }
    }

    @media screen and (min-width: 576px) {
      .p-sm-2-3 {
        padding: 2.3rem;
      }
    }

    .p-1-9 {
      padding: 1.9rem;
    }

    .bg-secondary {
      background: #15395A !important;
    }

    @media screen and (min-width: 576px) {

      .pe-sm-6,
      .px-sm-6 {
        padding-right: 3.5rem;
      }
    }

    @media screen and (min-width: 576px) {

      .ps-sm-6,
      .px-sm-6 {
        padding-left: 3.5rem;
      }
    }

    .pe-1-9,
    .px-1-9 {
      padding-right: 1.9rem;
    }

    .ps-1-9,
    .px-1-9 {
      padding-left: 1.9rem;
    }

    .pb-1-9,
    .py-1-9 {
      padding-bottom: 1.9rem;
    }

    .pt-1-9,
    .py-1-9 {
      padding-top: 1.9rem;
    }

    .mb-1-9,
    .my-1-9 {
      margin-bottom: 1.9rem;
    }

    @media (min-width: 992px) {
      .d-lg-inline-block {
        display: inline-block !important;
      }
    }

    .rounded {
      border-radius: 0.25rem !important;
      width: 20rem;
    }
  </style>
</head>

<body>
  <header>
    <?php

    include('HF/Header2.php');
    include('DataBase.php');
    ?>
  </header>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitLiv'])) {


    $id_livre = mysqli_real_escape_string($conn, $_POST['id-livre']);


    $sql = "SELECT * FROM livres WHERE Numero = $id_livre ";

    $result = mysqli_query($conn, $sql);

    $ligne = mysqli_fetch_assoc($result);

    $sqlaut = "SELECT auteurs.Nom FROM auteurs JOIN livres ON auteurs.Id = livres.Auteur_Id WHERE livres.Numero = $id_livre ";
    $resultaut =  mysqli_query($conn, $sqlaut);
    $ligneaut = mysqli_fetch_assoc($resultaut);
  }

  ?>
  <section class="bg-light">
    <div class="container">
      <?php if ($result && mysqli_num_rows($result) > 0) { ?>
        <div class="row">
          <div class="col-lg-12 mb-4 mb-sm-5">
            <div class="card card-style1 border-0">
              <div class="card-body p-1-9 p-sm-2-3 p-md-6 p-lg-7">
                <div class="row align-items-center">
                  <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($ligne['Image']); ?>">
                  </div>
                  <div class="col-lg-6 px-xl-10">
                    <div class="bg-secondary d-lg-inline-block py-1-9 px-1-9 px-sm-6 mb-1-9 rounded">

                      <?php if ($result && mysqli_num_rows($resultaut) > 0) {
                        $Auteur = $ligneaut['Nom']; ?>
                        <label for="nomauteur"><b>Nom d'auteur:</b></label>
                        <h3 class="h2 text-white mb-0"><?php echo $Auteur; ?> </h3>
                      <?php } ?>
                      <span class="text-primary">Auteur</span>
                    </div>
                    <ul class="list-unstyled mb-1-9">
                      <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Nom du livre:</span><?php echo $ligne['Titre']; ?></li>
                      <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Etat:</span> Disponible</li>
                      <li class="mb-2 mb-xl-3 display-28"><span class="display-26 text-secondary me-2 font-weight-600">Categorie</span> <?php echo $ligne['Titre']; ?></li>

                      <form action="Empr.php" method="post">

                        <input type="hidden" name="titredelivre" value="<?php echo $ligne['Titre']; ?>">
                        <input type="hidden" name="numerodelivre" value="<?php echo $ligne['Numero']; ?>">

                        <input class="button" id="submit" type="submit" value="Emprunter" name="submit">

                      </form>
                    </ul>
                  <?php } ?>
                  <ul class="social-icon-style1 list-unstyled mb-0 ps-0">
                    <li><a href="#!"><i class="ti-twitter-alt"></i></a></li>
                    <li><a href="#!"><i class="ti-facebook"></i></a></li>
                    <li><a href="#!"><i class="ti-pinterest"></i></a></li>
                    <li><a href="#!"><i class="ti-instagram"></i></a></li>
                  </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12 mb-4 mb-sm-5">
            <div>
              <span class="section-title text-primary mb-3 mb-sm-4">Resume</span>
              <p>Edith is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
              <p class="mb-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed.</p>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-12 mb-4 mb-sm-5">
                <div class="mb-4 mb-sm-5">
                  <span class="section-title text-primary mb-3 mb-sm-4">Skill</span>
                  <div class="progress-text">
                    <div class="row">
                      <div class="col-6">Driving range</div>
                      <div class="col-6 text-end">80%</div>
                    </div>
                  </div>
                  <div class="custom-progress progress progress-medium mb-3" style="height: 4px;">
                    <div class="animated custom-bar progress-bar slideInLeft bg-secondary" style="width:80%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" role="progressbar"></div>
                  </div>
                  <div class="progress-text">
                    <div class="row">
                      <div class="col-6">Short Game</div>
                      <div class="col-6 text-end">90%</div>
                    </div>
                  </div>
                  <div class="custom-progress progress progress-medium mb-3" style="height: 4px;">
                    <div class="animated custom-bar progress-bar slideInLeft bg-secondary" style="width:90%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" role="progressbar"></div>
                  </div>
                  <div class="progress-text">
                    <div class="row">
                      <div class="col-6">Side Bets</div>
                      <div class="col-6 text-end">50%</div>
                    </div>
                  </div>
                  <div class="custom-progress progress progress-medium mb-3" style="height: 4px;">
                    <div class="animated custom-bar progress-bar slideInLeft bg-secondary" style="width:50%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" role="progressbar"></div>
                  </div>
                  <div class="progress-text">
                    <div class="row">
                      <div class="col-6">Putting</div>
                      <div class="col-6 text-end">60%</div>
                    </div>
                  </div>
                  <div class="custom-progress progress progress-medium" style="height: 4px;">
                    <div class="animated custom-bar progress-bar slideInLeft bg-secondary" style="width:60%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" role="progressbar"></div>
                  </div>
                </div>
                <div>
                  <span class="section-title text-primary mb-3 mb-sm-4">Education</span>
                  <p>Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p>
                  <p class="mb-1-9">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </section>
  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript">

  </script>
</body>

</html>