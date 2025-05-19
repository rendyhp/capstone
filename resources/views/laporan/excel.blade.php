<!DOCTYPE html>
<html>

<head>
    @php
        use Carbon\Carbon;
        $bulanNama = Carbon::create()->month($month)->locale('id')->isoFormat('MMMM');
    @endphp
    <meta charset="UTF-8">
    <title>Data Stok Bahan {{ $bulanNama }}</title>
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

        .bordered td {
            border: 1px solid #000 !important;
        }

        .no-border td {
            border: none !important;
        }
    </style>

</head>

<body>


    <h3>Laporan Stok Bahan ({{ $bulanNama }} {{ $year }})</h3>

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
                    <th></th>
                    <th>{{ $bahan->name }}</th>
                    <th>({{ $bahan->satuan->name }})</th>
                </tr>
            </thead>

            <tbody>
                {{-- Baris jenis Awal, Masuk, Terpakai, Sisa --}}
                @php
                    $types1 = ['Awal', 'Masuk', 'Terpakai', 'Sisa'];
                @endphp

                @foreach ($types1 as $type)
                    @php
                        $lower = strtolower($type);
                        $total = collect($history)->sum(fn($day) => $day[$lower] ?? 0);
                    @endphp
                    <tr class="{{ $bahan->name === 'Brown Sugar' ? 'bordered' : '' }}">
                        <td class="indent">{{ $type }}</td>
                        @foreach ($history as $dayData)
                            <td>{{ $dayData[$lower] ?? 0 }}</td>
                        @endforeach
                        <td></td>
                        <td>
                            @if ($type === 'Masuk')
                                {{ $total }}
                            @elseif ($type === 'Terpakai')
                                {{ $total }}
                            @endif
                        </td>
                        <td>
                            @if ($type === 'Masuk')
                                Beli
                            @elseif ($type === 'Terpakai')
                                Terpakai

                            @endif
                        </td>

                    </tr>
                @endforeach



                {{-- Baris kosong --}}
                <tr class="no-border">
                    <td colspan="{{ $daysInMonth + 1 }}">&nbsp;</td>
                </tr>


                {{-- Baris Akhir dan Terbuang --}}
                @php
                    $types2 = ['Akhir', 'Terbuang'];
                @endphp

                @foreach ($types2 as $type)
                    @php
                        $lower = strtolower($type);
                        $total = collect($history)->sum(fn($day) => $day[$lower] ?? 0);
                    @endphp
                    <tr>
                        <td class="indent">{{ $type }}</td>
                        @foreach ($history as $dayData)
                            <td>{{ $dayData[$lower] ?? 0 }}</td>
                        @endforeach
                        <td>
                        </td>
                        <td>
                            @if ($type === 'Terbuang')
                                {{ $total }}
                            @endif
                        </td>
                        <td>
                            @if ($type === 'Terbuang')
                                Terbuang
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <br>
    @endforeach

</body>

</html>