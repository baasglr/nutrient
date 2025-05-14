<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white text-lg font-bold">Nutrient</div>
        <div class="block lg:hidden">
            <button id="nav-toggle" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
        <ul id="nav-menu" class="hidden lg:flex lg:items-center lg:space-x-4">
            <li>
                <a class="text-white px-3 py-2 rounded-md text-sm font-medium {{request()->routeIs('potatoes_and_tubers') ? 'bg-gray-900' : 'hover:bg-gray-700'}}" href="/potatoes_and_tubers">Potatoes & Tubers</a>
            </li>
            <li>
                <a class="text-white px-3 py-2 rounded-md text-sm font-medium {{request()->routeIs('vegetables') ? 'bg-gray-900' : 'hover:bg-gray-700'}}" href="/vegetables">Vegetables</a>
            </li>
            <li>
                <a class="text-white px-3 py-2 rounded-md text-sm font-medium {{request()->routeIs('fruits') ? 'bg-gray-900' : 'hover:bg-gray-700'}}" href="/fruits">Fruits</a>
            </li>
            <li>
                <a class="text-white px-3 py-2 rounded-md text-sm font-medium {{request()->routeIs('meat') ? 'bg-gray-900' : 'hover:bg-gray-700'}}" href="/meat">Meat</a>
            </li>
            <li>
                <a class="text-white px-3 py-2 rounded-md text-sm font-medium {{request()->routeIs('fats_and_oils') ? 'bg-gray-900' : 'hover:bg-gray-700'}}" href="/fats_and_oils">Fats & Oils</a>
            </li>
            <li>
                <a class="text-white px-3 py-2 rounded-md text-sm font-medium {{request()->routeIs('nuts_and_seeds') ? 'bg-gray-900' : 'hover:bg-gray-700'}}" href="/nuts_and_seeds">Nuts & Seeds</a>
            </li>
            <li>
                <a class="text-white px-3 py-2 rounded-md text-sm font-medium {{request()->routeIs('legumes') ? 'bg-gray-900' : 'hover:bg-gray-700'}}" href="/legumes">Legumes</a>
            </li>
        </ul>
    </div>
</nav>

<script>
    document.getElementById('nav-toggle').addEventListener('click', function() {
        let navMenu = document.getElementById('nav-menu');
        navMenu.classList.toggle('hidden');
    });
</script>
