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
    <!-- body -->
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tanggal Transaksi</th>
                    <th scope="col">Kursi</th>
                    <th scope="col">Tiket</th>
                    <th scope="col">Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($keranjang as $k) : ?>
                    <?php
                    $id_tiket = $k->id_tiket;
                    $tiket = $this->db->query("SELECT nama_kategori FROM tiket where id=$id_tiket")->row();
                    $tiket = $tiket->nama_kategori;

                    $id = $k->id_kursi;
                    $kursi = $this->db->query("SELECT kode_kursi FROM kursi where id=$id")->row();
                    $kursi = $kursi->kode_kursi;

                    ?>
                    <tr>
                        <th scope="row">#</th>
                        <td><?= $k->tgl_transaksi; ?></td>
                        <td><?= $kursi; ?></td>
                        <td><?= $tiket; ?></td>
                        <td><?= $k->harga; ?></td>

                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>
        <a href="<?= base_url('jual/checkout'); ?>"><button class="btn btn-primary">Checkout</button></a>


    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>

</html>