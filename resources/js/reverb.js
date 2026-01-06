const socket = new WebSocket('ws://localhost:8080/app/{{ config("reverb.apps.0.key") }}');

socket.onopen = () => {
    console.log('✅ Connected to Reverb');
};

socket.onmessage = (event) => {
    const data = JSON.parse(event.data);
    console.log('📩 Realtime event:', data);
};

socket.onerror = (e) => {
    console.error('❌ Reverb error', e);
};