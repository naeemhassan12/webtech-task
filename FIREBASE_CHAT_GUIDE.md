# Firebase Real-Time Chat Integration

## 🎉 Overview

The chat system now uses **Firebase Realtime Database** for real-time messaging between team members assigned to tasks. Messages are synced instantly across all users viewing the same task.

---

## ✨ Features

### Real-Time Messaging
- ✅ **Instant sync** - Messages appear immediately for all users
- ✅ **No page refresh** - Real-time updates using Firebase listeners
- ✅ **Persistent storage** - All messages saved in Firebase
- ✅ **Message history** - Previous messages load automatically

### User Experience
- ✅ **Timestamps** - Each message shows send time
- ✅ **User identification** - Shows who sent each message
- ✅ **Sent/Received styling** - Different colors for your messages vs others
- ✅ **Auto-scroll** - Chat scrolls to latest message
- ✅ **Error handling** - Toast notifications for failed sends

---

## 🔧 How It Works

### When You Send a Message:

```
1. User types message and clicks Send
2. Message sent to Firebase: taskChats/{taskId}/messages/{messageId}
3. Firebase saves message with:
   - messageId (unique timestamp)
   - userId (who sent it)
   - userName (sender's name)
   - message (text content)
   - timestamp (when sent)
4. Firebase triggers real-time listener
5. All users viewing the task see the message instantly
```

### Firebase Data Structure:

```
firebase-database/
└── taskChats/
    └── {taskId}/
        └── messages/
            ├── 1707493200000/
            │   ├── messageId: "1707493200000"
            │   ├── userId: "1"
            │   ├── userName: "Naeem Khan"
            │   ├── message: "Hello team!"
            │   ├── timestamp: "2026-02-09T14:30:00Z"
            │   └── timestampMs: 1707493200000
            ├── 1707493210000/
            │   ├── messageId: "1707493210000"
            │   ├── userId: "2"
            │   ├── userName: "Ali"
            │   ├── message: "Hi! Working on it now."
            │   └── ...
            └── ...
```

---

## 🚀 Usage

### For Users:

1. **Go to Active Tasks page**
2. **Type your message** in the input field
3. **Click Send** or press **Enter**
4. **Message appears instantly** for all team members
5. **Other users can reply** and you'll see their messages in real-time

### For Developers:

**Send a message:**
```javascript
import { sendChatMessage } from '/js/firebase-config.js';

await sendChatMessage(
    taskId,        // Task ID
    userId,        // Current user ID
    userName,      // Current user name
    "Hello!"       // Message text
);
```

**Listen to messages:**
```javascript
import { listenToChatMessages } from '/js/firebase-config.js';

listenToChatMessages(taskId, (messages) => {
    // messages is an array of message objects
    messages.forEach(msg => {
        console.log(`${msg.userName}: ${msg.message}`);
    });
});
```

**Get chat history:**
```javascript
import { getChatHistory } from '/js/firebase-config.js';

const history = await getChatHistory(taskId);
console.log('Chat history:', history);
```

---

## 📊 Message Format

Each message object contains:

```javascript
{
    messageId: "1707493200000",           // Unique ID (timestamp)
    userId: "1",                          // Sender's user ID
    userName: "Naeem Khan",               // Sender's name
    message: "Hello team!",               // Message text
    timestamp: "2026-02-09T14:30:00Z",   // ISO timestamp
    timestampMs: 1707493200000            // Milliseconds (for sorting)
}
```

---

## 🎨 Chat Styling

### Sent Messages (Your Messages):
- **Background:** Light green (#dcf8c6)
- **Position:** Right side
- **Label:** Your name

### Received Messages (Others' Messages):
- **Background:** White (#fff)
- **Position:** Left side
- **Label:** Sender's name

### Timestamps:
- **Format:** 12-hour format (e.g., "02:30 PM")
- **Color:** Gray (#888)
- **Size:** Small (0.75rem)

---

## 🔐 Security Considerations

### Current Setup (Development):
- ⚠️ **Open Firebase rules** - Anyone can read/write
- ⚠️ **No message validation** - Any text can be sent
- ⚠️ **No authentication** - Uses Laravel user session

### For Production:

**Update Firebase Rules:**
```json
{
  "rules": {
    "taskChats": {
      "$taskId": {
        "messages": {
          ".read": "auth != null",
          ".write": "auth != null && 
                    root.child('taskMembers').child($taskId).child(auth.uid).exists()"
        }
      }
    }
  }
}
```

**Add Features:**
- ✅ Message validation (max length, no spam)
- ✅ Profanity filter
- ✅ Rate limiting
- ✅ Message editing/deletion
- ✅ Read receipts
- ✅ Typing indicators

---

## 🧪 Testing

### Test Scenario 1: Single User
1. Login as admin
2. Go to Active Tasks page
3. Send a message
4. Message should appear immediately
5. Refresh page - message should still be there

### Test Scenario 2: Multiple Users
1. **User A:** Login and go to Active Tasks
2. **User B:** Login (different browser/incognito) and go to Active Tasks
3. **User A:** Send message "Hello from User A"
4. **User B:** Should see message instantly
5. **User B:** Reply "Hi from User B"
6. **User A:** Should see reply instantly

### Test Scenario 3: Message History
1. Send 5 messages
2. Refresh page
3. All 5 messages should load automatically
4. Messages should be in correct order (oldest first)

---

## 🐛 Troubleshooting

### Messages Not Appearing?

**Check 1: Firebase Rules**
```javascript
// Open browser console (F12) and run:
import { sendChatMessage } from '/js/firebase-config.js';
await sendChatMessage('1', '1', 'Test', 'Hello');
```
If you see "Permission denied" → Update Firebase rules

**Check 2: Task ID**
```javascript
// Check if task ID is set
console.log('Task ID:', '{{ $activeTasks->id ?? "MISSING" }}');
```
If "MISSING" → Task not loaded properly

**Check 3: Browser Console**
- Press F12
- Look for red errors
- Common: "Module not found" → Check `/js/firebase-config.js`

### Messages Duplicating?

- This is prevented by `displayedMessages` Set
- If still happening, clear browser cache
- Check for multiple listeners (shouldn't happen)

### Messages Out of Order?

- Messages sorted by `timestampMs`
- If out of order, check server time sync
- Ensure all servers use same timezone

---

## 📱 Mobile Support

The chat interface is fully responsive:
- ✅ Works on mobile browsers
- ✅ Touch-friendly send button
- ✅ Virtual keyboard support
- ✅ Auto-scroll on new messages

---

## 🎯 Future Enhancements

### Planned Features:
1. **File attachments** - Share images, documents
2. **Emoji support** - Add emoji picker
3. **Message reactions** - Like, love, etc.
4. **Typing indicators** - "User is typing..."
5. **Read receipts** - See who read messages
6. **Message search** - Find old messages
7. **@mentions** - Notify specific users
8. **Message threading** - Reply to specific messages
9. **Voice messages** - Record and send audio
10. **Video calls** - Integrate video chat

### Advanced Features:
- **Message encryption** - End-to-end encryption
- **Message moderation** - Admin controls
- **Chat analytics** - Message statistics
- **Export chat** - Download chat history
- **Chat archive** - Archive old conversations

---

## 📚 API Reference

### Firebase Functions

#### `sendChatMessage(taskId, userId, userName, message)`
Send a message to a task chat.

**Parameters:**
- `taskId` (string) - Task ID
- `userId` (string) - User ID sending message
- `userName` (string) - User name
- `message` (string) - Message text

**Returns:** `Promise<boolean>` - Success status

**Example:**
```javascript
const success = await sendChatMessage('1', '5', 'Ali', 'Hello!');
if (success) console.log('Message sent!');
```

---

#### `listenToChatMessages(taskId, callback)`
Listen to real-time message updates.

**Parameters:**
- `taskId` (string) - Task ID
- `callback` (function) - Called with array of messages

**Returns:** `void`

**Example:**
```javascript
listenToChatMessages('1', (messages) => {
    console.log('New messages:', messages);
});
```

---

#### `getChatHistory(taskId)`
Get all messages for a task (one-time fetch).

**Parameters:**
- `taskId` (string) - Task ID

**Returns:** `Promise<Array>` - Array of message objects

**Example:**
```javascript
const history = await getChatHistory('1');
console.log('Total messages:', history.length);
```

---

#### `deleteChatMessage(taskId, messageId)`
Delete a specific message.

**Parameters:**
- `taskId` (string) - Task ID
- `messageId` (string) - Message ID to delete

**Returns:** `Promise<boolean>` - Success status

**Example:**
```javascript
const success = await deleteChatMessage('1', '1707493200000');
if (success) console.log('Message deleted!');
```

---

## 🔍 Debugging

### Enable Debug Logging:

Add to your script:
```javascript
// Log all Firebase operations
import { database, ref, onValue } from '/js/firebase-config.js';

const messagesRef = ref(database, 'taskChats/1/messages');
onValue(messagesRef, (snapshot) => {
    console.log('Firebase update:', snapshot.val());
});
```

### View Firebase Data:

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Select project: **chart-595b3**
3. Click **Realtime Database** → **Data**
4. Navigate to `taskChats/` → `{taskId}` → `messages/`
5. See all messages in real-time

---

## ✅ Success Criteria

Chat is working correctly if:
- [x] Messages send instantly
- [x] Messages appear for all users
- [x] Messages persist after refresh
- [x] Timestamps show correctly
- [x] Sent/received styling works
- [x] No duplicate messages
- [x] Messages in correct order
- [x] No errors in console

---

## 📝 Files Modified

### Created/Modified:
1. ✅ `/public/js/firebase-config.js` - Added chat functions
2. ✅ `/resources/views/active-task/index.blade.php` - Real-time chat
3. ✅ `/FIREBASE_CHAT_GUIDE.md` - This documentation

### Firebase Structure:
```
taskChats/
  {taskId}/
    messages/
      {messageId}/
        - messageId
        - userId
        - userName
        - message
        - timestamp
        - timestampMs
```

---

**Status:** ✅ Real-Time Chat Fully Implemented
**Last Updated:** 2026-02-09
**Version:** 1.0
