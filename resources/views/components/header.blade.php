<div class="w-full flex justify-end">
    <x-dropdown position="left" class="!p-0 !bg-transparent !border-none !rounded-xl" panelClass="mt-3">
        <x-slot name="buttonSlot">
            <div class="flex items-center  min-w-fit py-2 px-3 gap-2 justify-center rounded-xl bg-white shadow-blur-sm">
                <p class="text-sm">{{ Auth::user()->username }}</p>
                <span class="material-icons">
                    person
                </span>
            </div>
        </x-slot>

        <x-slot name="contentSlot">
            <div>
                <a href="/profil">
                    <button class="w-full p-1 rounded-md bg-gray-200 hover:bg-gray-300 font-medium">Profile</button>
                </a>
            </div>
        </x-slot>
    </x-dropdown>

</div>
