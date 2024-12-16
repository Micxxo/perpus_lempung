<div x-data="{ show: true }" x-show="show"
    class="bg-green-500 px-4 py-2 rounded-md text-white min-w-[100px] max-w-[400px] flex items-center gap-2">
    <p>
        {{ $slot }}</p>
    <div class="flex items-center justify-center ">
        <button @click="show = false" class=" flex items-center justify-center">
            <span class="material-symbols-outlined">
                close
            </span>
        </button>
    </div>
</div>
