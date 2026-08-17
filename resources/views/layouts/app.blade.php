<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div>
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    <!-- Chatbot -->
    <div id="chatbot-container" class="fixed bottom-6 right-6 z-50">
        <button id="chatbot-toggle"
            class="bg-blue-600 text-white w-14 h-14 rounded-full shadow-lg">
            💬
        </button>

        <div id="chatbot-box"
            class="hidden w-80 h-96 bg-white rounded-lg shadow-xl mt-3 flex flex-col">

            <div class="bg-blue-600 text-white p-3 rounded-t-lg">
                Library Assistant
            </div>

            <div id="chatbot-messages" class="flex-1 p-3 overflow-y-auto">
                <p>Hello! How can I help you?</p>
            </div>

            <div class="p-3 border-t flex gap-2">
                <input
                    id="chatbot-input"
                    type="text"
                    placeholder="Ask something..."
                    class="flex-1 border rounded px-2 py-1"
                >

                <button
                    id="chatbot-send"
                    class="bg-blue-600 text-white px-3 rounded">
                    Send
                </button>
            </div>
        </div>
    </div>

    @livewireScripts

    <script>
        const toggle = document.getElementById('chatbot-toggle');
        const box = document.getElementById('chatbot-box');
        const send = document.getElementById('chatbot-send');
        const input = document.getElementById('chatbot-input');
        const messages = document.getElementById('chatbot-messages');

        toggle.addEventListener('click', () => {
            box.classList.toggle('hidden');
        });

        send.addEventListener('click', () => {
            const message = input.value.trim();

            if (!message) return;

            messages.innerHTML += `<p class="mt-2"><strong>You:</strong> ${message}</p>`;
            messages.innerHTML += `<p class="mt-2"><strong>Bot:</strong> Hello, I am your library assistant.</p>`;

            input.value = '';
        });
    </script>

</body>

</html>