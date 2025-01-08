// Initialize chat functionality
function initializeChat() {
  const chatBox = document.getElementById("chat-messages");
  const chatForm = document.getElementById("chat-form");
  const chatInput = document.getElementById("chat-input");
  const sendButton = document.getElementById("send-button");
  let selectedUser = null;

  // Handle user selection
  function selectUser(userId, userName, userRole) {
    selectedUser = {
      id: userId,
      name: userName,
      role: userRole,
    };
    document.getElementById(
      "chat-messages"
    ).innerHTML = `<p class="text-center">Chat with ${userName}</p>`;
    sendButton.disabled = false;
    loadMessages();
  }

  // Load messages
  function loadMessages() {
    if (!selectedUser) return;

    const formData = new FormData();
    formData.append("action", "get");
    formData.append("user_id", currentUserId);
    formData.append("other_id", selectedUser.id);
    formData.append("society_reg", societyReg);

    fetch("chat_handler.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((messages) => {
        displayMessages(messages);
      });
  }

  // Display messages
  function displayMessages(messages) {
    chatBox.innerHTML = "";
    messages.forEach((msg) => {
      const messageDiv = document.createElement("div");
      messageDiv.className = `message ${
        msg.sender_id === currentUserId ? "outgoing" : "incoming"
      }`;
      messageDiv.innerHTML = `
                <p class="message-content">
                    ${msg.message}
                    <small class="message-time">
                        ${new Date(msg.created_at).toLocaleTimeString()}
                    </small>
                </p>
            `;
      chatBox.appendChild(messageDiv);
    });
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  // Send message
  chatForm.onsubmit = (e) => {
    e.preventDefault();
    if (!selectedUser) return;

    const message = chatInput.value.trim();
    if (!message) return;

    const formData = new FormData();
    formData.append("action", "send");
    formData.append("sender_id", currentUserId);
    formData.append("receiver_id", selectedUser.id);
    formData.append("message", message);
    formData.append("sender_role", currentUserRole);
    formData.append("receiver_role", selectedUser.role);
    formData.append("society_reg", societyReg);

    fetch("chat_handler.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((result) => {
        if (result.status === "success") {
          chatInput.value = "";
          loadMessages();
        }
      });
  };

  // Poll for new messages
  setInterval(loadMessages, 3000);

  // Export necessary functions
  window.selectUser = selectUser;
}

// Initialize when document is ready
document.addEventListener("DOMContentLoaded", initializeChat);
