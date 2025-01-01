<div class="flex justify-center {{ $containerClass }}">
    <div x-data="{
        open: false,
        toggle() {
            if (this.open) {
                return this.close()
            }
    
            this.$refs.button.focus()
    
            this.open = true
        },
        close(focusAfter) {
            if (!this.open) return
    
            this.open = false
    
            focusAfter && focusAfter.focus()
        }
    }" x-on:keydown.escape.prevent.stop="close($refs.button)"
        x-on:focusin.window="! $refs.panel.contains($event.target) && close()" x-id="['dropdown-button']"
        class="relative w-full">
        <!-- Button -->
        <button x-ref="button" x-on:click="toggle()" :aria-expanded="open" :aria-controls="$id('dropdown-button')"
            type="button"
            class="relative flex items-center whitespace-nowrap justify-center gap-2 py-2 rounded-lg shadow-sm bg-white hover:bg-gray-50 text-gray-800 border border-gray-200 hover:border-gray-200 px-4 {{ $class }}">
            {!! $buttonSlot ?? '<span>Options</span>' !!}
        </button>

        <!-- Panel -->
        <div x-data="{ position: '{{ $position }}' }" x-ref="panel" x-show="open" x-transition.origin.top.left
            x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')" x-cloak
            class="absolute min-w-48 z-50 rounded-lg shadow-sm mt-2 z-10 origin-top-left bg-white p-1.5 outline-none border border-gray-200 {{ $panelClass }}"
            :class="position === 'right' ? 'left-0' : 'right-0'">
            {!! $contentSlot ?? '<span>Options</span>' !!}
        </div>
    </div>
</div>
