<div class="m-5" x-data="{ iW: window.innerWidth }" x-on:resize.window="iW = window.innerWidth">
    <div class="container p-3 mx-auto text-red-700 bg-red-200 border border-red-300 rounded-md shadow-sm xl:hidden">
        Open deze webpagina op een scherm van tenminste 1280px breed. Uw scherm is nu <span x-html="iW"></span> px breed.
    </div>
</div>
