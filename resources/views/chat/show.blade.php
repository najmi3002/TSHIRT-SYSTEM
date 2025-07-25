<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat for Design #{{ $design->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @php
                        $adminPhone = \App\Models\Setting::get('whatsapp_number', '60123456789');
                        $defaultMessage = urlencode(\App\Models\Setting::get('whatsapp_message', 'Hello admin, saya ingin bertanya tentang produk.'));
                    @endphp
                    <a href="https://wa.me/{{ $adminPhone }}?text={{ $defaultMessage }}" target="_blank" class="inline-block mb-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Chat dengan Admin via WhatsApp
                    </a>

                    <!-- Chat Messages -->
                    <div id="messages" class="h-96 overflow-y-auto mb-4 p-4 border border-gray-300 rounded-lg">
                        @foreach($messages as $message)
                            <div class="mb-4 {{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}">
                                <div class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->sender_id === Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                                    <div class="text-sm font-semibold">{{ $message->sender->name }}</div>
                                    <div class="text-sm">{{ $message->body }}</div>
                                    <div class="text-xs opacity-75 mt-1">{{ $message->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Message Input -->
                    <form id="message-form" class="flex gap-2">
                        @csrf
                        <input type="text" id="message-input" name="body" placeholder="Type your message..." 
                               class="flex-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Scroll to bottom of messages
        function scrollToBottom() {
            const messagesDiv = document.getElementById('messages');
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        // Initial scroll
        scrollToBottom();

        // Handle form submission
        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            
            if (!message) return;

            // Send message via AJAX
            fetch('{{ route("chat.store", $conversation) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ body: message })
            })
            .then(response => response.json())
            .then(data => {
                // Add message to UI
                addMessageToUI(data);
                input.value = '';
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Add message to UI
        function addMessageToUI(message) {
            const messagesDiv = document.getElementById('messages');
            const isOwnMessage = message.sender_id === {{ Auth::id() }};
            
            const messageHtml = `
                <div class="mb-4 ${isOwnMessage ? 'text-right' : 'text-left'}">
                    <div class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${isOwnMessage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'}">
                        <div class="text-sm font-semibold">${message.sender.name}</div>
                        <div class="text-sm">${message.body}</div>
                        <div class="text-xs opacity-75 mt-1">${new Date(message.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'})}</div>
                    </div>
                </div>
            `;
            
            messagesDiv.insertAdjacentHTML('beforeend', messageHtml);
            scrollToBottom();
        }

        // Listen for new messages (if Echo is available)
        if (window.Echo) {
            window.Echo.private('conversation.{{ $conversation->id }}')
                .listen('MessageSent', (e) => {
                    if (e.message.sender_id !== {{ Auth::id() }}) {
                        addMessageToUI(e.message);
                    }
                });
        }
    </script>
</x-app-layout> 