<!DOCTYPE html>
<html>
<head>
    <title>Tittle</title>
    <style type="text/css" media="print">
    @page {
        margin: 0;  /* this affects the margin in the printer settings */
    }
      table{
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
      }
      table th{
          -webkit-print-color-adjust:exact;
        border: 1px solid;

                padding-top: 11px;
    padding-bottom: 11px;
    background-color: #a29bfe;
      }
   table td{
        border: 1px solid;

   }
        </style>
</head>
<body>
    <h3 align="center">DATA Jual</h3>
    <h4>Tanggal Cetak : <?= date("d/M/Y");?> </h4>
    <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Id Penjualan</th>
		<th>Tgl Transaksi</th>
		<th>Id Tiket</th>
		<th>Id Kursi</th>
		<th>Harga</th>
		
            </tr><?php
            foreach ($jual_data as $jual)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $jual->id_penjualan ?></td>
		      <td><?php echo $jual->tgl_transaksi ?></td>
		      <td><?php echo $jual->id_tiket ?></td>
		      <td><?php echo $jual->id_kursi ?></td>
		      <td><?php echo $jual->harga ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
</body>
<script type="text/javascript">
      window.print()
    </script>
</html>