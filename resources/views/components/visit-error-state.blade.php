<div class="flex flex-wrap justify-center items-center w-full h-full gap-1">
    <div class="flex gap-3 items-center">
        <span class="material-symbols-outlined icon-size">
            groups_3
        </span>

        {{ $slot }}
    </div>
</div>

<style scoped>
    .icon-size {
        font-size: 200px;
    }

    @media (max-width: 768px) {
        .icon-size {
            font-size: 150px;
        }
    }
</style>
