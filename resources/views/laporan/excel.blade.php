<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Data Stok Bahan Bulanan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 8px;
            text-align: center;
        }

        th {
            background-color: #ddd;
        }

        .no-border {
            border: none !important;
        }

        .indent {
            padding-left: 20px;
        }

        /* Atur lebar kolom */
        /* Kolom pertama (A) */
        th:first-child,
        td:first-child {
            width: 204px;
            max-width: 204px;
            min-width: 204px;
        }

        /* Kolom kedua sampai terakhir (B - Z) */
        th:not(:first-child),
        td:not(:first-child) {
            width: 100px;
            max-width: 100px;
            min-width: 100px;
        }
    </style>

</head>

<body>
    @php
        use Carbon\Carbon;
        $bulanNama = Carbon::create()->month($month)->locale('id')->isoFormat('MMMM');
    @endphp

    <h3>Laporan Bulanan ({{ $bulanNama }} {{ $year }})</h3>

    @php
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
    @endphp

    @foreach($allHistories as $index => $item)
        @php
            $bahan = $item['bahan'];
            $history = $item['history'];
            $bahanName = $bahan->name . ' (' . ($bahan->satuan->name ?? '') . ')';
        @endphp

        {{-- Nomor dan Nama bahan --}}
        <div><strong>{{ $index + 1 }}. {{ $bahanName }}</strong></div>

        <table>
            <thead>
                <tr>
                    <th class="no-border"></th>
                    @for ($i = 1; $i <= $daysInMonth; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                {{-- Baris jenis Awal, Masuk, Terpakai, Sisa --}}
                @php
                    $types1 = ['Awal', 'Masuk', 'Terpakai', 'Sisa'];
                @endphp
                @foreach ($types1 as $type)
                    <tr>
                        <td class="indent">{{ $type }}</td>
                        @foreach ($history as $dayData)
                            <td>{{ is_array($dayData) && isset($dayData[strtolower($type)]) ? $dayData[strtolower($type)] : 0 }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach

                {{-- Baris kosong --}}
                <tr>
                    <td colspan="{{ $daysInMonth + 1 }}" class="no-border">&nbsp;</td>
                </tr>

                {{-- Baris Akhir dan Terbuang --}}
                @php
                    $types2 = ['Akhir', 'Terbuang'];
                @endphp
                @foreach ($types2 as $type)
                    <tr>
                        <td class="indent">{{ $type }}</td>
                        @foreach ($history as $dayData)
                            <td>{{ $dayData[strtolower($type)] ?? 0 }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br>
    @endforeach

</body>

</html>