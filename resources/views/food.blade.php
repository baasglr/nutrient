@extends('layouts.app')
@section('title', 'About')

@section('content')
<div class="flex justify-center my-4">
    <input type="text" id="search" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search...">
</div>

<h1>{{$foodName}}</h1>
<table id="food" class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
    <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nutrient</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @foreach($nutritionFacts as $record)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{$record->nutrient_group}}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$record->nutrient}}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$record->quantity}}{{$record->unit}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    const search = document.getElementById('search');
    const foods = Array.from(document.querySelectorAll('#food > tbody > tr'));
    search.onkeyup = () => {
        const needle = search.value.toLowerCase();
        for(const row of foods) {
            const foodName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if(foodName.indexOf(needle) >= 0) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        }
    };
</script>
@endsection
