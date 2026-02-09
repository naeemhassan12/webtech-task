// Firebase Configuration and Integration
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.9.0/firebase-app.js";
import { getDatabase, ref, set, get, onValue, update, remove } from "https://www.gstatic.com/firebasejs/12.9.0/firebase-database.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/12.9.0/firebase-analytics.js";

// Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyBA9I6mp1iIlw1gjCfOImMACI3GjK_Bles",
    authDomain: "chart-595b3.firebaseapp.com",
    databaseURL: "https://chart-595b3-default-rtdb.firebaseio.com",
    projectId: "chart-595b3",
    storageBucket: "chart-595b3.firebasestorage.app",
    messagingSenderId: "641137339080",
    appId: "1:641137339080:web:fb7d2dae9a7bed664813fd",
    measurementId: "G-E1ET56SPRK"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const database = getDatabase(app);

// Export Firebase utilities
export { database, ref, set, get, onValue, update, remove };

/**
 * Add or update user task assignment in Firebase
 * @param {string} userId - User ID
 * @param {string} userName - User name
 * @param {string} taskId - Task ID
 * @param {string} taskType - 'pending' or 'active'
 * @param {string} taskTitle - Task title
 * @param {string} clientName - Client name
 */
export async function addUserTaskToFirebase(userId, userName, taskId, taskType, taskTitle, clientName) {
    try {
        const userTaskRef = ref(database, `users/${userId}/tasks/${taskType}/${taskId}`);
        await set(userTaskRef, {
            taskId: taskId,
            taskTitle: taskTitle,
            clientName: clientName,
            taskType: taskType,
            assignedAt: new Date().toISOString()
        });

        // Update task count
        await updateUserTaskCount(userId, userName);

        console.log(`Task ${taskId} added to user ${userName} in Firebase`);
        return true;
    } catch (error) {
        console.error('Error adding task to Firebase:', error);
        return false;
    }
}

/**
 * Remove user task assignment from Firebase
 * @param {string} userId - User ID
 * @param {string} userName - User name
 * @param {string} taskId - Task ID
 * @param {string} taskType - 'pending' or 'active'
 */
export async function removeUserTaskFromFirebase(userId, userName, taskId, taskType) {
    try {
        const userTaskRef = ref(database, `users/${userId}/tasks/${taskType}/${taskId}`);
        await remove(userTaskRef);

        // Update task count
        await updateUserTaskCount(userId, userName);

        console.log(`Task ${taskId} removed from user ${userName} in Firebase`);
        return true;
    } catch (error) {
        console.error('Error removing task from Firebase:', error);
        return false;
    }
}

/**
 * Update user task count (pending + active)
 * @param {string} userId - User ID
 * @param {string} userName - User name
 */
async function updateUserTaskCount(userId, userName) {
    try {
        const userTasksRef = ref(database, `users/${userId}/tasks`);
        const snapshot = await get(userTasksRef);

        let pendingCount = 0;
        let activeCount = 0;

        if (snapshot.exists()) {
            const tasks = snapshot.val();
            pendingCount = tasks.pending ? Object.keys(tasks.pending).length : 0;
            activeCount = tasks.active ? Object.keys(tasks.active).length : 0;
        }

        const totalCount = pendingCount + activeCount;

        // Update user summary
        const userSummaryRef = ref(database, `userSummary/${userId}`);
        await set(userSummaryRef, {
            userId: userId,
            userName: userName,
            pendingTasks: pendingCount,
            activeTasks: activeCount,
            totalTasks: totalCount,
            lastUpdated: new Date().toISOString()
        });

        console.log(`Updated task count for ${userName}: ${totalCount} total (${pendingCount} pending, ${activeCount} active)`);
    } catch (error) {
        console.error('Error updating task count:', error);
    }
}

/**
 * Get all users with their task counts for chart display
 * @returns {Promise<Array>} Array of user data
 */
export async function getUserTaskData() {
    try {
        const userSummaryRef = ref(database, 'userSummary');
        const snapshot = await get(userSummaryRef);

        if (snapshot.exists()) {
            const data = snapshot.val();
            return Object.values(data);
        }
        return [];
    } catch (error) {
        console.error('Error getting user task data:', error);
        return [];
    }
}

/**
 * Listen to real-time updates for user task data
 * @param {Function} callback - Callback function to handle data updates
 */
export function listenToUserTaskData(callback) {
    const userSummaryRef = ref(database, 'userSummary');
    onValue(userSummaryRef, (snapshot) => {
        if (snapshot.exists()) {
            const data = snapshot.val();
            callback(Object.values(data));
        } else {
            callback([]);
        }
    });
}

/**
 * Send a chat message to Firebase
 * @param {string} taskId - Task ID
 * @param {string} userId - User ID sending the message
 * @param {string} userName - User name
 * @param {string} message - Message text
 * @returns {Promise<boolean>} Success status
 */
export async function sendChatMessage(taskId, userId, userName, message) {
    try {
        const messageId = Date.now().toString(); // Unique message ID based on timestamp
        const messageRef = ref(database, `taskChats/${taskId}/messages/${messageId}`);

        await set(messageRef, {
            messageId: messageId,
            userId: userId,
            userName: userName,
            message: message,
            timestamp: new Date().toISOString(),
            timestampMs: Date.now()
        });

        console.log(`Message sent to task ${taskId} by ${userName}`);
        return true;
    } catch (error) {
        console.error('Error sending message:', error);
        return false;
    }
}

/**
 * Listen to real-time chat messages for a task
 * @param {string} taskId - Task ID
 * @param {Function} callback - Callback function to handle new messages
 */
export function listenToChatMessages(taskId, callback) {
    const messagesRef = ref(database, `taskChats/${taskId}/messages`);

    onValue(messagesRef, (snapshot) => {
        if (snapshot.exists()) {
            const messages = snapshot.val();
            // Convert to array and sort by timestamp
            const messageArray = Object.values(messages).sort((a, b) => a.timestampMs - b.timestampMs);
            callback(messageArray);
        } else {
            callback([]);
        }
    });
}

/**
 * Get chat history for a task (one-time fetch)
 * @param {string} taskId - Task ID
 * @returns {Promise<Array>} Array of messages
 */
export async function getChatHistory(taskId) {
    try {
        const messagesRef = ref(database, `taskChats/${taskId}/messages`);
        const snapshot = await get(messagesRef);

        if (snapshot.exists()) {
            const messages = snapshot.val();
            // Convert to array and sort by timestamp
            return Object.values(messages).sort((a, b) => a.timestampMs - b.timestampMs);
        }
        return [];
    } catch (error) {
        console.error('Error getting chat history:', error);
        return [];
    }
}

/**
 * Delete a chat message
 * @param {string} taskId - Task ID
 * @param {string} messageId - Message ID to delete
 * @returns {Promise<boolean>} Success status
 */
export async function deleteChatMessage(taskId, messageId) {
    try {
        const messageRef = ref(database, `taskChats/${taskId}/messages/${messageId}`);
        await remove(messageRef);
        console.log(`Message ${messageId} deleted from task ${taskId}`);
        return true;
    } catch (error) {
        console.error('Error deleting message:', error);
        return false;
    }
}

