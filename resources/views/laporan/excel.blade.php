<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
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

        th:first-child,
        td:first-child {
            width: 204px;
        }

        th:not(:first-child),
        td:not(:first-child) {
            width: 100px;
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

    <h3>Laporan Stok Bahan ({{ $periodeLabel }}) - {{ $section }}</h3>

    @php
        use Carbon\Carbon;
        use Carbon\CarbonPeriod;

        $isYearly = $startDate->format('Y-m-d') === Carbon::create($startDate->year, 1, 1)->format('Y-m-d') &&
            $endDate->format('Y-m-d') === Carbon::create($endDate->year, 12, 31)->format('Y-m-d');

        $range = $isYearly
            ? collect(range(1, 12))->map(fn($m) => Carbon::create(null, $m, 1))
            : CarbonPeriod::create($startDate, $endDate);
    @endphp


    @foreach($allHistories as $index => $item)
        @php
            $bahan = $item['bahan'];
            $history = $item['history'];
            $bahanName = $bahan->name . ' (' . ($bahan->satuan->name ?? '') . ')';
        @endphp

        <div><strong>{{ $index + 1 }}. {{ $bahanName }}</strong></div>

        <table>
            <thead>
                <tr>
                    <th class="no-border"></th>
                    @foreach ($range as $date)
                        <th>
                            {{ $isYearly ? $date->translatedFormat('F') : $date->format('j') }}
                        </th>
                    @endforeach
                    <th></th>
                    <th>{{ $bahan->name }}</th>
                    <th>({{ $bahan->satuan->name }})</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $types1 = ['Awal', 'Masuk', 'Terpakai', 'Sisa'];
                @endphp

                @foreach ($types1 as $type)
                    @php
                        $lower = strtolower($type);
                        $total = collect($history)->sum(fn($day) => $day[$lower] ?? 0);
                    @endphp
                    <tr>
                        <td class="indent">{{ $type }}</td>
                        @foreach ($history as $dayData)
                            <td>{{ $dayData[$lower] }}</td>
                        @endforeach
                        <td></td>
                        <td>
                            @if (in_array($type, ['Masuk', 'Terpakai']))
                                {{ $total }}
                            @endif
                        </td>
                        <td>
                            @if ($type === 'Masuk') Beli
                            @elseif ($type === 'Terpakai') Terpakai
                            @endif
                        </td>
                    </tr>
                @endforeach

                <tr class="no-border">
                    <td colspan="{{ count($range) + 4 }}">&nbsp;</td>
                </tr>

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
                            <td>{{ $dayData[$lower] }}</td>
                        @endforeach
                        <td></td>
                        <td>
                            @if ($type === 'Terbuang')
                                {{ $total }}
                            @endif
                        </td>
                        <td>
                            @if ($type === 'Terbuang') Terbuang @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br>
    @endforeach

</body>

</html>