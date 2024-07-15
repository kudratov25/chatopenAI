Add the openai key in the chat.php file 
 $openaiApiKey = '';
 connect to database and run this code in sql console
 CREATE TABLE chat_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_message TEXT NOT NULL,
    gpt_answer TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Enjoy the chat demo
