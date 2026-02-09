# Firebase Realtime Database Security Rules

## IMPORTANT: Update These Rules in Firebase Console

### Location
Firebase Console → Realtime Database → Rules Tab

---

## Option 1: Development/Testing (Open Access)
**⚠️ WARNING: Use only for development/testing**

```json
{
  "rules": {
    ".read": true,
    ".write": true
  }
}
```

**Pros:**
- Easy to test
- No authentication required
- Quick setup

**Cons:**
- ❌ Anyone can read your data
- ❌ Anyone can write/delete your data
- ❌ NOT secure for production

---

## Option 2: Authenticated Users Only (Recommended for Production)

```json
{
  "rules": {
    ".read": "auth != null",
    ".write": "auth != null"
  }
}
```

**Pros:**
- ✅ Only authenticated users can access
- ✅ More secure than open access

**Cons:**
- Requires Firebase Authentication setup
- All authenticated users have full access

---

## Option 3: Role-Based Access (Best for Production)

```json
{
  "rules": {
    "users": {
      "$userId": {
        "tasks": {
          ".read": "auth != null && (auth.uid == $userId || root.child('roles').child(auth.uid).val() == 'admin' || root.child('roles').child(auth.uid).val() == 'superadmin')",
          ".write": "auth != null && (root.child('roles').child(auth.uid).val() == 'admin' || root.child('roles').child(auth.uid).val() == 'superadmin')"
        }
      }
    },
    "userSummary": {
      ".read": "auth != null",
      ".write": "auth != null && (root.child('roles').child(auth.uid).val() == 'admin' || root.child('roles').child(auth.uid).val() == 'superadmin')"
    },
    "roles": {
      ".read": "auth != null",
      ".write": false
    }
  }
}
```

**Pros:**
- ✅ Users can only read their own tasks
- ✅ Only admins/superadmins can write
- ✅ Most secure option

**Cons:**
- Requires Firebase Authentication
- Requires role management in Firebase

---

## Quick Start: Which Rule to Use?

### 🚀 Just Testing? 
Use **Option 1** (Open Access)

### 🔒 Going Live Soon?
Use **Option 2** (Authenticated Users)

### 🏢 Production Application?
Use **Option 3** (Role-Based Access)

---

## How to Update Rules

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Select your project: **chart-595b3**
3. Click **Realtime Database** in the left menu
4. Click the **Rules** tab
5. Copy and paste one of the rule sets above
6. Click **Publish**

---

## Testing Your Rules

After updating, test in browser console:

```javascript
// This should work if rules are set correctly
import { getUserTaskData } from '/js/firebase-config.js';
getUserTaskData().then(data => console.log('Success:', data));
```

If you see errors like "Permission denied", your rules are too restrictive.

---

## Current Configuration

**Project ID:** chart-595b3
**Database URL:** https://chart-595b3-default-rtdb.firebaseio.com
**Region:** Default

---

## Need Help?

**Error: "Permission denied"**
- Your rules are too restrictive
- Try Option 1 for testing

**Error: "Network error"**
- Check your internet connection
- Verify Firebase project is active

**Error: "Invalid configuration"**
- Check Firebase config in `/public/js/firebase-config.js`
- Verify API key and project ID

---

**Last Updated:** 2026-02-09
