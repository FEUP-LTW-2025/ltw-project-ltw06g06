
let selectedServiceId;

document.querySelectorAll('.user-item').forEach(item => {
  item.addEventListener('click', async () => {
    const userId = item.dataset.userId;
    selectedServiceId = item.dataset.serviceId;
    selectedRequestId = item.dataset.requestId;

    // Load messages from API
    const response = await fetch(`../api/api_get_messages.php?user_id=${userId}&service_id=${selectedServiceId}&request_id=${selectedRequestId}`);
    const messages = await response.json();

    const messagesDiv = document.getElementById('messages');
    messagesDiv.innerHTML = '';

    if (messages.length === 0) {
      messagesDiv.innerHTML = '<p>No messages yet.</p>';
    }

    messages.forEach(msg => {
      const div = document.createElement('div');
      div.classList.add('message');
      div.classList.add(msg.senderId == userId ? 'received' : 'sent');
      div.innerHTML = `
        ${replace(msg.message)}<br>
        <small>${msg.timestamp}</small>
      `;
      messagesDiv.appendChild(div);
    });

    // Update hidden input in the form
    document.querySelector('input[name="receiverId"]').value = userId;
    document.querySelector('input[name="serviceId"]').value = selectedServiceId;
    document.querySelector('input[name="requestId"]').value = selectedRequestId;


    // Scroll to latest message
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
  });
});

document.getElementById('chat-form').addEventListener('submit', async function(event) {
  event.preventDefault(); // Stop normal form submit

  const form = event.target;
  const formData = new FormData(form);
  
  const response = await fetch('../actions/action_send_message.php', {
    method: 'POST',
    body: formData
  });

  if (response.ok) {
    const messageText = formData.get('message');

    // Append new message to the message list
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', 'sent');
    messageDiv.innerHTML = `
      ${replace(messageText)}<br>
      <small>Now</small>
    `;

    const messages = document.getElementById('messages');
    messages.appendChild(messageDiv);

    // Scroll to bottom
    messages.scrollTop = messages.scrollHeight;

    // Clear input
    form.message.value = '';
  } else {
    alert('Failed to send message');
  }
  loadMessages();
});


async function loadMessages() {

const receiverId = document.querySelector('input[name="receiverId"]').value;
const requestId = document.querySelector('input[name="requestId"]').value;
const serviceId = document.querySelector('input[name="serviceId"]').value;

  const response = await fetch(`../api/api_get_messages.php?user_id=${receiverId}&request_id=${requestId}`);
  const messages = await response.json();

  const messagesContainer = document.getElementById('messages');
  if(messages.length !== 0){
  messagesContainer.innerHTML = '';

  messages.forEach(msg => {
    const div = document.createElement('div');
    div.className = 'message ' + (msg.senderId == receiverId ? 'received' : 'sent');
    div.innerHTML = `
      ${replace(msg.message)}<br>
      <small>${msg.timestamp}</small>
    `;
    messagesContainer.appendChild(div);
  });
    }

}

setInterval(loadMessages, 2000);
loadMessages();

