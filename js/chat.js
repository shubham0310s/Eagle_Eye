const ws = new WebSocket("ws://localhost:8080");

ws.onopen = () => {
  console.log("WebSocket connected");
};

ws.onmessage = (event) => {
  const data = JSON.parse(event.data);
  const chatBox = document.getElementById("chat-box");
  const newMessage = document.createElement("div");
  newMessage.textContent = `${data.sender_role}: ${data.message}`;
  chatBox.appendChild(newMessage);
  chatBox.scrollTop = chatBox.scrollHeight;
};

document.getElementById("chat-form").addEventListener("submit", (e) => {
  e.preventDefault();

  const message = document.getElementById("message").value;
  const senderId = document.getElementById("sender-id").value;
  const senderRole = document.getElementById("sender-role").value;
  const receiverId = document.getElementById("receiver-id").value;
  const receiverRole = document.getElementById("receiver-role").value;

  ws.send(
    JSON.stringify({
      sender_id: senderId,
      sender_role: senderRole,
      receiver_id: receiverId,
      receiver_role: receiverRole,
      message: message,
    })
  );

  document.getElementById("message").value = "";
});
