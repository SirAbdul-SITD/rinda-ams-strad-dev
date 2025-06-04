<?php
require_once('../settings.php');
$userId = $_SESSION['user_id'] ?? null;

// Fetch chat history
$stmt = $pdo->prepare("SELECT message, response, created_at FROM ai_chat_history WHERE user_id = ? ORDER BY id ASC");
$stmt->execute([$userId]);
$chatHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body class="vertical light">
<?php require_once('./lms-header.php'); ?>

<main role="main" class="main-content">
  <div class="chat-wrapper">
    <!-- Chat Messages -->
    <div id="chat-box" class="chat-body">
      <div class="chat-inner">
        <?php foreach ($chatHistory as $chat): ?>
          <div class="chat-msg user">
            <div class="chat-bubble user-bubble"><?= nl2br(htmlspecialchars($chat['message'])) ?></div>
          </div>
          <div class="chat-msg ai">
            <div class="chat-bubble ai-bubble"><?= nl2br(htmlspecialchars($chat['response'])) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Input Bar -->
    <div class="chat-input-container">
      <div class="chat-input">
        <form id="chat-form" autocomplete="off">
          <input type="text" id="user-input" placeholder="Message ..." required />
          <button type="submit" aria-label="Send message">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 2L11 13"></path>
              <path d="M22 2L15 22L11 13L2 9L22 2Z"></path>
            </svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</main>

<style>
  /* Reset and base styles */
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  
  html, body {
    height: 100%;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    background-color: #ffffff;
    color: #000000;
  }
  
  main.main-content {
    height: 100vh;
    display: flex;
    justify-content: center;
    background: #ffffff;
  }
  
  .chat-wrapper {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 800px;
    height: 100vh;
    background: #ffffff;
    position: relative;
  }
  
  .chat-body {
    flex: 1;
    overflow-y: auto;
    padding: 0;
    background: #ffffff;
    scrollbar-width: none;
    -ms-overflow-style: none;
  }
  
  .chat-inner {
    padding: 24px;
    padding-bottom: 150px; /* Increased bottom padding */
    max-width: 800px;
    margin: 0 auto;
    width: 100%;
  }
  
  .chat-body::-webkit-scrollbar {
    display: none;
  }
  
  .chat-msg {
    margin-bottom: 24px;
    max-width: 85%;
    word-break: break-word;
    position: relative;
  }
  
  .chat-msg.user {
    margin-left: auto;
    margin-right: 24px;
  }
  
  .chat-msg.ai {
    margin-right: auto;
    margin-left: 24px;
  }
  
  .chat-bubble {
    padding: 12px 16px;
    border-radius: 18px;
    font-size: 16px;
    line-height: 1.5;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
  }
  
  .user-bubble {
    background: #f0f0f0;
    color: #000000;
    border-bottom-right-radius: 4px;
  }
  
  .ai-bubble {
    background: #ffffff;
    color: #000000;
    border: 1px solid #e5e5e5;
    border-bottom-left-radius: 4px;
  }
  
  .chat-input-container {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #ffffff;
    padding: 16px 24px;
    border-top: 1px solid #e5e5e5;
    display: flex;
    justify-content: center;
  }
  
  .chat-input {
    width: 100%;
    max-width: 800px;
  }
  
  .chat-input form {
    display: flex;
    width: 100%;
    align-items: center;
    margin-left: 180px;
    margin-bottom: 20px;

  }
  
  .chat-input input {
    flex: 1;
    padding: 12px 16px;
    border: 1px solid #e5e5e5;
    border-radius: 24px;
    font-size: 16px;
    outline: none;
    background: #ffffff;
    margin-right: 12px;
    
  }
  
  .chat-input input:focus {
    border-color: blue;
    box-shadow: blue;
  }
  
  .chat-input button {
    background: blue;
    color: white;
    border: none;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .chat-inner {
      padding: 16px;
      padding-bottom: 120px;
    }
    
    .chat-msg {
      margin-bottom: 16px;
    }
    
    .chat-msg.user {
      margin-right: 16px;
    }
    
    .chat-msg.ai {
      margin-left: 16px;
    }
    
    .chat-bubble {
      padding: 10px 14px;
      font-size: 15px;
    }
    
    .chat-input-container {
      padding: 12px 16px;
    }
    
    .chat-input input {
      padding: 10px 14px;
    }
  }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(function() {
    const $chatBox = $('#chat-box');
    const $chatInner = $('.chat-inner');
    const $userInput = $('#user-input');
    
    // Calculate input height and set padding
    function adjustChatPadding() {
      const inputHeight = $('.chat-input-container').outerHeight();
      $chatInner.css('padding-bottom', inputHeight + 40 + 'px');
      scrollToBottom();
    }
    
    // Scroll to bottom
    function scrollToBottom() {
      $chatBox.scrollTop($chatBox.prop("scrollHeight"));
    }
    
    // Initial setup
    adjustChatPadding();
    scrollToBottom();
    
    // Handle form submission
    $('#chat-form').on('submit', function(e) {
      e.preventDefault();
      const message = $userInput.val().trim();
      if (!message) return;
      
      // Add user message
      const userMsg = $('<div class="chat-msg user"><div class="chat-bubble user-bubble"></div></div>');
      userMsg.find('.chat-bubble').text(message);
      $chatInner.append(userMsg);
      $userInput.val('');
      scrollToBottom();
      
      // Add loading indicator
      const loadingMsg = $('<div class="chat-msg ai"><div class="chat-bubble ai-bubble">Thinking...</div></div>');
      $chatInner.append(loadingMsg);
      scrollToBottom();
      
      // Send to server
      $.ajax({
        url: 'chat-handler.php',
        method: 'POST',
        data: { message: message },
        success: function(response) {
          loadingMsg.find('.chat-bubble').text(response);
          scrollToBottom();
        },
        error: function() {
          loadingMsg.find('.chat-bubble').text("Sorry, I couldn't process your request. Please try again.");
          scrollToBottom();
        }
      });
    });
    
    // Allow Enter to submit (Shift+Enter for new line)
    $userInput.on('keydown', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        $('#chat-form').submit();
      }
    });
    
    // Adjust on resize
    $(window).resize(function() {
      adjustChatPadding();
    });
  });
</script>
<?php require_once('./lms-footer.php'); ?>
