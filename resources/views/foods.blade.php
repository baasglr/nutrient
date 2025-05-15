@extends('layouts.app')
@section('title', 'About')

@section('content')
    <script>
        const isIntegerGreaterThanZero = (value) => {
            try {
                const integer = parseInt(value);
                return integer > 0;
            } catch (e) {
                return false;
            }
        }

        function selectFood(e, food) {
            const item = localStorage.getItem("selected");
            let selectedFoods = item ? JSON.parse(item) : [];
            if (e.target.checked) {
                const popupOverlay = document.getElementById('popupOverlay');
                popupOverlay.classList.add('active');
                const quantityInput = document.getElementById('quantityInput');
                quantityInput.value = '';
                quantityInput.focus();

                const closePopup = document.getElementById('closePopup');
                closePopup.onclick = () => {
                    e.target.checked = false;
                    popupOverlay.classList.remove('active');
                };

                document.getElementById('submitQuantity').onclick = async() => {
                    const quantity = quantityInput.value;
                    popupOverlay.classList.remove('active');
                    if (isIntegerGreaterThanZero(quantity)) {
                        food.quantity = parseInt(quantity);

                        const response = await fetch(`/json/foods/${food.id}`);
                        food.nutritionFacts = response.json();

                        selectedFoods.push(food);
                        localStorage.setItem("selected", JSON.stringify(selectedFoods));
                        document.dispatchEvent(new CustomEvent('foodSelectionChanged', {detail: selectedFoods}));
                    } else {
                        e.target.checked = false;
                    }
                }
            } else {
                const toRemove = selectedFoods.find(item => item.id === food.id);
                delete toRemove.quantity;
                delete toRemove.nutritionFacts;
                selectedFoods = selectedFoods.filter(item => item.id !== food.id);
                localStorage.setItem("selected", JSON.stringify(selectedFoods));
                document.dispatchEvent(new CustomEvent('foodSelectionChanged', {detail: selectedFoods}));
            }
        }
    </script>

    <div class="flex justify-center my-4">
        <input type="text" id="search"
               class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
               placeholder="Search...">
    </div>

    <table id="foods" class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th></th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Food (100g)</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Protein</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Carbs</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sugar</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fat</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saturated Fat
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fiber</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ash</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($foods as $food)
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <form>
                        <input type="checkbox" name="food-{{$food->id}}" id="food-{{$food->id}}"
                               onchange="selectFood(event, {{Js::from($food)}})"/>
                    </form>
                </th>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="/foods/{{$food->id}}">{{$food->name}}</a>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">{{$food->protein}}g</td>
                <td class="px-6 py-4 whitespace-nowrap">{{$food->carbs}}g</td>
                <td class="px-6 py-4 whitespace-nowrap">{{$food->sugar}}g</td>
                <td class="px-6 py-4 whitespace-nowrap">{{$food->fat}}g</td>
                <td class="px-6 py-4 whitespace-nowrap">{{$food->saturated_fat}}g</td>
                <td class="px-6 py-4 whitespace-nowrap">{{$food->fiber}}g</td>
                <td class="px-6 py-4 whitespace-nowrap">{{$food->ash}}g</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div id="popupOverlay" class="overlay">
        <div class="bg-white p-6 rounded shadow-lg text-center">
            <h2 class="text-2xl font-bold mb-4">Enter Quantity</h2>
            <input type="number" id="quantityInput" class="border border-gray-300 p-2 rounded w-full mb-4"
                   placeholder="Enter quantity in grams">
            <button id="submitQuantity" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Submit
            </button>
            <button id="closePopup" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 mt-2">Close</button>
        </div>
    </div>

    <script>
        const search = document.getElementById('search');
        const foods = Array.from(document.querySelectorAll('#foods > tbody > tr'));
        search.onkeyup = () => {
            const needle = search.value.toLowerCase();
            for (const row of foods) {
                const foodName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (foodName.indexOf(needle) >= 0) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            }
        };

        const item = localStorage.getItem("selected");
        let selectedFoods = item ? JSON.parse(item) : [];
        for (const food of selectedFoods) {
            const selectBox = document.getElementById(`food-${food.id}`);
            if (selectBox) {
                selectBox.checked = true;
            }
        }

        document.dispatchEvent(new CustomEvent('foodSelectionChanged', {detail: selectedFoods}));
    </script>
@endsection
