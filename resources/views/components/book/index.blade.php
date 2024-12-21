@extends('layout.dashboard')
<div>woi</div>
@endsection

{{-- <script>
    document.addEventListener("alpine:init", () => {
        Alpine.store("dataStore", {
            books: [],
            searchQuery: "",
            loading: false,

            async fetch() {
                this.loading = true;
                const queryParam = this.searchQuery ? `?search=${this.searchQuery}` : "";
                try {
                    const response = await fetch(`/books${queryParam}`);
                    const data = await response.json();
                    this.books = data.data;
                } catch (error) {
                    console.error("Error fetching books:", error);
                } finally {
                    this.loading = false;
                }
            },

            setSearch(query) {
                this.searchQuery = query;
                this.fetch();
            }
        });
    });
</script> --}}
