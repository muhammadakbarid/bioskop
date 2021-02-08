<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bioskop Online</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('frontend'); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('penjualan'); ?>">Penjualan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('cart/keranjang'); ?>">Keranjang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Admin</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <br>
        <br><br><br>
        <div>
            <center>
                <h2>TIKET VIP</h2>
            </center>
            <div class="row">

                <?php foreach ($vip as $k) : ?>
                    <div class="col border">
                        <center>
                            <h3><?= $k->kode_kursi; ?></h3>
                            Rp.75.000
                            <br>
                            <br>
                            <a href="<?= base_url('cart/create_action/') . $k->id . "/" . $k->id_tiket . "/75000"; ?>"><button class="btn btn-primary btn-sm">Pesan</button></a>
                        </center>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <br>
        <br><br><br>
        <div>
            <center>
                <h2>TIKET REGULER</h2>
            </center>
            <div class="row">

                <?php foreach ($reguler as $k) : ?>
                    <div class="col border">
                        <center>
                            <h3><?= $k->kode_kursi; ?></h3>
                            Rp.50.000
                            <br>
                            <br>
                            <a href="<?= base_url('cart/create_action/') . $k->id . "/" . $k->id_tiket . "/50000"; ?>"><button class="btn btn-primary btn-sm">Pesan</button></a>
                        </center>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <br>
        <br><br><br>
        <div>
            <center>
                <h2>TIKET EKONOMI</h2>
            </center>
            <div class="row">

                <?php foreach ($ekonomi as $k) : ?>
                    <div class="col border">
                        <center>
                            <h3><?= $k->kode_kursi; ?></h3>
                            Rp.25.000
                            <br>
                            <br>
                            <a href="<?= base_url('cart/create_action/') . $k->id . "/" . $k->id_tiket . "/25000"; ?>"><button class="btn btn-primary btn-sm">Pesan</button></a>
                        </center>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>