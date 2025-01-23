<?php
include("society_dbE.php");

session_start();
if (!isset($_SESSION['m_logged_in'])) {
    header("Location: index.html");
    exit;
}
if (isset($_SESSION['m_name']) && isset($_SESSION['m_email']) && isset($_SESSION['m_flat']) && isset($_SESSION['m_society'])) {
    $mname = $_SESSION['m_name'];
    $memail = $_SESSION['m_email'];
    $msociety = $_SESSION['m_society'];
    $mflat_no = $_SESSION['m_flat'];
    $find = $msociety . "_";
    $mflat = str_replace($find, "", $mflat_no);
} else {
    $mname = "name";
    $memail = "Email@gmail.com";
    $msociety = "0000";
    $mflat = "A000";

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Member Dashboard </title>
    <link rel="shortcut icon" href="img/2.png" type="image/png">
    <link rel="stylesheet" href="css\dashE.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <img src="./img/logo.png" alt="Eagle Eye Logo" style="width: 50px; height: auto;" />
            &emsp;&emsp;&emsp;
            <span class="logo_name">Eagle Eye</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="m_dashboardE.php">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">HOME</span>
                </a>
            </li>

            <li>
                <a href="m_event.php">
                    <i class='bx bx-calendar'></i>
                    <span class="links_name">EVENT</span>
                </a>
            </li>
            <li>
                <a href="m_chat.php" class="active">
                    <i class='bx bx-chat'></i>
                    <span class="links_name">CHAT</span>
                </a>
            </li>
            <li>
                <a href="m_requestE.php">
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">APPROVE/DENIED</span>
                    <?php
                    if (isset($_SESSION[$mflat])) {
                        $num = $_SESSION[$mflat];
                        if ($num) {
                            echo '<span class="material-icons">notifications</span>';
                            echo '<span class="icon-button__badge">' . $num . '</span>';
                        }
                    }
                    ?>
                </a>
            </li>
            <li>
                <a href="m_historyE.php">
                    <i class='bx bx-box'></i>
                    <span class="links_name">HISTORY</span>
                </a>
            </li>

            <li class="log_out">
                <a href="session_unsetE.php">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">CHAT</span>
            </div>
            <!-- This start of account info function -->
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <link
                href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
                rel="stylesheet">
            </head>

            <body>
                <div class="action">
                    <div class="profile" onclick="menuToggle();">
                        <img src="images/host2.png" alt="">
                    </div>

                    <div class="menu">
                        <h3>
                            <?php
                            echo "<div id = 'eagleN'><b>" . $mname . "</b></div>";
                            echo "<div id = 'eagleR'>Member</div>";
                            echo "<div id = 'eagleN'>" . $memail . "</div>";
                            echo "<div id = 'eagleG'>" . $msociety . "</div>";
                            echo "<div id = 'eagleG'>" . $mflat . "</div>";
                            ?>
                        </h3>
                        <ul>
                            <li>
                                <span class="material-icons icons-size">mode</span>
                                <a href="change_passE.php">Edit Password</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <script>
                    function menuToggle() {
                        const toggleMenu = document.querySelector('.menu');
                        toggleMenu.classList.toggle('active')
                    }
                </script>
                <!-- This end of account info function -->
        </nav>

        <div class="home-content">
            <div class="overview-boxes">
                <div id="chat-container"
                    style="display: flex; width: 100%; height: 490px; border: 1px solid #ccc; border-radius: 8px;">
                    <!-- Sidebar for Admin and Watchman Lists -->
                    <div id="sidebar"
                        style="width: 25%; height: 100%; background-color: #f8f9fa; overflow-y: auto; padding: 20px; border-right: 1px solid #ccc; border-radius: 8px 0 0 8px; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">
                        <h3
                            style="text-align: center; font-size: 18px; font-weight: bold; margin-top: 30px; color: #007bff;">
                            Admin</h3>
                        <ul id="admins" style="list-style: none; padding: 0; margin: 0;"></ul>
                        <h3
                            style="text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 15px; color: #007bff;">
                            Members</h3>
                        <ul id="members" style="list-style: none; padding: 0; margin: 0;"></ul>
                        <h3
                            style="text-align: center; font-size: 18px; font-weight: bold; margin-top: 30px; color: #007bff;">
                            Watchmen</h3>
                        <ul id="watchmen" style="list-style: none; padding: 0; margin: 0;"></ul>
                    </div>
                    <!-- Chat Window -->
                    <div id="chat-window"
                        style="flex: 1; padding: 20px; background-color: #f9f9f9; display: flex; flex-direction: column; border-radius: 8px;">
                        <div id="chat-messages"
                            style="flex: 1; overflow-y: auto; padding: 15px; background-color: #fff; border: 1px solid #ccc; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                            <p style="text-align: center; color: #888;">Select a person to start chatting</p>
                        </div>
                        <form id="chat-form" style="display: flex; align-items: center; gap: 10px;">
                            <input type="text" id="chat-input" placeholder="Type your message..."
                                style="flex: 1; padding: 12px; font-size: 16px; border: 1px solid #ccc; border-radius: 8px; outline: none; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); transition: border-color 0.3s;">
                            <button type="submit" id="send-button" disabled
                                style="padding: 12px 20px; background-color: #007bff; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: not-allowed; opacity: 0.6; transition: background-color 0.3s; margin-bottom: 10px;">
                                Send
                            </button>
                        </form>
                    </div>
                </div>
                <style>
                    .message-sent {
                        text-align: right;
                        margin: 5px;
                        background-color: #d9f7d9;
                        padding: 10px;
                        border-radius: 5px;
                    }

                    .message-received {
                        text-align: left;
                        margin: 5px;
                        background-color: #e8e8e8;
                        padding: 10px;
                        border-radius: 5px;
                    }
                </style>
                <script>
                    // Fetch Members from Database
                    fetch('fetch_members.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                const memberList = document.getElementById('members');
                                memberList.innerHTML = ''; // Clear existing list
                                data.data.forEach(member => {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = `${member.m_name} (${member.flat_no})`;
                                    listItem.style = "padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 5px; cursor: pointer;";
                                    listItem.onclick = () => selectUser(member.m_name, member.flat_no, 'Member');
                                    memberList.appendChild(listItem);
                                });
                            } else {
                                console.error(data.message);
                            }
                        })
                        .catch(error => console.error('Error fetching members:', error));

                    // Fetch Watchmen from Database
                    fetch('fetch_watchmen.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                const watchmanList = document.getElementById('watchmen');
                                watchmanList.innerHTML = ''; // Clear existing list
                                data.data.forEach(watchman => {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = `${watchman.w_name}`;
                                    listItem.style = "padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 5px; cursor: pointer;";
                                    listItem.onclick = () => selectUser(watchman.w_name, '', 'Watchman');
                                    watchmanList.appendChild(listItem);
                                });
                            } else {
                                console.error(data.message);
                            }
                        })
                        .catch(error => console.error('Error fetching watchmen:', error));

                    // Fetch Admins from Database
                    fetch('fetch_admins.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                const adminList = document.getElementById('admins');
                                adminList.innerHTML = ''; // Clear existing list
                                data.data.forEach(admin => {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = `${admin.a_name}`;
                                    listItem.style = "padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 5px; cursor: pointer;";
                                    listItem.onclick = () => selectUser(admin.a_name, '', 'Admin');
                                    adminList.appendChild(listItem);
                                });
                            } else {
                                console.error(data.message);
                            }
                        })
                        .catch(error => console.error('Error fetching admins:', error));

                    // Select User Functionality
                    function selectUser(name, flatNo, role) {
                        selectedChatUser = name; // Set selected user
                        currentRole = role; // Set current role
                        document.getElementById('chat-messages').innerHTML = `<p style="text-align: center;">
                                           <strong style="font-weight: bold;">${name}</strong> (${role} ${flatNo ? `Flat: ${flatNo}` : ''}) </p>`;
                        document.getElementById('send-button').disabled = false; // Enable Send Button
                        fetchMessages("<?php echo ($mname); ?>", name); // Fetch chat history
                    }

                    // WebSocket for Real-time Messaging
                    const ws = new WebSocket('ws://localhost:8080/chat');

                    ws.onopen = () => {
                        console.log('WebSocket connected');
                    };

                    ws.onmessage = (event) => {
                        const data = JSON.parse(event.data);
                        if (data.sender_name === selectedChatUser || data.recipient_name === "<?php echo ($mname); ?>") {
                            displayMessage(data.message, data.sender_name, data.timestamp, 'received');
                        }
                    };


                    ws.onerror = (error) => {
                        console.error('WebSocket error:', error);
                    };

                    ws.onclose = () => {
                        console.log('WebSocket closed');
                    };

                    // Sending Messages
                    document.getElementById('chat-form').addEventListener('submit', (e) => {
                        e.preventDefault();
                        const messageInput = document.getElementById('chat-input');
                        const message = messageInput.value.trim();

                        if (message && selectedChatUser) {
                            const messageData = {
                                sender_role: 'Member', // Adjusted sender role
                                sender_name: "<?php echo ($mname); ?>", // Replace with logged-in member's name
                                recipient_role: currentRole,
                                recipient_name: selectedChatUser,
                                message: message,
                            };

                            // Save message to the database
                            fetch('save_message.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify(messageData),
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        displayMessage(message, 'You', new Date().toLocaleString(), 'sent');
                                        messageInput.value = ''; // Clear input field
                                        // Send via WebSocket for real-time update
                                        if (ws.readyState === WebSocket.OPEN) {
                                            ws.send(JSON.stringify(messageData));
                                        }
                                    } else {
                                        alert(`Error: ${data.message}`);
                                    }
                                })
                                .catch(error => console.error('Error saving message:', error));
                        }
                    });


                    // Save message to the database

                    function displayMessage(message, sender, timestamp, type) {
                        const chatMessages = document.getElementById('chat-messages');
                        const newMessage = document.createElement('div');
                        newMessage.className = type === 'sent' ? 'message-sent' : 'message-received';
                        newMessage.innerHTML = `<strong>${sender}</strong> (${timestamp}): <br>${message}`;
                        chatMessages.appendChild(newMessage);
                        chatMessages.scrollTop = chatMessages.scrollHeight; // Auto-scroll
                    }

                    function fetchMessages(senderName, recipientName) {
                        fetch('fetch_messages.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ sender_name: senderName, recipient_name: recipientName }),
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    const chatMessages = document.getElementById('chat-messages');
                                    chatMessages.innerHTML = ''; // Clear previous messages
                                    data.data.forEach(msg => {
                                        displayMessage(msg.message, msg.sender_name, msg.timestamp, msg.sender_role === 'Admin' ? 'received' : 'sent');
                                    });
                                } else {
                                    console.error(data.message);
                                }
                            })
                            .catch(error => console.error('Error fetching messages:', error));
                    }

                </script>

            </div>

        </div>
    </section>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function () {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    </script>

</body>

</html>