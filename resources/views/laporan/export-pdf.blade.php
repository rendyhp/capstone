<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: DejaVu Sans;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;

        }
        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 12px;
            text-align: center;
            vertical-align: middle;
        }

        td:nth-child(2) {
            text-align: left;
            padding-left: 8px;

        }
        thead tr {
            background-color: #f2f2f2;
        }
    </style>

</head>

<body>
    <h3>Laporan Stok Barang</h3>
    <table>
        <thead class="table-primary">
            <tr>
                <th>No.</th>
                <th>Nama Barang</th>
                <th>Awal</th>
                <th>Masuk</th>
                <th>Total<br>Beli</th>
                <th>Keluar</th>
                <th>Sisa</th>
                <th>Satuan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barang->name }}</td>
                    <td>{{ $barang->awal }}</td>
                    <td>{{ $barang->masuk }}</td>
                    <td>{{ $barang->total_beli }}</td>
                    <td>{{ $barang->keluar }}</td>
                    <td>{{ $barang->sisa }}</td>
                    <td>{{ $barang->satuanBarang->name ?? '-' }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>