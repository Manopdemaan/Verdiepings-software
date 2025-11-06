<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Payment Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6 bg-gray-100">

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Welkom, {{ Auth::user()->name }}</h1>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Uitloggen</button>
    </form>
</div>

<h2 class="text-xl mb-4">Laatste betalingen</h2>

@if(isset($payments) && count($payments) > 0)
    <table class="table-auto bg-white rounded shadow-md w-full">
        <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-2">Stripe ID</th>
            <th class="p-2">Bedrag</th>
            <th class="p-2">Status</th>
            <th class="p-2">Datum</th>
            <th class="p-2 text-center">Factuur</th>
        </tr>
        </thead>
        <tbody>
        @foreach($payments as $p)
            <tr class="border-b">
                <td class="p-2">{{ $p->stripe_id }}</td>
                <td class="p-2">€{{ $p->amount }}</td>
                <td class="p-2 capitalize">{{ $p->status }}</td>
                <td class="p-2">{{ $p->created_at->format('d-m-Y H:i') }}</td>
                <td class="p-2 text-center">
                    @if($p->invoice_pdf)
                        <a href="{{ $p->invoice_pdf }}" target="_blank"
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition">
                            Download
                        </a>
                    @else
                        <span class="text-gray-400">Nog niet beschikbaar</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p class="text-gray-500">Nog geen betalingen.</p>
@endif

</body>
</html>
