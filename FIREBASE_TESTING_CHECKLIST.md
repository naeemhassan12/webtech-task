# Firebase Integration Testing Checklist

## ✅ Pre-Testing Setup

### 1. Update Firebase Security Rules
- [ ] Go to [Firebase Console](https://console.firebase.google.com/)
- [ ] Select project: **chart-595b3**
- [ ] Navigate to: **Realtime Database → Rules**
- [ ] Paste this rule:
```json
{
  "rules": {
    ".read": true,
    ".write": true
  }
}
```
- [ ] Click **Publish**
- [ ] Confirm "Rules published successfully" message

### 2. Verify Files Exist
- [ ] `/public/js/firebase-config.js` exists
- [ ] `/resources/views/active-task/index.blade.php` updated
- [ ] `/resources/views/pending/index.blade.php` updated

### 3. Clear Browser Cache
- [ ] Press `Ctrl + Shift + Delete` (Windows) or `Cmd + Shift + Delete` (Mac)
- [ ] Clear cached images and files
- [ ] Close and reopen browser

---

## 🧪 Testing Active Tasks Page

### Test 1: Page Loads Correctly
- [ ] Login as **admin** or **superadmin**
- [ ] Navigate to **Active Tasks** page
- [ ] Verify page loads without errors
- [ ] Open browser console (F12) - check for errors

### Test 2: Chart Displays
- [ ] Scroll to bottom of page
- [ ] Verify blue chart card is visible
- [ ] Chart title shows: "Task Distribution Chart"
- [ ] Chart has blue bars (#34b7f1 color)

### Test 3: Add Member to Task
- [ ] Click **"Member Manage"** button
- [ ] Modal opens with user list
- [ ] Click **"Add"** next to a user
- [ ] Button changes to **"Remove"**
- [ ] User name appears in task header
- [ ] **Success toast** appears (top-right)
- [ ] **Chart updates automatically** (within 1-2 seconds)

### Test 4: Remove Member from Task
- [ ] In modal, click **"Remove"** next to added user
- [ ] Button changes to **"Add"**
- [ ] User name disappears from task header
- [ ] **Success toast** appears
- [ ] **Chart updates automatically**

### Test 5: Verify Firebase Data
- [ ] Go to [Firebase Console](https://console.firebase.google.com/)
- [ ] Navigate to: **Realtime Database → Data**
- [ ] Expand `users/` node
- [ ] Find your user ID
- [ ] Verify `tasks/active/` contains task data
- [ ] Expand `userSummary/` node
- [ ] Verify user has correct task counts

### Test 6: Chart Tooltip
- [ ] Hover over a bar in the chart
- [ ] Tooltip appears showing:
  - User name
  - Total tasks
  - Active tasks
  - Pending tasks

---

## 🧪 Testing Pending Tasks Page

### Test 1: Page Loads Correctly
- [ ] Navigate to **Pending Tasks** page
- [ ] Verify page loads without errors
- [ ] Open browser console (F12) - check for errors

### Test 2: Chart Displays
- [ ] Scroll to bottom of page
- [ ] Verify green chart card is visible
- [ ] Chart title shows: "Task Distribution Chart"
- [ ] Chart has green bars (#28a745 color)

### Test 3: Add Member to Task
- [ ] Click **"Member Manage"** button
- [ ] Click **"Add"** next to a user
- [ ] Verify button changes to **"Remove"**
- [ ] Verify user appears in task header
- [ ] Verify success toast
- [ ] **Verify chart updates automatically**

### Test 4: Remove Member from Task
- [ ] Click **"Remove"** next to added user
- [ ] Verify button changes to **"Add"**
- [ ] Verify user disappears from header
- [ ] Verify success toast
- [ ] **Verify chart updates automatically**

### Test 5: Verify Firebase Data
- [ ] Go to Firebase Console → Data
- [ ] Check `users/{userId}/tasks/pending/`
- [ ] Verify task data exists
- [ ] Check `userSummary/{userId}`
- [ ] Verify pending task count is correct

---

## 🧪 Real-Time Sync Testing

### Test 1: Multiple Browser Windows
- [ ] Open two browser windows side-by-side
- [ ] Login as admin in both
- [ ] Window 1: Active Tasks page
- [ ] Window 2: Pending Tasks page
- [ ] Add member in Window 1
- [ ] **Verify chart updates in BOTH windows**

### Test 2: Firebase Console Live Updates
- [ ] Open Firebase Console → Data tab
- [ ] Open your app in another tab
- [ ] Add/remove members
- [ ] **Watch Firebase data update in real-time**

---

## 🧪 Browser Console Testing

### Test 1: Import Firebase Functions
Open browser console (F12) and run:

```javascript
// Test import
import { getUserTaskData } from '/js/firebase-config.js';
console.log('Import successful!');
```

**Expected:** No errors

### Test 2: Fetch User Data
```javascript
import { getUserTaskData } from '/js/firebase-config.js';
getUserTaskData().then(data => console.log('User Data:', data));
```

**Expected:** Array of user objects with task counts

### Test 3: Listen to Real-Time Updates
```javascript
import { listenToUserTaskData } from '/js/firebase-config.js';
listenToUserTaskData(data => console.log('Real-time update:', data));
```

**Expected:** Logs data whenever Firebase changes

### Test 4: Manual Add Task (Advanced)
```javascript
import { addUserTaskToFirebase } from '/js/firebase-config.js';
addUserTaskToFirebase('1', 'Test User', '999', 'active', 'Test Task', 'Test Client');
```

**Expected:** 
- Console logs: "Task 999 added to user Test User in Firebase"
- Firebase Console shows new data
- Chart updates automatically

---

## ❌ Common Issues & Solutions

### Issue: Chart Not Showing
**Check:**
- [ ] Browser console for errors
- [ ] Google Charts library loaded (check Network tab)
- [ ] Chart container div exists: `google_chart` or `google_chart_pending`

**Solution:**
- Hard refresh: `Ctrl + Shift + R`
- Clear cache and reload

### Issue: "Permission Denied" Error
**Check:**
- [ ] Firebase rules are set to open access
- [ ] Rules are published

**Solution:**
- Update Firebase rules to:
```json
{
  "rules": {
    ".read": true,
    ".write": true
  }
}
```

### Issue: Chart Not Updating
**Check:**
- [ ] Browser console for Firebase errors
- [ ] Network tab for Firebase connections
- [ ] `listenToUserTaskData()` is being called

**Solution:**
- Check Firebase configuration in `/js/firebase-config.js`
- Verify Firebase project is active

### Issue: Module Import Error
**Check:**
- [ ] File path is correct: `/js/firebase-config.js`
- [ ] File exists in `/public/js/firebase-config.js`
- [ ] Script tag has `type="module"`

**Solution:**
- Verify file location
- Check server is serving static files correctly

### Issue: Data Not Syncing to Firebase
**Check:**
- [ ] Firebase rules allow write access
- [ ] Network tab shows Firebase requests
- [ ] No JavaScript errors blocking execution

**Solution:**
- Check browser console for errors
- Verify Firebase configuration
- Test with manual add (see Browser Console Testing)

---

## 📊 Expected Results

### After Adding a Member:
1. ✅ Button changes from "Add" to "Remove"
2. ✅ User name appears in task header
3. ✅ Success toast shows
4. ✅ Firebase data updated (check console)
5. ✅ Chart bar increases by 1
6. ✅ Chart updates within 1-2 seconds

### After Removing a Member:
1. ✅ Button changes from "Remove" to "Add"
2. ✅ User name disappears from header
3. ✅ Success toast shows
4. ✅ Firebase data removed (check console)
5. ✅ Chart bar decreases by 1
6. ✅ Chart updates within 1-2 seconds

### Chart Appearance:
- ✅ **Active Tasks:** Blue bars (#34b7f1)
- ✅ **Pending Tasks:** Green bars (#28a745)
- ✅ Bars sorted by task count (highest first)
- ✅ Smooth animation when updating
- ✅ Tooltip shows breakdown on hover

---

## 🎯 Success Criteria

**Integration is successful if:**
- [ ] All tests pass without errors
- [ ] Charts display correctly on both pages
- [ ] Adding members updates chart automatically
- [ ] Removing members updates chart automatically
- [ ] Firebase Console shows correct data
- [ ] Tooltips show accurate task breakdown
- [ ] No JavaScript errors in console
- [ ] Real-time sync works across multiple windows

---

## 📝 Testing Notes

**Date Tested:** _______________
**Tested By:** _______________
**Browser:** _______________
**Issues Found:** 

_______________________________________________
_______________________________________________
_______________________________________________

**Status:** ⬜ Pass | ⬜ Fail | ⬜ Needs Review

---

## 🆘 If All Tests Fail

1. **Check Firebase Project Status**
   - Go to Firebase Console
   - Verify project is active
   - Check billing status (if applicable)

2. **Verify Configuration**
   - Check `/js/firebase-config.js`
   - Verify API key and project ID
   - Test with Firebase Console directly

3. **Check Laravel Routes**
   - Verify `/active/{task}/add-member/{user}` route exists
   - Verify `/pending/{task}/add-member/{user}` route exists
   - Test routes with Postman/Insomnia

4. **Review Documentation**
   - Read `FIREBASE_INTEGRATION_GUIDE.md`
   - Check `FIREBASE_RULES.md`
   - Review `FIREBASE_SUMMARY.md`

---

**Last Updated:** 2026-02-09
**Version:** 1.0
