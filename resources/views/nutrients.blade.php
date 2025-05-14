@extends('layouts.app')
@section('title', 'About')

<script>
    const app = {{ Js::from($data) }};
    console.log(app);
</script>


@section('content')
<div class="flex justify-center my-4">
    <input type="text" id="search" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search...">
</div>

<table id="foods" class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
    <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Food</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Protein</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carbs</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sugar</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fat</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saturated Fat</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fiber</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ash</th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @foreach($data as $record)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">
                <a href="/foods/{{$record->id}}">{{$record->food}}</a>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{$record->protein}}g</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$record->carbs}}g</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$record->sugar}}g</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$record->fat}}g</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$record->saturated_fat}}g</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$record->fiber}}g</td>
            <td class="px-6 py-4 whitespace-nowrap">{{$record->ash}}g</td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    const search = document.getElementById('search');
    const foods = Array.from(document.querySelectorAll('#foods > tbody > tr'));
    search.onkeyup = () => {
        const needle = search.value.toLowerCase();
        for(const row of foods) {
            const foodName = row.querySelector('td').textContent.toLowerCase();
            if(foodName.indexOf(needle) >= 0) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        }
    };
</script>
@endsection
